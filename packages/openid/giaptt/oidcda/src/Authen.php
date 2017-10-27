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
	*	Hàm xử lý cho Admin
	*/
	/**
	*	Kiểm tra xem admin login chưa
	*/
	public static function isAdminLogged()
	{
		$cookieName = config('OpenidConnect.name_cookie_admin');
		$cookie = Cookie::get($cookieName);
		if ( (Session::has('loggedin_admin') && Session::get('loggedin_admin') != null)
			|| ($cookie != null && $cookie != "") )
		{
			return true;
		}
		return false;
	}

	/**
	*	Lấy về email của Admin
	*/
	public static function getEmailAdmin()
	{
		if (Authen::isAdminLogged())
		{
			$email = Session::get('loggedin_admin');
			if ($email == null)
			{
				$cookieName = config('OpenidConnect.name_cookie_admin');
				$cookie = Cookie::get($cookieName);
				if ($cookie != null && $cookie != "")
				{
					$email = explode('|', $cookie)[0];
				}
			}
			return $email;
		}
	}

	/**
	*	Lấy về tên Admin
	*/
	public static function getNameAdmin()
	{
		$email = Authen::getEmailAdmin();
		$admin = DB::table('admins')->where('email', $email)->first();
		if ($admin != null)
		{
			return $admin->name;
		}
	}

	/**
	*	@return role_id cua admin hien tai
	*/
	public static function getRoleAd()
	{
		$email = Authen::getEmailAdmin();
		$admin = DB::table('admins')->where('email', $email)->first();
		if ($admin != null)
		{
			return $admin->role_id;
		}
	}

	//// ------------------------- User ---------------------------------------
	/**
	*	Hàm xử lý cho User
	*/
	public static function isUserLogged()
	{
		$cookieName = config('OpenidConnect.name_cookie');
		$cookie = Cookie::get($cookieName);
		if ( (Session::has('loggedin_user') && Session::get('loggedin_user') != null) 
			|| ($cookie != null && $cookie != "") )
		{
			return true;
		}
		return false;
	}

	/**
	*	Hàm get email của user
	*/
	public static function getEmailUser()
	{
		if (Authen::isUserLogged())
		{
			$email = Session::get('loggedin_user');
			if ($email == null)
			{
				$cookieName = config('OpenidConnect.name_cookie');
				$cookie = Cookie::get($cookieName);
				if ($cookie != null && $cookie != "")
				{
					$email = explode('|', $cookie)[0];
				}
			}
			return $email;
		}
	}

	/**
	*	Lấy về tên User
	*/
	public static function getNameUser()
	{
		$email = Authen::getEmailUser();
		$user = DB::table('users')->where('email', $email)->first();
		if ($user != null)
		{
			return $user->name;
		}
	}

	/**
	*	Hàm lấy position của user
	*/
	public static function getPositionUser()
	{
		$email = Authen::getEmailUser();
		$user = DB::table('users')->where('email', $email)->first();
		if ($user != null)
		{
			return $user->position;
		}
	}

	/**
	*	Hàm lấy 
	*/

	/**
	*	Hàm lấy id trong cookie có tên: 'name_cookie'
	*/
	public static function getIdUser()
	{
		$cookieName = config('OpenidConnect.name_cookie');
		$cookie = Cookie::get($cookieName);
		if ($cookie != null && $cookie != "")
		{
			$idUser = explode('|', $cookie)[1];
			return $idUser;
		}
	}

	/**
	*	Hàm thực hiện xóa user ngoài.
	*/
	public static function deleteUserExternal()
	{
		if (Authen::isUserLogged())
		{
			$email = Authen::getEmailUser();
			$user = DB::table('users')->where('email', $email)->first();
			if (($user != null) && ($user->is_local == false) )
			{
				DB::table('users')->where('email', $email)->delete();
			}
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


}