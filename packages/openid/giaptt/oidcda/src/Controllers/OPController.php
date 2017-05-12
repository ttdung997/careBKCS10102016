<?php

namespace Giaptt\Oidcda\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Giaptt\Oidcda\IdProvider;
use Giaptt\Oidcda\JsonWT;
use Session;
use Giaptt\Oidcda\Authen;
use Response;

/**
*   OPController: xử lý các yêu cầu xác thực user của các trang Relying Party khác,
*   và trả lại id_token.
*/
class OPController extends Controller
{

    /**
    *   authen request from RP
    */
    public function getAuthen(Request $request)
    {
        $response_type = $request->response_type;
        $scope = $request->scope;
        $uri_callback = $request->redirect_url;
        $nonce = $request->nonce;
        $client_id = $request->client_id;

        Session::put('uri_callback', $uri_callback);
        Session::put('nonce', $nonce);
        Session::put('client_id', $client_id);

        // tạo session_id
        $session_id = str_random(32);
        Session::put('sess_id', $session_id);
        // OP check các tham số của authRequest
        // kiểm tra trc đó user đã đăng nhập chưa
        $isClient = DB::table('oidcclients')->where('client_id', $client_id)->first();
        if ($isClient != null) 
        {
            // kiểm tra trc đó user đã đăng nhập chưa
            Session::put('key_encrypt', $isClient->key_secret);
            Session::put('max_age', $isClient->max_age);
            if (Authen::checkLogin()) 
            {
                $email = Authen::getCurrentUser();
                $name = DB::table('users')->where('email', $email)->first()->name;
                $auth_at = time();
                $ss = str_random(32);
                $max_age = $isClient->max_age;
                $info = array(
                    'iss' => config('OpenidConnect.domain'),   // get trong file config OpenidConnect
                    'aud' => $client_id,
                    'email' => $email,
                    'name' => $name,
                    'iat' => $auth_at,
                    'exp' => $auth_at + $max_age * 60, // id_token có hiệu lực trong 'max_age' giờ.
                    'nonce' => $nonce,
                    'session_state' => $ss
                );

                // key dùng để tạo chữ ký signature cho id_token
                $key_encrypt =  $isClient->key_secret; // get trong bảng oidcclients
                $id_token = IdProvider::genIdToken($info, $key_encrypt);
                $uri = $uri_callback . "?id_token=" . $id_token;
                
                return redirect($uri)->withCookie('session_state', $ss .'|'. $client_id, $max_age * 60, '/', null, false, false);
            }
            else
            {
                return view('oidcda::login-with-idp', ['sess_id' => $session_id]);
            }
        }  
    }

    /**
    *   user submit user/pass
    */
    public function postVerifyAcc(Request $request)
    {
        $email = $request->email;
        $pass = $request->_hashPass;

        // get session_id
        $session_id = Session::get('sess_id');
        
        $uri_callback = Session::get('uri_callback');
        $nonce = Session::get('nonce');
        $client_id = Session::get('client_id');

        $key_encrypt = Session::get('key_encrypt'); //key encrypt id_token

        // truy vấn bảng 'admins' vs email = $email
        $isExist = DB::table('users')->where('email', $email)->first();
        if ($isExist != null) 
        {
            $hPass = $isExist->password;
            if ($pass == hash('sha256', $hPass . $session_id) ) 
            {
                // login user manual
                $idUser = $isExist->id;
                Auth::loginUsingId($idUser);

                Session::put('loggedin', $email . '|users');   // session : email|table
                $name = $isExist->name;
                $auth_at = time();
                $ss = str_random(32);   // session state
                $max_age = Session::get('max_age');
                $info = array(
                        'iss' => config('OpenidConnect.domain'), // get trong file config OpenidConnect
                        'aud' => $client_id,
                        'email' => $email,
                        'name' => $name,
                        'iat' => $auth_at,
                        'exp' => $auth_at + $max_age * 60, // id_token có hiệu lực trong 'max_age' giờ.
                        'nonce' => $nonce,
                        'session_state' => $ss
                    );
                $id_token = IdProvider::genIdToken($info, $key_encrypt);
                $uri = $uri_callback . "?id_token=" . $id_token;

                return redirect($uri)->withCookie('session_state', $ss .'|'. $client_id, $max_age * 60, '/', null, false, false);
                
            }
            else
            {
                //dd(false);
                $session_id = str_random(32);
                Session::put('sess_id', $session_id);
                return view('oidcda::login-with-idp', ['sess_id' => $session_id])->with('err', 'Sai email/password !');
            }
        }
        else
        {
            //dd(false);
            $session_id = str_random(32);
            Session::put('sess_id', $session_id);
            return view('oidcda::login-with-idp', ['sess_id' => $session_id])->with('err', 'Sai email/password !');
        }
    }

    /**
    *   Hàm trả về Info của user cho RP
    */
    public function getInfoUser(Request $request)
    {
        $id_token = $request->header('Authorization');

        if (IdProvider::validateIdToken($id_token)) 
        {
            $info = IdProvider::getInfoUser($id_token);
            return Response::json($info);
        }
        $info = [];
        return Response::json(['Token is Invalid!' => $info]);
    }
    
    /**
    *   get các client trong bảng OidcClients trả về dạng Json
    *   @return     Json
    */
    public function listAsJsonClients()
    {
        $clients_list = DB::table('oidcclients')->orderBy('id', 'ASC')->get();
        return Response::json(['data' => $clients_list]);
    }

    /**
    *     hàm xử lý OP remove client khỏi list clients, và gửi thông báo cho client.
    */
    public function deleteClient(Request $request)
    {
        // get domain của client từ view submit
        $client_domain = $request->domain_rp;
        // xóa client khỏi list client, list req
        $rp = DB::table('oidcclients')->where('domain', $client_domain)->first();
        // địa chỉ của RP nhận thông báo này.
        $del_url = $rp->del_endpoint;
        $provider_id = $rp->provider_id;
        $provider_domain = config('OpenidConnect.domain');
        DB::table('oidcclients')->where('domain', $client_domain)->delete();
        DB::table('oidcrequests')->where('domain', $client_domain)->delete();

        // gửi message sang RP để báo rằng OP sẽ xóa acc của RP khỏi OP.
        // message có dạng domain-(hash (domain + provider_id)) : domain của provider
        // RP nhận được sẽ tiến hành check (nếu cần) rồi xóa provider này khỏi list provider của mình.
        $message = $provider_domain . '-' . hash('sha256', $provider_domain . $provider_id);
        $data = [
            'msg_del_client' => $message
        ];

        $curl = curl_init();
            curl_setopt_array($curl, array(
              //CURLOPT_PORT => "8080",
              CURLOPT_URL => $del_url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($data),
              CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "cache-control: no-cache",
                "content-type: application/json"
              ),
            ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) 
        {
          echo "cURL Error at deleteProvider#:" . $err; 
        } 
        else 
        {
          //echo $response;
        }

        return Response::json(['flash_message' => 'Đã xóa Client', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function getAbout()
    {
        return view('oidcda::about-openid');
    }

}
