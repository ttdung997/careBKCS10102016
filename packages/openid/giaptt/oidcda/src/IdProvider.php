<?php

namespace Giaptt\Oidcda;

use Session;
use Giaptt\Oidcda\JsonWT;
use Illuminate\Support\Facades\DB;

class IdProvider{


	/**
	*	@param $info = array(
				'email' => 'email-client',
				'auth_at' => 
			);
	*/
	public static function genIdToken($info, $key)
	{
		$h = array('alg' => 'HS256', 'typ' => 'JWT');
		$id_token = JsonWT::generateJWT($h, $info, $key);
		return $id_token;
	}

	/**
	*	Hàm kiểm tra 1 id_token có hợp lệ không
	*/
	public static function validateIdToken($id_token)
	{
		$array = explode('.', $id_token);
		if (count($array) == 3) 
		{
			// get phần payload
			$payload = $array[1];
			$payload_decode = Base64Url::base64url_decode($payload);
			$data = json_decode($payload_decode, true);
			$client_id = $data['aud'];

			// check domain trong bảng oidcproviders
			$ins = DB::table('oidcclients')->where('client_id', $client_id)->first();
			$alg = "HS256";
			// key_secret, algorithm đã đc thỏa thuận giữa RP và OP khi đăng ký
        	// phải get key_secret, algorithm đã lưu trong db ra để xử lý id_token
			if($ins != null)
	        {
	            $key_decrypt = $ins->key_secret;
	            $alg = $ins->algorithm;

	            if (JsonWT::verifyToken($id_token, $key_decrypt, $alg)) 
	            {
	            	return true;
	            }
	            return false;
	        }
	        return false;
		}
		return false;
	}

	/**
	*	hàm lấy thông tin của user trong DB
	*	@return array
	*/
	public static function getInfoUser($id_token)
	{
		$array = explode('.', $id_token);
		$payload = $array[1];
		$payload_decode = Base64Url::base64url_decode($payload);
		$data = json_decode($payload_decode, true);
		$email = $data['email'];
		$user = DB::table('users')->where('email', $email)->first();

		$info = array(
			'name' => $user->name,
			'email' => $user->email,
			'gender' => $user->gender,
			'birthday' => $user->birthday,
			'hospital' => config('app.name'),
			'khoa' => $user->khoa
			);
		return $info;
	}
	
}