<?php
	/**
	*	File config này chứa các thông tin cần cấu hình cho Relying Party,
	*	Openid Provider.
	*/
return [
	/**
	*	Phần cấu hình cho OpenID Provider
	*	Cấu hình URL cho Openid Provider
	*	url_op_authen : nơi xử lý request của rp
	*/
	'url_op_authen' => 'http://localhost:8000/authen',
	

	/**
	* 	Cấu hình domain hay issuer(iss) trong id_token trả về cho RP
	*	Provider Name = config('app.name')
	*/
	'domain' => 'benhvien1.com',

	/**
	*	Cấu hình id token Endpoint
	*/
	'token_endpoint' => 'http://localhost:8000/token',

	/**
	*	Cấu hình Info Endpoint
	*/
	'info_endpoint' => 'http://localhost:8000/info-user',

	/**
	*	Cấu hình remove client endpoint
	*/
	'delete_endpoint' => 'http://localhost:8000/admin/remove-oidc',

	/**
	*	Cấu hình callback URL, nơi để OP trả kết quả (id_token)
	*/
	'uri_rp_callback' => 'http://localhost:8000/authen-success',

	/**
	*	Cấu hình URL, nơi để OP trả kết quả đăng ký client
	*/
	'uri_rp_get_result' => 'http://localhost:8000/get-result-register',

	/**
	*	Cấu hình registration endpoint
	*/
	'registration_endpoint' => 'http://localhost:8000/registration',

	/**
	* 	Cấu hình check session endpoint, nơi check xem user còn logged trong OP không, nếu đã logout thì
	*	gửi thông báo cho bên RP, để RP logout user ra.
	*/
	'check_session_endpoint' => 'http://localhost:8000/check-session-iframe',

	//------------------------------------------------------------------------

	/**
	*	Cấu hình Url gửi request (vai RP)
	*/
	'url_rp_idp' => 'http://localhost:8000/login-with-op',

	/**
	*	Cấu hình Url để xử lý resopnse từ OP (vai RP)
	*/
	'redirect_url' => 'http://localhost:8000/authen-success',

	/**
	*	cấu hình url force logout
	*/
	'url_force_logout' => 'http://localhost:8000/logout',

	/**
	*	Cấu hình origin url
	*/
	'url_origin' => 'http://localhost:8000',
	
	/**
	*	Cấu hình tên cho cookie lưu khi user đăng nhập
	*/
	'name_cookie' => 'loggedinstt1',

	/**
	*	Cấu hình tên cho cookie, khi admin đăng nhập
	*/
	'name_cookie_admin' => 'loggedinstt1ad',
	
	/**
	*	tên cookie khi user của viện ngoài đăng nhập vào.
	*/
	'name_cookie_ex' => 'tokenLogged',

];

?>