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
	'url_op_authen' => 'http://bv1.test/authen',
	

	/**
	* 	Cấu hình domain hay issuer(iss) trong id_token trả về cho RP
	*	Provider Name = config('app.name')
	*/
	'domain' => 'bv1.test',

	/**
	*	Cấu hình id token Endpoint
	*/
	'token_endpoint' => 'http://bv1.test/token',

	/**
	*	Cấu hình Info Endpoint
	*/
	'info_endpoint' => 'http://bv1.test/info-user',

	/**
	*	Cấu hình remove client endpoint
	*/
	'delete_endpoint' => 'http://bv1.test/admin/remove-oidc',

	/**
	*	Cấu hình callback URL, nơi để OP trả kết quả (id_token)
	*/
	'uri_rp_callback' => 'http://bv1.test/authen-success',

	/**
	*	Cấu hình URL, nơi để OP trả kết quả đăng ký client
	*/
	'uri_rp_get_result' => 'http://bv1.test/get-result-register',

	/**
	*	Cấu hình registration endpoint
	*/
	'registration_endpoint' => 'http://bv1.test/registration',

	/**
	* 	Cấu hình check session endpoint, nơi check xem user còn logged trong OP không, nếu đã logout thì
	*	gửi thông báo cho bên RP, để RP logout user ra.
	*/
	'check_session_endpoint' => 'http://bv1.test/check-session-iframe',

	//------------------------------------------------------------------------

	/**
	*	Cấu hình Url gửi request (vai RP)
	*/
	'url_rp_idp' => 'http://bv1.test/login-with-op',

	/**
	*	Cấu hình Url để xử lý resopnse từ OP (vai RP)
	*/
	'redirect_url' => 'http://bv1.test/authen-success',

	/**
	*	cấu hình url force logout
	*/
	'url_force_logout' => 'http://bv1.test/logout',

	/**
	*	Cấu hình origin url
	*/
	'url_origin' => 'http://bv1.test',
	
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