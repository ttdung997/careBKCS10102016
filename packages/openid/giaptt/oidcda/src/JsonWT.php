<?php

namespace Giaptt\Oidcda;

use Giaptt\Oidcda\Base64Url;


class JsonWT{

	/**
	*	@param 	$payload: gồm các thông tin của user, $key: đc chia sẻ bí mật giữa RP và IdP.
	*	@return $id_token: 1 string theo định dạng JWT
	*/
	public static function generateJWT($header, $payload, $key)
	{
		$head = Base64Url::base64url_encode(json_encode($header));
		$data = Base64Url::base64url_encode(json_encode($payload));
		$unsignToken = $head . "." . $data;

		// xác định thuật toán mã hóa hash
		$alg = $header['alg'];
		switch ($alg) {
			case 'HS256':
				$alg = 'sha256';
				break;
			default:
			$alg = 'sha256';
				break;
		}
		$signature = hash_hmac($alg, $unsignToken, $key);
		$id_token = $unsignToken . "." . Base64Url::base64url_encode($signature);
		return $id_token;
	}

	/**
	*	@return true/false
	* 	kiểm tra chữ ký có hợp lệ ko
	*/
	public static function verifyToken($id_token, $key, $alg)
	{
		//tách id_token thành 3 phần
		// $arr[0] = header
		// $arr[1] = payload
		// $arr[2] = signature
		$arr = explode('.', $id_token);
		// chuyển thành dạng json
		$json_header = Base64Url::base64url_decode($arr[0]);
		// chuyển thành dạng array
		$header = json_decode($json_header, true);

		$algorithm = 'sha256';
		switch ($alg) {
			case 'HS256':
				$algorithm = 'sha256';
				break;
			default:
				$algorithm = 'sha256';
				break;
		}
		// so sánh
		$dataUnsign = $arr[0] . "." . $arr[1];
		$signature = hash_hmac($algorithm, $dataUnsign , $key);
		if ($arr[2] == Base64Url::base64url_encode($signature)) 
		{
			return true;
		}
		return false;
	}
}