<?php

namespace Giaptt\Oidcda\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Giaptt\Oidcda\RelyingParty;
use Giaptt\Oidcda\JsonWT;
use Giaptt\Oidcda\Base64Url;
use Response;
use Illuminate\Support\Facades\Session;
use Giaptt\Oidcda\Authen;
use App\MedicalApplication;
use App\User;
use Storage;



/**
*	RPController: tạo các request đến các trang OP khác để xác thực user,
*	và xử lý id_token.
*/
class RPController extends Controller
{
    public function getLoginWithOP(Request $request)
    {
        $op_choose = $request->option;

    	$url_idp = $op_choose;  // $op_choose là url của OP, xử lý các authen request đến.
        // get client_id đã đăng ký với OP này
        $client_id = DB::table('oidcproviders')->where('authen_endpoint', $op_choose)->first()->client_id;
    	$nonce_value = str_random(32);
    	$paramAuth = array(
    		'client_id' => $client_id, // get trong trong bảng oidcproviders
    		'response_type' => 'id_token',
    		'scope' => 'openid%20email',
    		'redirect_url' => config('OpenidConnect.uri_rp_callback'), // get trong file config
    		'nonce' => $nonce_value
    		);
    	Session::put('nonce', $nonce_value);
        $uri = $url_idp . "?" . http_build_query($paramAuth);
    	return redirect($uri);
    }

    /**
	*	Hàm xử lý id_token từ OP.
    */
    public function getAuthenSuccess(Request $request)
    {
    	// OP trả về kèm theo 1 access_token
    	// xử lý và hiển thị ra trang đăng nhập thành công
    	$id_token = $request->id_token;

        if (RelyingParty::validateIdToken($id_token))
        {
            // tách lấy phần Payload
            $payload = explode('.', $id_token)[1];
            $payload_decode = Base64Url::base64url_decode($payload);
            $data = json_decode($payload_decode, true);
            $domain = $data['iss'];
            $ssop = $data['session_state'];
            $email = $data['email'];
            $name = $data['name'];
            // get thời gian hiệu lực của id_token, để set cho cookie.
            $iat = $data['iat']; // thời gian tạo id_token.
            $exp = $data['exp']; // thời gian id_token hết hạn.
            $cookie = $id_token;    // cookie = id_token

            Session::put('loggedin', $email . '|users');    // session : email|table

            // $idUser = DB::table('users')->insertGetId([
            //         ['name' => $name, 'email' => $email, 'domain' => $domain, 'password' => str_random(32), 
            //             'position' => 2 ,'is_local' => false]
            //     ]);
            $idUser = DB::table('users')->insertGetId(
                array('name' => $name, 'email' => $email, 'domain' => $domain, 'password' => str_random(32), 'position' => 2, 'is_local' => false)
            );
            Auth::loginUsingId($idUser);

            return redirect('doctor/index')->withCookie(config('OpenidConnect.name_cookie_ex'), $cookie, $exp - $iat)
                ->withCookie('sess_stt', $ssop, $exp - $iat, '/', null, false, false);
        }
        else
        {             
            //else
            //return view báo lỗi.
            echo "Token ko hop le!";
        }

    }

