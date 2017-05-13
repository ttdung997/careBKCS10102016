<?php 
/**
* 
*/
namespace App\OAuth;
use App\OAuth\Jwt;
use Auth;
use App\Model\Share;
use App\Model\User_Role;
use App\Model\Role_Permission;
use App\Model\Role;
use App\Model\Client;
use DB;
use Cookie;
use Authen;

function rand_string( $length ) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

class OAuthorization
{
	private $secretKey = "untouchable";

	public function __construct()
    {
    }

	/*
	*Cấp phát token
	*/
	public function issueToken(){

		if(Auth::check()){
			$accessToken = $this->getAccessToken();

			if(!isset($accessToken)||(isset($accessToken)&&$this->isExpire()==true)){
				$user 		= Auth::user();
				$user_id 	= $user ->id;
				$user_name 	= $user ->name;
				$user_email = $user ->email;

				if($user->is_local==1){
					$local = true;
					$resource = "all";
				}else{
					$local = false;
					$domain = $user ->domain;

					//$client = Client::where('domain','=', $domain)->get();
					$client = DB::table('oidcproviders')->where('domain', $domain)->first();
					//dd($client);
					//$role_id = $client[0] ->role_id;
					$role_id = $client->role_id;
					$user_role = new User_Role();
					$user_role ->role_id = $role_id;
					$user_role ->user_id = $user_id;
					$user_role ->save();

					$resource_data = DB::table('user_role')
										->join('roles','user_role.role_id','=','roles.id')
										->join('share','roles.id','=','share.role_id')
										->where('user_role.user_id',$user_id)
										->select('share.resource_id')
										->get();
					$resource = array();
					foreach ($resource_data as $item) {
						array_push($resource, $item->resource_id);
					}
					$resource = array_unique($resource);
				}

				$user = DB::table('user_role')
							->join('roles','user_role.role_id','=','roles.id')
							->join('role_permission','roles.id','=','role_permission.role_id')
							->where('user_role.user_id',$user_id)
							->select('user_role.role_id','role_permission.permission_id')
							->get();
				$user_role = array();
				$user_permission = array();
				$user_resource = array();

				foreach($user as $item){
					array_push($user_role, $item->role_id);
					array_push($user_permission, $item->permission_id);
				}

				$dataUser = array(
					"iss"	=>	"tungbtproject.com",
					"id"	=>   $user_id,
					"name"	=>	 $user_name,
					"email"	=>	 $user_email,
					"role"	=>	  array_unique($user_role),
					"permission" => array_unique($user_permission),
					"expire"	 => time() + 60,
					"internaldoctor" => $local,
					"resource"	=> $resource
				);
				$jwt = Jwt::Instance();
				$accessToken = $jwt->encode($dataUser, $this->secretKey);
				$this->setAccessToken($accessToken);
				$accessToken = $this->getAccessToken();
				//dd($accessToken);
			}
		}
	}

	/**
	* Lấy accessToken từ cookies
	*
	*/
	public function getAccessToken(){
		$accessToken = isset($_COOKIE['accessToken']) ? $_COOKIE['accessToken'] :null;
		return $accessToken;
	}

	/**
	* Đặt accessToken vào cookies
	*
	*/

	public function setAccessToken($accessToken){
		setcookie('accessToken', $accessToken, time() + 3600, '/');
		$_COOKIE['accessToken'] = $accessToken;
	}




	/**
	* Lấy dữ liệu của người dùng từ cookie
	*
	*/

	public function getDataUser(){
		$accessToken = $this->getAccessToken();
        if(isset($accessToken)){
        	$jwt = Jwt::Instance();
        	$dataUser = $jwt->decode($accessToken, $this->secretKey,array('HS256'));
	        return $dataUser;
        }
	}

	/**
	* Trả về mảng permission
	*
	*/
	
	public function getPermission(){
		$dataUser = $this->getDataUser();
        $permission = (array)($dataUser->permission);
        return $permission;
	}


	/**
	* Kiem tra quyen user
	*
	*/
	public function checkPermission($permission_id){
        if((!$this->isExpire())&&in_array($permission_id, $this->getPermission())){
        	return true;
        }else{
        	return false;
        }  
	}


	/**
	* Trả phạm vi tài nguyên được thao tác trên đó
	*
	*/
	public function getResource(){
		$dataUser = $this->getDataUser();
		$resource = (array)($dataUser ->resource);
		return $resource;
	}

	/**
	* Kiểm tra thao tác trên tài nguyên có hợp lệ hay không
	*
	*/
	public function checkResource($resource_id){
		if($this->getLocal()==true||in_array($resource_id, $this->getResource())){
			return true;
		}else{
			return false;
		}
	}


	/**
	*Trả về bác sĩ nội, ngoại
	*
	*/
	public function getLocal(){
		$dataUser = $this->getDataUser();
		$local = $dataUser->internaldoctor;
		return $local;
	}

	/**
	* Kiểm tra thời hạn của token
	*
	*/
	public function isExpire(){
		$dataUser = $this->getDataUser();
		$expire = $dataUser->expire;
		if(time()-$expire >= 0){
			return true;
		}else{
			return false;
		}
	}
}
 ?>