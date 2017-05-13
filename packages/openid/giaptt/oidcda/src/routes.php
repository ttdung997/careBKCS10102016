<?php


//------------ Authenticate Local --------------------------
Route::group(['middleware' => 'web'], function(){

	Route::get('home-admin', 'giaptt\oidcda\controllers\AuthLocalController@getHomeAdmin');

	// Route login backend
	Route::get('backend/login', 'giaptt\oidcda\controllers\AuthLocalController@getBackendLogin');
	Route::post('backend/login', 'giaptt\oidcda\controllers\AuthLocalController@postBackendLogin');

	Route::get('backend/register', 'giaptt\oidcda\controllers\AuthLocalController@getBackendRegister');
	Route::post('backend/register', 'giaptt\oidcda\controllers\AuthLocalController@postBackendRegister');

	Route::get('backend/logout', 'giaptt\oidcda\controllers\AuthLocalController@getBackendLogout');
	Route::post('backend/logout', 'giaptt\oidcda\controllers\AuthLocalController@postBackendLogout');

	// Route Login Frontend
	Route::get('login', 'giaptt\oidcda\controllers\AuthLocalController@getLogin');
	Route::post('login', 'giaptt\oidcda\controllers\AuthLocalController@postLogin');
	Route::get('logout', 'giaptt\oidcda\controllers\AuthLocalController@getLogout');
	Route::post('logout', 'giaptt\oidcda\controllers\AuthLocalController@postLogout');

	// Route Register
	Route::get('register', 'giaptt\oidcda\controllers\AuthLocalController@getRegister');
	Route::post('register', 'giaptt\oidcda\controllers\AuthLocalController@postRegister');

	//----------------- OP's Authentication (vai OP)----------------------------------
	Route::get('authen', 'giaptt\oidcda\controllers\OPController@getAuthen');

	Route::post('verify-account', 'giaptt\oidcda\controllers\OPController@postVerifyAcc');

	Route::get('info-user', 'giaptt\oidcda\controllers\OPController@getInfoUser');

	//--------------------- RP request to OP to authenticate end-user (vai RP)---------------------------
	Route::get('login-with-op', 'giaptt\oidcda\controllers\RPController@getLoginWithOP');

	Route::get('authen-success', 'giaptt\oidcda\controllers\RPController@getAuthenSuccess');

	Route::get('doctor/external/index', 'giaptt\oidcda\controllers\RPController@getHomeExternal')
		->name('doctor-ex-index');
	Route::get('doctor/external/info', 'giaptt\oidcda\controllers\RPController@getInfo')
		->name('doctor-ex-info');

	Route::get('logout-ex', 'giaptt\oidcda\controllers\RPController@getLogoutEx');

	Route::post('logout-ex', 'giaptt\oidcda\controllers\RPController@postLogoutEx');

	//---------------------- Session Management (vai OP) ------------------------------------
	Route::get('check-session-iframe', 'giaptt\oidcda\controllers\AuthLocalController@checkSessionIframe');


	//----------------------- Route for bs ngoài (vai RP) -----------------------------------
	Route::get('doctor/external/list-patient-share','giaptt\oidcda\controllers\RPController@listPatientShare')
		->name('doctor-list-patient-share');

	Route::get('list.json-patient','giaptt\oidcda\controllers\RPController@listAsJsonPatient')
		->name('list-as-json-patient');
		
	Route::get('doctor/external/view_medical_exam/{id}','giaptt\oidcda\controllers\RPController@xemBenhAn')
		->name('view_medical_exam_by_id');

	//----------------------- Route để đăng ký OpenID với OP (vai RP )-------------------------------------
	Route::get('admin/register-openid', 'giaptt\oidcda\controllers\AuthLocalController@getRegisterOpenId')->middleware('admin')
		->name('admin-register-openid');
	Route::post('admin/register-openid', 'giaptt\oidcda\controllers\AuthLocalController@postRegisterOpenId'); 

	Route::post('get-result-register', 'giaptt\oidcda\controllers\AuthLocalController@postGetResultRegister'); 

	//----------------------- Route cho phép Relying Party đăng ký (vai OP) -----------------
	Route::post('registration', 'giaptt\oidcda\controllers\AuthLocalController@postRegistration');

	// ---------- route xử lý request xóa op/rp của server khác gửi đến (vai OP) -------------------
	Route::post('admin/remove-oidc', 'giaptt\oidcda\controllers\AuthLocalController@postRemoveOidc');
	
		// --------------------------- xử lý List Providers (vai RP) ------------------------------------------
	Route::get('admin/list-providers', 'giaptt\oidcda\controllers\AuthLocalController@getListProviders')->middleware('admin')
		->name('admin-list-providers');
	Route::get('admin/list.json-providers','giaptt\oidcda\controllers\RPController@listAsJsonProviders')
		->name('list-as-json-providers');

	Route::post('admin/list-providers/delete', 'giaptt\oidcda\controllers\RPController@deleteProvider')->middleware('admin')
		->name('admin-del-op');

		// -------------------- xử lý List Clients (vai OP) --------------------------------------
	Route::get('admin/list-clients', 'giaptt\oidcda\controllers\AuthLocalController@getListClients')->middleware('admin')
		->name('admin-list-clients');
	Route::get('admin/list.json-clients','giaptt\oidcda\controllers\OPController@listAsJsonClients')->name('list-as-json-clients');

	Route::post('admin/list-clients/delete', 'giaptt\oidcda\controllers\OPController@deleteClient')->middleware('admin')
		->name('admin-del-rp');

	// ------------------- xử lý các request Đến/Đi (vai OP)-------------------------
	Route::get('admin/list-requests', 'giaptt\oidcda\controllers\AuthLocalController@getListRequests')->middleware('admin')
		->name('admin-list-requests');

	Route::get('admin/list.json-requests','giaptt\oidcda\controllers\AuthLocalController@listAsJsonRequests')
		->name('list-as-json-requests');

	Route::post('admin/list-requests/handle', 'giaptt\oidcda\controllers\AuthLocalController@postHandleRequests')->middleware('admin')->name('admin-handle-requests');

	Route::get('about', 'giaptt\oidcda\controllers\OPController@getAbout');

	Route::get('test-create-cookie', function () {
		$response = new Illuminate\Http\Response('Hello World');
		$response->withCookie(cookie('myCookie', 'giap123456', 60));
		return $response;
		
	});

	Route::get('test-get-email-logged', function () {
		$email = Auth::user()->email;
		echo "email: " . $email;
		
	});

});