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
		if (Session::has('loggedin_admin') && Session::get('loggedin_admin') != null) 
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
	*	@return role_id cua user hien tai
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