    public function getHomeExternal(Request $request)
    {
        if (Auth::check()) // đã login
        {
            $nameCookie = config('OpenidConnect.name_cookie_ex');
            $id_token = $request->cookie($nameCookie);
            //dd($id_token);
            if (RelyingParty::validateIdToken($id_token)) // id_token hợp lệ
            {
                // get client_id, op session endpoint
                $client_id = RelyingParty::getData($id_token, 'aud');
                $iss = RelyingParty::getData($id_token, 'iss'); // domain của provider
                $provider = DB::table('oidcproviders')->where('domain', $iss)->first();
                $op_sess_endpoint = $provider->session_endpoint;
                return view('oidcda::doctor-ex', ['client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint]);
            }
            else
            {
                echo "ID token ko hop le !";
                $email = Auth::user()->email;
                $user = DB::table('users')->where('email', $email)->first();
                if ($user->is_local == false) 
                {
                    DB::table('users')->where('email', $email)->delete();
                }
                Auth::logout();
            }
            
        }
        return redirect('login');
    }

    /**
    *   Hàm thực hiện gửi request đến user info endpoint của OP,
    *   để lấy về user info.
    */
    public function getInfo(Request $request)
    {
        if (Authen::checkLogin()) 
        {   
            // get info endpoint từ info user của OP
            $info_endpoint = Authen::getInfoEndpoint();
            $nameCookie = config('OpenidConnect.name_cookie_ex');
            $id_token = $request->cookie($nameCookie);
            $curl = curl_init();

            curl_setopt_array($curl, array(
              //CURLOPT_PORT => "8080",
              CURLOPT_URL => $info_endpoint,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: ". $id_token,
                "cache-control: no-cache",
                "content-type: application/json"
              ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
              echo "cURL Error #getInfo:" . $err;
            } else {
              //echo $response;
                $data_response = json_decode($response, true);
            }
            $client_id = RelyingParty::getData($id_token, 'aud');
            $iss = RelyingParty::getData($id_token, 'iss'); // domain của provider
            $provider = DB::table('oidcproviders')->where('domain', $iss)->first();
            $op_sess_endpoint = $provider->session_endpoint;
            return view('oidcda::doctor-ex-info', ['fullname' => $data_response['name'], 'gender' => $data_response['gender'],
                                                    'birthday' => $data_response['birthday'], 'email' => $data_response['email'],
                                                    'hospital' => $data_response['hospital'], 'khoa' => $data_response['khoa'],
                                                    'client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint ]);
        }
        return redirect('login');
    }
    /**
    *   hàm đc gọi khi bác sĩ ngoài click "Log out".
    *   Hàm thực hiện xóa phiên đăng nhập của bác sĩ ngoài,
    *   cho dù id_token còn hiệu lực
    */
    public function getLogoutEx()
    {
        // xóa session lưu user đang đăng nhập
        $email = Authen::getCurrentUser();
        $user = DB::table('users')->where('email', $email)->first();
        if ($user != null && $user->is_local == false) 
        {
            DB::table('users')->where('email', $email)->delete();
        }
        return redirect('login');
    }

    public function postLogoutEx()
    {
        // xóa session lưu user đang đăng nhập
        $email = Authen::getCurrentUser();
        $user = DB::table('users')->where('email', $email)->first();
        if ($user != null && $user->is_local == false) 
        {
            DB::table('users')->where('email', $email)->delete();
        }

        return redirect('login');
    }

    public function listPatientShare(Request $request)
    {
        if (Authen::checkLogin()) 
        {
            $nameCookie = config('OpenidConnect.name_cookie_ex');
            $id_token = $request->cookie($nameCookie);
            if (RelyingParty::validateIdToken($id_token)) 
            {
                $client_id = RelyingParty::getData($id_token, 'aud');
                $iss = RelyingParty::getData($id_token, 'iss'); // domain của provider
                $provider = DB::table('oidcproviders')->where('domain', $iss)->first();
                $op_sess_endpoint = $provider->session_endpoint;
                return view('oidcda::list-patient', ['client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint]);
            }
            else
            {
                echo "ID Token ko hop le !";
                $email = Authen::getCurrentUser();
                $user = DB::table('users')->where('email', $email)->first();
                if ($user->is_local == false) 
                {
                    DB::table('users')->where('email', $email)->delete();
                }
                Session::forget('loggedin');
            }
        }
        return redirect('login');   
    }

    public function xemBenhAn($medical_id)
    {
        $medical = MedicalApplication::where('id',$medical_id)->first();
        /*
        Thử lấy url từ đơn khám, sau đó đọc nội dung file từ đơn khám, xuất ra dạng string đưa vào $contents
        Sau đó load contents thành một đối tượng XML để dễ dàng xử lý.
        */

        try {
            $contents = Storage::get($medical->url); 
            //return var_dump($contents);   
        } catch (\Exception $e) {
            return "Không tìm thấy file đơn khám";
        }

        //return $medical->user_id;
        $user = User::where('id',$medical->user_id)->first();
        $birthday = substr($user->birthday,0,10);

        $medical_application_xml = simplexml_load_string($contents);
        $ktl = $medical_application_xml->kham_the_luc;
        $kls =$medical_application_xml->kham_lam_sang;
        $kcls=$medical_application_xml->kham_can_lam_sang;
        $kl=$medical_application_xml->ket_luan;

        // Kiểm tra phân quyền
        // So sanh khoa, neu khoa thoa man thi bo disabled di.
        $kham_the_luc_disabled=strcmp(Auth::user()->khoa,'khoa_the_luc');
        $noi_khoa_disabled=strcmp(Auth::user()->khoa,'noi_khoa');
        $mat_disabled=strcmp(Auth::user()->khoa,'khoa_mat');
        $tai_mui_hong_disabled=strcmp(Auth::user()->khoa,'tai_mui_hong');
        $rang_ham_mat_disabled=strcmp(Auth::user()->khoa,'rang_ham_mat');
        $da_lieu_disabled=strcmp(Auth::user()->khoa,'khoa_da_lieu');
        $can_lam_sang_disabled=strcmp(Auth::user()->khoa,'can_lam_sang');
        $tong_quan_disabled=strcmp(Auth::user()->khoa,'khoa_tong_quan');


        $medical_data = array(  



                'ten_benh_nhan' => $user->name,
                'ngay_sinh' => $birthday,
                'ho_khau' =>$user->permanent_residence,
                'kham_the_luc_disabled' => $kham_the_luc_disabled,
                'noi_khoa_disabled' => $noi_khoa_disabled,
                'mat_disabled' => $mat_disabled,
                'tai_mui_hong_disabled' => $tai_mui_hong_disabled,
                'rang_ham_mat_disabled' =>$rang_ham_mat_disabled,
                'da_lieu_disabled' => $da_lieu_disabled,
                'can_lam_sang_disabled' => $can_lam_sang_disabled,
                'tong_quan_disabled' => $tong_quan_disabled,
                'medical_id' => $medical_id,

                'chieu_cao' => $ktl->chieu_cao,
                'can_nang' => $ktl->can_nang,
                'huyet_ap' => $ktl->huyet_ap,

                'tuan_hoan'=> $kls->noi_khoa->tuan_hoan,
                'phan_loai_tuan_hoan'=>$kls->noi_khoa->phan_loai_tuan_hoan,
                'ho_hap' =>$kls->noi_khoa->ho_hap,
                'phan_loai_ho_hap'=>$kls->noi_khoa->phan_loai_ho_hap,
                'tieu_hoa'=> $kls->noi_khoa->tieu_hoa,
                'phan_loai_tieu_hoa'=>$kls->noi_khoa->phan_loai_tieu_hoa,
                'than_tiet_nieu'=> $kls->noi_khoa->than_tiet_nieu,
                'phan_loai_than_tiet_nieu'=>$kls->noi_khoa->phan_loai_than_tiet_nieu,
                'noi_tiet'=> $kls->noi_khoa->noi_tiet,
                'phan_loai_noi_tiet'=>$kls->noi_khoa->phan_loai_noi_tiet,
                'co_xuong_khop'=> $kls->noi_khoa->co_xuong_khop,
                'phan_loai_co_xuong_khop'=>$kls->noi_khoa->phan_loai_co_xuong_khop,
                'than_kinh'=> $kls->noi_khoa->than_kinh,
                'phan_loai_than_kinh'=>$kls->noi_khoa->phan_loai_than_kinh,
                'tam_than'=> $kls->noi_khoa->tam_than,
                'phan_loai_tam_than'=>$kls->noi_khoa->phan_loai_co_tam_than,

                'mat_trai'=>$kls->mat->thi_luc->mat_trai,
                'mat_phai'=>$kls->mat->thi_luc->mat_phai,
                'benh_ve_mat'=>$kls->mat->benh_neu_co,
                'phan_loai_mat'=>$kls->mat->phan_loai,
                'tai_trai'=>$kls->tai_mui_hong->thinh_luc->tai_trai,
                'tai_phai'=>$kls->tai_mui_hong->thinh_luc->tai_phai,
                'benh_ve_tai_mui_hong'=>$kls->tai_mui_hong->benh_neu_co,
                'phan_loai_tai_mui_hong'=>$kls->tai_mui_hong->phan_loai,
                'ham_tren'=>$kls->rang_ham_mat->ham_tren,
                'ham_duoi'=>$kls->rang_ham_mat->ham_duoi,
                'phan_loai_rang_ham_mat'=>$kls->rang_ham_mat->phan_loai,
                'phan_loai_da_lieu'=>$kls->da_lieu->phan_loai,

                'ket_qua'=>$kcls->ket_qua,
                'danh_gia'=>$kcls->danh_gia,

                'phan_loai'=>$kl->phan_loai,
                'benh_neu_co'=>$kl->benh_neu_co,
                'bs_kl'=>$kl->bs_kl,
            );
        return view('oidcda::benh-an')->with($medical_data);
    }

    /**
    *   Hàm get thông tin từ bảng OidcProviders
    *   @return Json
    */
    public function listAsJsonProviders()
    {
        $providers_list = DB::table('oidcproviders')->orderBy('id', 'ASC')->get();
        return Response::json(['data' => $providers_list]);    
    }

    /**
    *   Hàm gửi yêu cầu thông báo đến Provider để xóa.
    *   đồng thời xóa provider khỏi bảng 'oidcproviders', 'oidcrequests'
    */
    public function deleteProvider(Request $request)
    {
        // id_op lấy từ view xác nhận xóa provider.
        $id_op = $request->op_ids;
        
        $op = DB::table('oidcproviders')->where('id', $id_op)->first();
        $reg_url = $op->registration_endpoint;
        $del_url = $op->del_endpoint;
        $client_id = $op->client_id;
        // xóa trong bảng 'oidcproviders' và 'oidcrequests'
        DB::table('oidcproviders')->where('id', $id_op)->delete();
        DB::table('oidcrequests')->where('domain', $reg_url)->delete();
        // gửi message sang OP để báo rằng RP muốn xóa khỏi OP.
        // message có dạng domain-(hash (domain + client_id))
        $client_domain = config('OpenidConnect.domain');
        $message = $client_domain . '-' . hash('sha256', $client_domain . $client_id);
        $data = [
            'msg_del_provider' => $message   // domain/id của client, OP nhận đc sẽ biết là phải xóa RP nào
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

        return Response::json(['flash_message' => 'Đã xóa Provider', 'message_level' => 'success', 'message_icon' => 'check']);
    }
}
