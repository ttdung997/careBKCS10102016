<?php

namespace Giaptt\Oidcda\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Admin;
use Giaptt\Oidcda\IdProvider;
use Giaptt\Oidcda\JsonWT;
use Session;
use Giaptt\Oidcda\Authen;
use Response;
use Cookie;

/**
*	AuthLocalController: xử lý các request login/logout/register sử dụng tài khoản
*	được đăng ký tại trang này.
*/
class AuthLocalController extends Controller
{

    // login backend
    public function getBackendLogin(Request $request)
    {
        if (Authen::isAdminLogged())
        {
            return redirect('home-admin');
        }
        $session_id = str_random(32);
        Session::put('sess_id', $session_id);
        return view('oidcda::login-backend', ['sess_id' => $session_id]);
    }

    public function postBackendLogin(Request $request)
    {
        $email = $request->email;
        $pass = $request->_hashPass;
        // giá trị pass client gửi lên là: sha256( sha256(pass) + session_id)
        // giá trị session_id sử dụng để chống tấn công phát lại, vì sau khi nó được
        // tạo mới mỗi lần login
        $session_id = Session::get('sess_id');
        
        // truy vấn bảng 'admins' vs email = $email
        $isExist = DB::table('admins')->where('email', $email)->first();
        if ($isExist != null)
        {
            $hPass = $isExist->password;
            if ($pass == hash('sha256', $hPass . $session_id) )
            {
                $idUser = $isExist->admin_id;
                // lưu thông tin đăng nhập vào session
                Session::put('loggedin_admin', $email);   // session : email|table

                Cookie::queue(config('OpenidConnect.name_cookie_admin'), $email . '|' . $idUser, 120);
                return redirect('home-admin');
            }
            else
            {
                //dd(false);
                $session_id = str_random(32);
                Session::put('sess_id', $session_id);
                return view('oidcda::login-backend', ['sess_id' => $session_id])->with('err', 'Sai email/password !');
            }
        }
        else
        {
            //dd(false);
            $session_id = str_random(32);
            Session::put('sess_id', $session_id);
            return view('oidcda::login-backend', ['sess_id' => $session_id])->with('err', 'Sai email/password !');
        }
        
    }

    public function getHomeAdmin()
    {
        return redirect()->route('AdminController.index');
    }
    
    public function getBackendRegister(Request $request)
    {
        return view('oidcda::register-backend');
    }

    public function postBackendRegister(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $pass = $request->_hashPass;
        // pass client submit lên là sha256(pass)
        // server sẽ lưu bản hash này.
        $isExist = DB::table('admins')->where('email', $email)->first();
        if ($isExist == null) 
        {
            DB::table('admins')->insert([
                'name' => $name,
                'email' => $email,
                'password' => $pass
            ]);
            return view('oidcda::register-backend')->with('msg', 'Dang ky tai khoan thanh cong');
        }
        else
        {
            return view('oidcda::register-backend')->with('msg', 'Email nay da ton tai');
        }
    }

    public function getBackendLogout(Request $request)
    {
        Session::forget('loggedin_admin');
        Cookie::queue(Cookie::forget(config('OpenidConnect.name_cookie_admin')));
        return redirect('login');
        //echo "Get Log Out back end";
    }

    public function postBackendLogout(Request $request)
    {
        Session::forget('loggedin_admin');
        Cookie::queue(Cookie::forget(config('OpenidConnect.name_cookie_admin')));
        return redirect('login');
        //echo "Post Log Out back end";
    }

    ////---------------------- Hết phần login, logout back end------------------------------

