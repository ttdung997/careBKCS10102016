<?php
namespace Giaptt\Oidcda;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Giaptt\Oidcda\Base64Url;

class RelyingParty{


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
			$domain = $data['iss'];
			$aud = $data['aud'];	// client_id (id của RP)
			$exp = $data['exp'];
			$iat = $data['iat'];
			// check domain trong bảng oidcproviders
			$ins = DB::table('oidcproviders')->where('domain', $domain)->first();
			$alg = "HS256";
			// key_secret, algorithm đã đc thỏa thuận giữa RP và OP khi đăng ký
        	// phải get key_secret, algorithm đã lưu trong db ra để xử lý id_token
			if($ins != null)
	        {
	            $key_secret = $ins->key_secret;
	            $alg = $ins->algorithm;
	            $client_id = $ins->client_id;
	            if ($aud == $client_id && JsonWT::verifyToken($id_token, $key_secret, $alg)) 
	            {
	            	$currentTime = time();
	            	$expire = $exp + ($exp - $iat)*3600; 	// đổi $exp ra giây
	            	if ($expire > $currentTime)
	            	{
	            		return true;
	            	}
	            	return false; // hết hạn.
	            }
	            return false; // token đã bị chỉnh sửa hoặc ko đúng aud.	       
	        }
	        return false;	// iss không có trong bảng providers, tức là RP chưa đăng ký vs provider này.
		}
		return false; // id token ko có đủ 3 phần.
	}

	/**
	*	Hàm trả về data theo key
	*/
	public static function getData($id_token, $key)
	{
		$arr = explode('.', $id_token);
		$json_payload = Base64Url::base64url_decode($arr[1]);
		// chuyển thành dạng array
		$data = json_decode($json_payload, true);
		return $data[$key];
	}

	/**
	*	Hàm trả về info endpoint của OP (URL).
	*/
	public static function getInfoEndpoint($token)
	{
		$array = explode('.', $token);
		$payload = $array[1];
		$payload_decode = Base64Url::base64url_decode($payload);
		$data = json_decode($payload_decode, true);
		$domain = $data['iss'];
		$ins = DB::table('oidcproviders')->where('domain', $domain)->first();
		return $ins->info_endpoint;
	}
}