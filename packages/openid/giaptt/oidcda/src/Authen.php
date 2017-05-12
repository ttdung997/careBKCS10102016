<?php
namespace Giaptt\Oidcda;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
/**
*	Authen: kiểm tra User đã login/logout chưa, thực hiện xác thực user
*/
class Authen{


	/**
	*	@return role_id cua user hien tai
	*/
	public static function getRole()
	{
		/**
		*	Kiểm tra tên bảng trong session, rồi get từ bảng đó ra
		*/
		if(Authen::checkLogin())
		{
			// email|tables
			$user = Session::get('loggedin');
			$table = explode('|', $user)[1];
			$email = explode('|', $user)[0];

			$record = DB::table($table)->where('email', $email)->first();
			$role = $record->role_id;
			return $role;
		}
	}

	/**
	*	Hàm trả về info endpoint của provider hiện tại
	*/
	public static function getInfoEndpoint()
	{
		$cookieName = config('OpenidConnect.name_cookie_ex');
		$token = Cookie::get($cookieName);
		if (RelyingParty::validateIdToken($token)) 
		{
			return RelyingParty::getInfoEndpoint($token);
		}
	}

	// public static function getIdToken()
	// {
	// 	$cookieName = config('OpenidConnect.name_cookie_ex');
	// 	$cookie = Cookie::get($cookieName);
	// 	$token = explode('|', $cookie)[1];
	// 	if (RelyingParty::validateIdToken($token)) 
	// 	{
	// 		return $token;
	// 	}
	// }

	/**
	*	Hàm trả về email của user đang logged in.
	*/
	public static function getCurrentUser()
	{
		if (Authen::checkLogin()) 
		{
			// email|tables
			$user = Session::get('loggedin');
			return explode('|', $user)[0];
		}
	}

	/**
	*	Hàm trả về Name của user đang logged in.
	*/
	public static function getCurrentUserName()
	{
		if (Authen::checkLogin()) 
		{
			// email|tables
			$user = Session::get('loggedin');
			$table = explode('|', $user)[1];
			$email = explode('|', $user)[0];

			$record = DB::table($table)->where('email', $email)->first();
			return $record->name;
		}
	}

	/**
	*	Hàm check user đã login hay chưa
	*	@return TRUE nếu đã login, ngược lại FALSE
	*/
	public static function checkLogin()
	{
		if (Session::has('loggedin') && Session::get('loggedin') != null) 
		{
			return true;
		}
		return false;
	}

	// /**
	// *	Hàm thực hiện xóa user ngoài khỏi DB, khi user này logout.
	// */
	// public static function logoutUser()
	// {
	// 	$email = Authen::getUserEx();
	// 	DB::table('users')->where('email', $email)->delete();
	// }
}