    ///------------------------ Phần login, logout Front End--------------------------------
    /**
    *   Kiểm tra trc đó user đăng nhập chưa, nếu rồi thì chuyển đến 'home'
    *	không thì hiển thị view 'login'
    */
    public function getLogin()
    {
        if(Authen::isUserLogged())
        {
            $idUser = Authen::getIdUser();
            Auth::loginUsingId($idUser);
            return redirect('home');
        }
    	$session_id = str_random(32);
        Session::put('sess_id', $session_id);

        // get list providers, rồi truyền ra view
        // get tên provider và authen endpoint
        $list_providers = DB::table('oidcproviders')->select('name_provider', 'authen_endpoint')->get()->toArray();
        $array_providers = json_decode(json_encode($list_providers), true);
        Session::put('list_providers', $array_providers);
        return view('oidcda::login', ['sess_id' => $session_id, 'list_op' => $array_providers]);      
    	  
    }

    public function postLogin(Request $request)
    {
    	$email = $request->email;
        $pass = $request->_hashPass;
        // giá trị pass client gửi lên là: sha256( sha256(pass) + session_id)
        // giá trị session_id sử dụng để chống tấn công phát lại, vì sau khi nó được
        // tạo mới mỗi lần login
        $session_id = Session::get('sess_id');
        
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
                $cookie = $email . '|' . $idUser;

                Session::put('loggedin_user', $email);
                
                Cookie::queue(config('OpenidConnect.name_cookie'), $cookie, 120);

                return redirect('home')->withCookie(config('OpenidConnect.name_cookie'), $cookie, 120); 
            }
            else
            {
                $session_id = str_random(32);
                Session::put('sess_id', $session_id);
                $list_providers = Session::get('list_providers');
                return view('oidcda::login', ['sess_id' => $session_id, 'list_op' => $list_providers])
                    ->with('err', 'Sai email/password !');
            }
        }
        else
        {
            //dd(false);
            $session_id = str_random(32);
            Session::put('sess_id', $session_id);
            $list_providers = Session::get('list_providers');
            return view('oidcda::login', ['sess_id' => $session_id, 'list_op' => $list_providers])
                ->with('err', 'Sai email/password !');
        }

    }

    /**
    *   Logout
    */
    public function getLogout()
    {
        
        // sử dụng để logout lúc OP logout init
        Authen::deleteUserExternal();
        Auth::logout();
        $ss = str_random(32); // session_state
        $client_id = Session::get('client_id');
        Session::forget('list_providers');
        Session::forget('loggedin_user');
        Cookie::queue(Cookie::forget(config('OpenidConnect.name_cookie_ex')));
        Cookie::queue(Cookie::forget('accessToken'));
        Cookie::queue(Cookie::forget(config('OpenidConnect.name_cookie')));

        return redirect('login')->withCookie('session_state', $ss .'|'. $client_id, 60, '/', null, false, false)
                ->withCookie(Cookie::forget('accessToken'))
                ->withCookie(Cookie::forget(config('OpenidConnect.name_cookie')))
                ->withCookie(Cookie::forget(config('OpenidConnect.name_cookie_ex')));
    }

    public function postLogout()
    {
        
        // sử dụng để logout lúc OP logout init
        Authen::deleteUserExternal();
        Auth::logout();
        $ss = str_random(32); // session_state
        $client_id = Session::get('client_id');
        Session::forget('list_providers');
        Session::forget('loggedin_user');
        Cookie::queue(Cookie::forget(config('OpenidConnect.name_cookie_ex')));
        Cookie::queue(Cookie::forget('accessToken'));
        Cookie::queue(Cookie::forget(config('OpenidConnect.name_cookie')));

        return redirect('login')->withCookie('session_state', $ss .'|'. $client_id, 60, '/', null, false, false)
                ->withCookie(Cookie::forget('accessToken'))
                ->withCookie(Cookie::forget(config('OpenidConnect.name_cookie')))
                ->withCookie(Cookie::forget(config('OpenidConnect.name_cookie_ex')));

    }


    //---------------------------------------------------------------------
    // Hiện tại đăng ký bệnh nhân, bác sĩ, nhân viên trong AdminController
    /**
	*	Hiển thị view 'register'
    */
    public function getRegister()
    {
        return view('oidcda::register');
    }

    /**
	*	Submit thông tin để đăng ký
    */
    public function postRegister(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $pass = $request->_hashPass;

        $isExist = DB::table('users')->where('email', $email)->first();
        if($isExist == null)
        {
            // DB::table('users')->insert([
            //     'name' => $name,
            //     'email' => $email,
            //     'password' => bcrypt($pass)
            // ]);
            return view('oidcda::register')->with('msg', 'Dang ky tai khoan thanh cong');
        }
        else
            return view('oidcda::register')->with('msg', 'Email nay da ton tai');
    }
    //----------------------------------------------------------------------------------

    /**
    *   Hàm kiểm tra xem trạng thái của user ở bên OP (còn Logged in hay đã Log Out)
    *   Trong view sử dụng JS để poll message sang phía OP để kiểm tra.
    */
    public function checkSessionIframe(Request $request)
    {
        return view('oidcda::check-session');
    }

    // hàm đăng ký OpenID
    public function getRegisterOpenId(Request $request)
    {
        return view('oidcda::register-openid', ['response' => ""]);
    }

    // hàm gửi request đăng ký đến OP
    public function postRegisterOpenId(Request $request)
    {
        $op_reg_url = $request->provider;
        $domain = config('OpenidConnect.domain'); // get trong file config
        $company = $request->cmpny;
        $url_callback = config('OpenidConnect.uri_rp_callback'); // get trong file config
        $url_get_result = config('OpenidConnect.uri_rp_get_result');
        $url_del_endpoint = config('OpenidConnect.delete_endpoint');
        
        // thời gian mặc định là 2 giờ.
        $max_age = 2;
        switch ($request->select_max_age) {
            case '2h':
                break;
            case '4h':
                $max_age = 4;
                break;
            case '8h':
                $max_age = 8;
                break;
            case '1d':
                $max_age = 24;
                break;
            default:
                break;
        }
        // về thuật toán sử dụng để tạo signature cho id_token cũng để mặc định là HS256 = hmac sử dụng sha26
        $algorithm = "HS256";
        $contacts = $request->contacts;

        // kiểm tra trong bảng 'oidcrequests' xem yêu cầu có 'domain' = $op_reg_url chưa ?
        // nếu chưa có thì cho phép gửi request.
        // nếu có rồi thì kiểm tra 'trạng thái' và 'kết quả'
        // if 'trạng thái' = chưa xử lý thì không cho gửi request.
        // else 
        //      if 'kết quả' = 'bị denied' thì cho gửi request.
        $isExist = DB::table('oidcrequests')->where('domain', $op_reg_url)->first();
        $body = [];

        if ($isExist != null)   // đã tồn tại req trong 'list req'
        {
            if ($isExist->isAccept == 0) // req bị từ chối
            {
                // đc phép gửi req mới
                // update lại trạng thái của req trong 'list req'
                DB::table('oidcrequests')->where('domain', $op_reg_url)->update([
                        'status' => false,
                        'isAccept' => -1
                    ]);

                $body = [
                    'domain' => $domain,
                    'company' => $company,
                    'url_callback' => $url_callback,
                    'algorithm' => $algorithm,
                    'max_age' => $max_age,
                    'contacts' => $contacts,
                    'url_get_result' => $url_get_result,
                    'url_delete' => $url_del_endpoint
                ];

                $curl = curl_init();
                curl_setopt_array($curl, array(
                  //CURLOPT_PORT => "8080",
                  CURLOPT_URL => $op_reg_url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => json_encode($body),
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
                  echo "cURL Error at postRegisterOpenId()#:" . $err;
                } 
                else 
                {
                  //echo $response;
                  $data_response = json_decode($response, true);
                  //dd($data_response);
                  return view('oidcda::register-openid', ['response' => $data_response['response_from_op']]);
                }


            }
            elseif($isExist->isAccept == 1) // req đã đc chấp nhận.
            {
                // không cho gửi req mới
                return view('oidcda::register-openid', ['response' => 'request_already_processed']);
            }
            else // req đã gửi và chưa đc xử lý.
            {
                // không cho gửi req mới
                return view('oidcda::register-openid', ['response' => 'request_already_exist']);
            } 
        }
        else // chưa tồn tại
        {
            // cho gửi req mới
            // insert vào 'list req'
            DB::table('oidcrequests')->insert([
                ['domain' => $op_reg_url]
            ]);

            // dùng cURL để gửi req đến OP
            $body = [
                'domain' => $domain,
                'company' => $company,
                'url_callback' => $url_callback,
                'algorithm' => $algorithm,
                'max_age' => $max_age,
                'contacts' => $contacts,
                'url_get_result' => $url_get_result,
                'url_delete' => $url_del_endpoint
            ];

            // gửi yêu cầu register đến register endpoint của OpenId Provider
            // với tập các tham số $body
            $curl = curl_init();
            curl_setopt_array($curl, array(
              //CURLOPT_PORT => "8080",
              CURLOPT_URL => $op_reg_url,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode($body),
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
              echo "cURL Error #:" . $err;
              //return view('oidcda::register-openid', ['response' => 'error']);
            } else 
            {
              //echo $response;
              $data_response = json_decode($response, true);
              //dd($data_response);
              return view('oidcda::register-openid', ['response' => $data_response['response_from_op']]);
            }

        } // end if chưa tồn tại
    } // end function postRegisterOpenId

    // hàm xử lý kết quả của việc đăng ký với OP
    public function postGetResultRegister(Request $request)
    {
        // chuyển trạng thái của yêu cầu có 'domain' = $op_reg_url sang "đã đc xử lý"
        $op_reg_url = $request->registration_endpoint;
        $result = $request->registration_result;
        if($result == 'false')
        {
            DB::table('oidcrequests')->where('domain', $op_reg_url)->update([
                'isAccept' => 0,
                'status' => true
            ]);
        }
        else if($result == 'true')
        {
            DB::table('oidcrequests')->where('domain', $op_reg_url)->update([
                'isAccept' => 1,
                'status' => true
            ]);

            $client_id = $request->client_id;
            $key_secret = $request->key_secret;
            $alg = $request->id_token_signed_response_alg;
            $max_age = $request->max_age;
            $id_provider = $request->provider_id;
            $name_provider = $request->provider_name;
            $domain = $request->provider_domain;
            $authen_endpoint = $request->authen_endpoint;
            $token_endpoint = $request->token_endpoint;
            $delete_endpoint = $request->delete_endpoint;
            $session_endpoint = $request->session_endpoint;
            $info_endpoint = $request->info_endpoint;

            DB::table('oidcproviders')->insert([
                ['id_provider' =>  $id_provider,
                'name_provider' => $name_provider, 
                'domain' => $domain, 
                'registration_endpoint' => $op_reg_url, 
                'authen_endpoint' => $authen_endpoint, 
                'id_token_endpoint' => $token_endpoint,
                'del_endpoint' => $delete_endpoint,
                'session_endpoint' => $session_endpoint,
                'info_endpoint' => $info_endpoint,
                'client_id' => $client_id, 
                'key_secret' => $key_secret, 
                'algorithm' => $alg, 
                'max_age' => $max_age ] 
            ]);        
        }

        return Response::json(['response' => 'da nhan duoc result']);

    }

    // hàm get danh sách các Providers
    public function getListProviders(Request $request)
    {
        $list_role = DB::table('roles')->get();
        // dd($list_role);
        return view('oidcda::get-list-providers',compact('list_role'));
    }

    // hàm get danh sách các Clients
    public function getListClients(Request $request)
    {
        return view('oidcda::get-list-clients');
    }

    // hàm get danh sách các Requests
    public function getListRequests(Request $request)
    {
        return view('oidcda::get-list-requests');
    }

    public function listAsJsonRequests()
    {
        $request_list = DB::table('oidcrequests')->get();
        return Response::json(['data' => $request_list]);
    }

    public function postRemoveOidc(Request $request)
    {
        
        // RP sẽ gửi sang domain-hash(domain + client_id) nếu muốn xóa provider
        $msgFromRP = $request->msg_del_provider;

        // OP sẽ gửi sang domain-hash(domain + provider_id) nếu muốn xóa client
        $msgFromOP = $request->msg_del_client;
        
        if ($msgFromRP != "")
        {
            // tách lấy domain từ msg
            $array = explode('-', $msgFromRP);
            if (count($array) == 2) 
            {
                $domain = $array[0];
                $hash = $array[1];

                // check client_id trong bảng oidcclients
                //get domain của client trong bảng oidcclients bằng id_client
                $isClient = DB::table('oidcclients')->where('domain', $domain)->first();
                if ($isClient != null)
                {
                    $client_id = $isClient->client_id;
                    if ($hash == hash('sha256', $domain . $client_id) )
                    {
                        // check đúng client_id thì mới xóa client này
                        DB::table('oidcclients')->where('domain', $domain)->delete();
                        DB::table('oidcrequests')->where('domain', $domain)->delete();
                        return Response::json(['res' => 'Client has been removed ']);
                    }
                }
            }
        }

        // OP sẽ gửi sang domain||hash(domain + provider_id) nếu muốn xóa client
        $msgFromOP = $request->msg_del_client;
        if ($msgFromOP != "")
        {
            // tách lấy domain từ msg
            $array = explode('-', $msgFromOP);
            if (count($array) == 2) 
            {
                $domain = $array[0];
                $hash = $array[1];

                // check client_id trong bảng oidcclients
                //get domain của client trong bảng oidcclients bằng id_client
                $isProvider = DB::table('oidcproviders')->where('domain', $domain)->first();
                if ($isProvider != null)
                {
                    $provider_id = $isProvider->id_provider;
                    $op_reg_url = $isProvider->registration_endpoint;
                    if ($hash == hash('sha256', $domain . $provider_id) )
                    {
                        // check đúng provider_id thì mới xóa provider này
                        DB::table('oidcproviders')->where('domain', $domain)->delete();
                        DB::table('oidcrequests')->where('domain', $op_reg_url)->delete();
                        return Response::json(['res' => 'Provider has been removed ']);
                    }
                }
            }
        }
        
        return Response::json(['res' => 'Client/Provider is not Exist ! ']);
    }

    /**
    *   Hàm trả kết quả đăng ký cho RP.
    */
    public function postRegistration(Request $request)
    {
        $domain = $request->domain;
        $company = $request->company;
        $url_callback = $request->url_callback;
        $algorithm = $request->algorithm;
        $max_age = $request->max_age;
        $contacts = $request->contacts;
        $url_del_endpoint = $request->url_delete;   // url của RP, OP khi xóa client sẽ gửi thông báo đến đó.
        $url_rp_get_result = $request->url_get_result;  // url của RP, OP send result đến đó.

        // kiểm tra req trước khi đưa vào 'list req' chờ duyệt.
        $isExist = DB::table('oidcrequests')->where('domain', $domain)->first();
        if ($isExist == null) // chưa có trong list req
        {
            // đưa yêu cầu vào bảng 'oidcrequests' chờ duyệt
            DB::table('oidcrequests')->insert([
                    [   'domain' => $domain, 'company' => $company, 'url_callback' => $url_callback, 
                        'url_rp_get_result' => $url_rp_get_result, 'url_rp_delete' => $url_del_endpoint, 
                        'algorithm' => $algorithm, 'max_age' => $max_age, 'contacts' => $contacts, 
                        'request_type' => false ]
                ]);
        }
        
        return Response::json([
                'response_from_op' => 'Your request have been received and awaiting approval!'
            ]);
    }
    
    // khi admin click "Accept/Denied" thì post data đến route này
    public function postHandleRequests(Request $request)
    {               
        // get lấy request_id và type_btn_id để thực hiện xử lý
        // theo type = accept | denied
        $req_id = $request->req_ids;
        $typ_btn = $request->typ_ids;
        // set giá trị "trạng thái" của request có id là "req_id" trong bảng oidcrequests
        $record = DB::table('oidcrequests')->where('id', $req_id)->first();
        $response = [];

        $url_rp_get_result = $record->url_rp_get_result; // url của RP, nơi nhận kết quả đăng ký.

        if ($typ_btn == 'myBtnAccept')
        {
            // tạo client_id, key_secret cho phép client đăng ký.
            $client_id = str_random(32);
            $key_secret = str_random(32);
            $provider_id = str_random(32);
            // lấy domain của request từ bảng 'oidcrequests'
            $domain = $record->domain;
            // lưu vào DB
            DB::table('oidcrequests')->where('id', $req_id)->update([
                    'isAccept' => 1,
                    'status' => true
                ]);
            $acc = DB::table('oidcclients')->where('domain', $domain)->first();
            if($acc == null)
            {
                $company = $record->company;
                $url_callback = $record->url_callback;
                $algorithm = $record->algorithm;
                $contacts = $record->contacts;
                $max_age = $record->max_age;
                $url_rp_delete = $record->url_rp_delete;

                DB::table('oidcclients')->insert([
                    'client_id' => $client_id,
                    'client_name' => $company,
                    'redirect_url' => $url_callback,
                    'algorithm' => $algorithm,
                    'max_age' => $max_age,
                    'key_secret' => $key_secret,
                    'domain' => $domain,
                    'contact' => $contacts,
                    'del_endpoint' => $url_rp_delete,
                    'provider_id' => $provider_id
                ]);
            
                // gửi POST sang cho client các thông tin về account vừa tạo.
                // get url của rp nhận kết quả
                $response = [
                    'registration_result' => 'true',    // accept
                    'client_id' => $client_id,
                    'key_secret' => $key_secret,
                    'client_name' => $company,
                    'redirect_url' => $url_callback,
                    'id_token_signed_response_alg' => $algorithm,
                    'max_age' => $max_age,
                    'registration_endpoint' => config('OpenidConnect.registration_endpoint'),
                    'provider_name' => config('app.name'),    // provider_name
                    'provider_id' => $provider_id, // provider_id
                    'provider_domain' => config('OpenidConnect.domain'), // domain get trong config
                    'authen_endpoint' => config('OpenidConnect.url_op_authen'),
                    'token_endpoint' => config('OpenidConnect.token_endpoint'),
                    'delete_endpoint' => config('OpenidConnect.delete_endpoint'),
                    'session_endpoint' => config('OpenidConnect.check_session_endpoint'),
                    'info_endpoint' => config('OpenidConnect.info_endpoint')
                ];
            }
        }
        else if($typ_btn == 'myBtnDenied')
        {
            // xóa req này khỏi list req
            DB::table('oidcrequests')->where('id', $req_id)->delete();
            // gửi POST sang cho client thông báo là "yêu cầu không đc chấp nhận".
            $response = [
                'registration_endpoint' => config('OpenidConnect.registration_endpoint'),
                'registration_result' => 'false' // false = denied
            ];
        }
        // gửi phản hồi đến url nhận của RP
        // với tập các tham số $response
        $curl = curl_init();
        curl_setopt_array($curl, array(
          //CURLOPT_PORT => "8080",
          CURLOPT_URL => $url_rp_get_result,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode($response),
          CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "cache-control: no-cache",
            "content-type: application/json"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          echo "cURL Error #:" . $err;
          //return view('oidcda::register-openid', ['response' => 'error']);
        } else {
          //echo $response;
        }

        return Response::json(['flash_message' => 'Đã xử lý hành động', 'message_level' => 'success', 'message_icon' => 'check']);
    }
}
