<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */
Route::get('/', function() {
    return view('welcome');
});
Route::get('/home', 'HomeController@index');

Route::post('/token_api', 'ApiController@getToken');
Route::post('/mobile_api', 'ApiController@cacheDataFormMobile');
Route::post('/medical_api', 'ApiController@getMedicalIDformMobile');

#login and logout
// Auth::routes();
#
#Route for patient
Route::group(['prefix' => 'patient'], function () {
    Route::get('', function() {
        return redirect()->route('patient-index');
    });
    Route::get('index', 'PatientController@index')
            ->name('patient-index');
    Route::get('info', 'PatientController@info')
            ->name('patient-info');
    Route::post('info', 'PatientController@capNhatInfo');
    Route::get('register', 'PatientController@register')
            ->name('patient-register');
    Route::get('history', 'PatientController@history')
            ->name('patient-history');
    Route::get('health_history', 'PatientController@health_history')
            ->name('patient-health-history');
    Route::get('specialist_history', 'PatientController@specialist_history')
            ->name('patient-specialistp-history');
    Route::get('test_history', 'PatientController@test_history')
            ->name('patient-test-history');
    Route::get('history.json', 'PatientController@history_as_json')
            ->name('history-json');
    Route::get('history.specialist.json', 'PatientController@history_specialist_as_json')
            ->name('history-specialist-json');
    Route::get('history.test.json', 'PatientController@history_test_as_json')
            ->name('history-test-json');
    Route::get('waithistory.json', 'PatientController@wait_history_as_json')
            ->name('wait-history-json');
    Route::get('waithistory.specialist.json', 'PatientController@wait_history_specialist_as_json')
            ->name('wait-history-specialist-json');
    Route::get('waithistory.test.json', 'PatientController@wait_history_test_as_json')
            ->name('wait-history-test-json');
    Route::get('detail.json/{id}', 'PatientController@medical_app_detail_as_json')
            ->name('detail-json');
    Route::get('testDetail.json/{id}', 'PatientController@medical_test_detail_as_json')
            ->name('test-detail-json');
    Route::get('COPDtestDetail.json/{id}', 'PatientController@medical_COPD_test_detail_as_json')
            ->name('COPDtest-detail-json');
    Route::get('specialistDetail.json/{id}', 'PatientController@medical_specialist_detail_as_json')
            ->name('specialist-detail-json');
    Route::get('getMedicalSpecialistInfo/{id}', 'PatientController@getMedicalSpecialistInfo')
            ->name('doctor-getMedicalSpecialistInfo');
    Route::get('detail.json', 'PatientController@detail_json')
            ->name('detail-json-demo');
    Route::get('about', 'PatientController@about');
    Route::post('register', 'PatientController@sendRegister');
    Route::post('cancel-register', 'PatientController@cancelRegister');
    Route::post('share', 'PatientController@postShare')
            ->name('patient-share');
    Route::get('testRegister', 'PatientController@TestRegister')
            ->name('patient-testRegister');
    Route::post('testRegister', 'PatientController@sendTestRegister');
    Route::post('cancel-testRegister', 'PatientController@cancelTestRegister');
    Route::get('registerS', 'PatientController@RegisterS')
            ->name('patient-registerS');
    Route::post('registerS', 'PatientController@sendRegisterS');
    Route::post('cancel-registerS', 'PatientController@cancelRegisterS');
    Route::get('getPosition', 'PatientController@getPosition')
            ->name('getPosition');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/index', ['as' => 'AdminController.index', 'uses' => 'AdminController@index']);

    //Staff management
    Route::get('listStaff', ['as' => 'AdminController.list.staff', 'uses' => 'AdminController@listStaff']);
    Route::get('staff', ['as' => 'AdminController.index.staff', 'uses' => 'AdminController@indexStaff']);
    Route::get('staff/show/{id}', ['as' => 'AdminController.show.staff', 'uses' => 'AdminController@showStaff']);
    Route::post('staff/add', ['as' => 'AdminController.store.staff', 'uses' => 'AdminController@storeStaff']);
    Route::match(['get', 'patch'], 'staff/edit/{id}', ['as' => 'AdminController.update.staff', 'uses' => 'AdminController@updateStaff']);
    Route::delete('staff/destroy', ['as' => 'AdminController.destroy.staff', 'uses' => 'AdminController@destroyStaff']);

    //Role management
    Route::get('role', ['as' => 'AdminController.index.role', 'uses' => 'AdminController@indexRole']);
    Route::get('listRole', ['as' => 'AdminController.list.role', 'uses' => 'AdminController@listRole']);
    Route::get('role/show/{id}', ['as' => 'AdminController.show.role', 'uses' => 'AdminController@showRole']);
    Route::post('role/add', ['as' => 'AdminController.store.role', 'uses' => 'AdminController@storeRole']);
    Route::match(['get', 'patch'], 'role/edit/{id}', ['as' => 'AdminController.update.role', 'uses' => 'AdminController@updateRole']);
    Route::delete('role/destroy', ['as' => 'AdminController.destroy.role', 'uses' => 'AdminController@destroyRole']);
    Route::get('role/doctor/{id}', ['as' => 'AdminController.role.doctor', 'uses' => 'AdminController@showDoctorRole']);
    Route::get('/listDoctorOfRole/{id}', ['as' => 'AdminController.role.listDoctorOfRole', 'uses' => 'AdminController@listUserOfRole']);
    Route::delete('role/deleteDoctor/', ['as' => 'AdminController.role.deleteDoctor', 'uses' => 'AdminController@deleteDoctorOfRole']);
    Route::post('role/addDoctorforRole', ['as' => 'AdminController.role.addDoctorforRole', 'uses' => 'AdminController@addDoctorforRole']);

    //Doctor management
    Route::get('listDoctor', ['as' => 'AdminController.list.doctor', 'uses' => 'AdminController@listDoctor']);
    Route::get('doctor', ['as' => 'AdminController.index.doctor', 'uses' => 'AdminController@indexDoctor']);
    Route::get('doctor/show/{id}', ['as' => 'AdminController.show.doctor', 'uses' => 'AdminController@showDoctor']);
    Route::post('doctor/add', ['as' => 'AdminController.store.doctor', 'uses' => 'AdminController@storeDoctor']);
    Route::match(['get', 'patch'], 'doctor/edit/{id}', ['as' => 'AdminController.update.doctor', 'uses' => 'AdminController@updateDoctor']);
    Route::delete('doctor/destroy', ['as' => 'AdminController.destroy.doctor', 'uses' => 'AdminController@destroyDoctor']);
    Route::get('doctor/role/{id}', ['as' => 'AdmonController.doctor.role', 'uses' => 'AdminController@showRoleDoctor']);
    Route::get('/listRoleOfDoctor/{id}', ['as' => 'AdminController.doctor.listRoleOfDoctor', 'uses' => 'AdminController@listRoleOfDoctor']);
    Route::delete('doctor/deleteRole/', ['as' => 'AdminController.doctor.deleteRole', 'uses' => 'AdminController@deleteRoleOfDoctor']);
    Route::post('doctor/addRoleforDoctor', ['as' => 'AdminController.doctor.addRoleforDoctor', 'uses' => 'AdminController@addRoleforDoctor']);

    // Hospital management
    Route::get('hospital', ['as' => 'AdminController.index.hospital', 'uses' => 'AdminController@indexHospital']);
    Route::get('listHospital', ['as' => 'AdminController.index.listHospital', 'uses' => 'AdminController@listHospital']);
    Route::get('hospital/show/{id}', ['as' => 'AdminController.show.hospital', 'uses' => 'AdminController@showHospital']);

    //Department management
    Route::get('listDepartment', ['as' => 'AdminController.list.department', 'uses' => 'AdminController@listDepartment']);
    Route::get('department', ['as' => 'AdminController.index.department', 'uses' => 'AdminController@indexDepartment']);
    Route::get('department/show/{id}', ['as' => 'AdminController.show.department', 'uses' => 'AdminController@showDepartment']);
    Route::post('department/add', ['as' => 'AdminController.store.department', 'uses' => 'AdminController@storeDepartment']);
    Route::match(['get', 'patch'], 'department/edit/{id}', ['as' => 'AdminController.update.department', 'uses' => 'AdminController@updateDepartment']);
    Route::delete('department/destroy', ['as' => 'AdminController.destroy.department', 'uses' => 'AdminController@destroyDepartment']);

    Route::post('add-role-provider', ['as' => 'AdminController.addrole.provider', 'uses' => 'AdminController@addRoleForProvider']);

    //Degree management
    Route::get('listDegree', ['as' => 'AdminController.list.degree', 'uses' => 'AdminController@listDegree']);
    Route::get('degree', ['as' => 'AdminController.index.degree', 'uses' => 'AdminController@indexDegree']);
    Route::get('degree/show/{id}', ['as' => 'AdminController.show.degree', 'uses' => 'AdminController@showDegree']);
    Route::post('degree/add', ['as' => 'AdminController.store.degree', 'uses' => 'AdminController@storeDegree']);
    Route::match(['get', 'patch'], 'degree/edit/{id}', ['as' => 'AdminController.update.degree', 'uses' => 'AdminController@updateDegree']);
    Route::delete('degree/destroy', ['as' => 'AdminController.destroy.degree', 'uses' => 'AdminController@destroyDegree']);

    Route::post('add-role-provider', ['as' => 'AdminController.addrole.provider', 'uses' => 'AdminController@addRoleForProvider']);

    //Office management
    Route::get('listOffice', ['as' => 'AdminController.list.office', 'uses' => 'AdminController@listOffice']);
    Route::get('office', ['as' => 'AdminController.index.office', 'uses' => 'AdminController@indexOffice']);
    Route::get('office/show/{id}', ['as' => 'AdminController.show.office', 'uses' => 'AdminController@showOffice']);
    Route::post('office/add', ['as' => 'AdminController.store.office', 'uses' => 'AdminController@storeOffice']);
    Route::match(['get', 'patch'], 'office/edit/{id}', ['as' => 'AdminController.update.Office', 'uses' => 'AdminController@updateOffice']);
    Route::delete('office/destroy', ['as' => 'AdminController.destroy.office', 'uses' => 'AdminController@destroyOffice']);

    Route::post('add-role-provider', ['as' => 'AdminController.addrole.provider', 'uses' => 'AdminController@addRoleForProvider']);

    //Room management
    Route::get('listRoom', ['as' => 'AdminController.list.room', 'uses' => 'AdminController@listRoom']);
    Route::get('room', ['as' => 'AdminController.index.room', 'uses' => 'AdminController@indexRoom']);
    Route::get('room/show/{id}', ['as' => 'AdminController.show.room', 'uses' => 'AdminController@showRoom']);
    Route::post('room/add', ['as' => 'AdminController.store.room', 'uses' => 'AdminController@storeRoom']);
    Route::match(['get', 'patch'], 'room/edit/{id}', ['as' => 'AdminController.update.Office', 'uses' => 'AdminController@updateRoom']);
    Route::delete('room/destroy', ['as' => 'AdminController.destroy.room', 'uses' => 'AdminController@destroyRoom']);

    Route::post('add-role-provider', ['as' => 'AdminController.addrole.provider', 'uses' => 'AdminController@addRoleForProvider']);

//loại xét nghiệm management
    Route::get('listMedicalTestType', ['as' => 'AdminController.list.MedicalTestType', 'uses' => 'AdminController@listMedicalTestType']);
    Route::get('MedicalTestType', ['as' => 'AdminController.index.MedicalTestType', 'uses' => 'AdminController@indexMedicalTestType']);
    Route::get('MedicalTestType/show/{id}', ['as' => 'AdminController.show.MedicalTestType', 'uses' => 'AdminController@showMedicalTestType']);
    Route::post('MedicalTestType/add', ['as' => 'AdminController.store.MedicalTestType', 'uses' => 'AdminController@storeMedicalTestType']);
    Route::match(['get', 'patch'], 'MedicalTestType/edit/{id}', ['as' => 'AdminController.update.MedicalTestType', 'uses' => 'AdminController@updateMedicalTestType']);
    Route::delete('MedicalTestType/destroy', ['as' => 'AdminController.destroy.MedicalTestType', 'uses' => 'AdminController@destroyMedicalTestType']);

    Route::post('add-role-provider', ['as' => 'AdminController.addrole.provider', 'uses' => 'AdminController@addRoleForProvider']);

    //Patient management
    Route::get('listPatientRole', ['as' => 'AdminController.index.patient', 'uses' => 'AdminController@listPatientRole']);

    // Route::post('addRoleClient',['as'=>'AdminController.addrole.client','uses'=>'AdminController@addRoleClient']);
});

Route::group(['prefix' => 'staff'], function () {
    Route::get('/index', ['as' => 'StaffController.index', 'uses' => 'StaffController@index']);

    //Medical application management
    Route::get('listMedicalApplication', ['as' => 'StaffController.list.medicalApplication', 'uses' => 'StaffController@listMedicalApplication']);
    Route::get('medicalApplication', ['as' => 'StaffController.index.medicalApplication', 'uses' => 'StaffController@indexMedicalApplication']);
    Route::get('medicalApplication/show/{id}', ['as' => 'StaffController.show.medicalApplication', 'uses' => 'StaffController@showMedicalApplication']);
    Route::post('medicalApplication/add', ['as' => 'StaffController.store.medicalApplication', 'uses' => 'StaffController@storeMedicalApplication']);
    Route::get('medicalSpecialistApplication/add', ['as' => 'StaffController.store.medicalSpecialistApplication', 'uses' => 'StaffController@storeMedicalSpecialistApplication']);
    Route::get('medicalTestApplication/add', ['as' => 'StaffController.store.medicalTestApplication', 'uses' => 'StaffController@storeMedicalTestApplication']);
    Route::match(['get', 'patch'], 'medicalApplication/edit/{id}', ['as' => 'StaffController.update.medicalApplication', 'uses' => 'StaffController@updateMedicalApplication']);
    Route::delete('medicalApplication/destroy', ['as' => 'StaffController.destroy.medicalApplication', 'uses' => 'StaffController@destroyMedicalApplication']);
    //them by me
    Route::get('list2.json', 'StaffController@listAsJson')
            ->name('list-as-json-staff');


    //Patient management
    Route::get('listPatient', ['as' => 'StaffController.list.patient', 'uses' => 'StaffController@listPatient']);
    Route::get('patient', ['as' => 'StaffController.index.patient', 'uses' => 'StaffController@indexPatient']);
    Route::get('patient/show/{id}', ['as' => 'StaffController.show.patient', 'uses' => 'StaffController@showPatient']);
    Route::post('patient/add', ['as' => 'StaffController.store.patient', 'uses' => 'StaffController@storePatient']);
    Route::match(['get', 'patch'], 'patient/edit/{id}', ['as' => 'StaffController.update.patient', 'uses' => 'StaffController@updatePatient']);
    Route::delete('patient/destroy', ['as' => 'StaffController.destroy.patient', 'uses' => 'StaffController@destroyPatient']);

    //lam xet nghiem
    Route::get('list.json', 'StaffController@listTestAsJson')
            ->name('staff-list-as-json');
    Route::get('listTestPatient', ['as' => 'StaffController.list.testPatient', 'uses' => 'StaffController@listTestPatient']);
    //đợi kết quả xet nghiem
    Route::get('waitinglist.json', 'StaffController@listWaitingTestAsJson')
            ->name('staff-waiting-list-as-json');
    Route::get('listWaitingTestPatient', ['as' => 'StaffController.list.waitingTestPatient', 'uses' => 'StaffController@listWaitingTestPatient']);
    //kết quả xet nghiem
    Route::get('compeletelist.json', 'StaffController@listCompeleteTestAsJson')
            ->name('staff-compelete-list-as-json');
    Route::get('listCompeleteTestPatient', ['as' => 'StaffController.list.compeleteTestPatient', 'uses' => 'StaffController@listCompeleteTestPatient']);
    //danh sach đăng kí xét nghiệm
    Route::get('futurelist.json', 'StaffController@listFutureTestAsJson')
            ->name('staff-future-list-as-json');
    Route::get('listFutureTestPatient', ['as' => 'StaffController.list.futureTestPatient', 'uses' => 'StaffController@listFutureTestPatient']);

    // Below route is handle by id
    Route::get('medical_test/{id}', 'StaffController@medical_test')
            ->name('medical_test_by_id');
    Route::post('update-COPD-test-medical-info', 'StaffController@updateCOPDTestMedicalInfo')
            ->name('update-COPD-test-medical-info');
    Route::post('update-test-medical-info', 'StaffController@updateTestMedicalInfo')
            ->name('update-test-medical-info');
    Route::get('testDetail.json/{id}', 'StaffController@medical_test_detail_as_json')
            ->name('test-detail-json');
    Route::get('COPDtestDetail.json/{id}', 'StaffController@medical_COPD_test_detail_as_json')
            ->name('COPDtest-detail-json');
    
    //lấy kết quả và gửi lại kết quả qua Api
     Route::get('get_API_connect/{roomID}', 'StaffController@getAPIConnect')
            ->name('get_API_connect');
     Route::get('get_API_disconnect/{roomID}', 'StaffController@getAPIDisconnect')
            ->name('get_API_disconnect');
     Route::get('get_API_result', 'StaffController@getAPIResult')
            ->name('get_API_result');
    Route::get('get_API_data', 'StaffController@getAPIData')
            ->name('get_API_data');

     Route::get('get_API_device/{roomID}', 'StaffController@getAPIDevice')
            ->name('get_API_device');
     Route::get('medical_test_by_api/{id}', 'StaffController@getMedicalTestByAPi')
            ->name('medical_test_by_api');
     Route::get('get_data_mobile/{id}', 'StaffController@getMedicalFormMobile')
            ->name('get_data_mobile_api');
    //route cho nhân viên tiếp tân
    //đợi kết quả xet nghiem
    Route::get('waitingTestListForTeller.json', 'StaffController@listWaitingTestForTellerAsJson')
            ->name('teller-waiting-test-list-as-json');
    Route::get('listWaitingTestPatientForTeller', ['as' => 'StaffController.list.waitingTestPatientForTeller', 'uses' => 'StaffController@listWaitingTestPatientForTeller']);
    //kết quả xet nghiem
    Route::get('compeleteTestListForTeller.json', 'StaffController@listCompeleteTestForTellerAsJson')
            ->name('teller-compelete-test-list-as-json');
    Route::get('listCompeleteTestPatientForTeller', ['as' => 'StaffController.list.compeleteTestPatientForTeller', 'uses' => 'StaffController@listCompeleteTestPatientForTeller']);

    //đợi kết quả khám chuyên khoa
    Route::get('waitingSpecialistListForTeller.json', 'StaffController@listWaitingSpecialistForTellerAsJson')
            ->name('teller-waiting-specialist-list-as-json');
    Route::get('listWaitingSpecialistPatientForTeller', ['as' => 'StaffController.list.waitingSpecialistPatientForTeller', 'uses' => 'StaffController@listWaitingSpecialistPatientForTeller']);
    //kết quả khám chuyên khoa
    Route::get('compeleteSpecialistListForTeller.json', 'StaffController@listCompeleteSpecialistForTellerAsJson')
            ->name('teller-compelete-special-list-as-json');
    Route::get('listCompeleteSpecialistPatientForTeller', ['as' => 'StaffController.list.compeleteSpecialistPatientForTeller', 'uses' => 'StaffController@listCompeleteSpecialistPatientForTeller']);

    //đợi kết quả khám sức khỏe
    Route::get('waitingHealthListForTeller.json', 'StaffController@listWaitingHealthForTellerAsJson')
            ->name('teller-waiting-health-list-as-json');
    Route::get('listWaitingHealthPatientForTeller', ['as' => 'StaffController.list.waitingHealthPatientForTeller', 'uses' => 'StaffController@listWaitingHealthPatientForTeller']);
    //kết quả khám sức khỏe
    Route::get('compeleteHealthListForTeller.json', 'StaffController@listCompeleteHealthForTellerAsJson')
            ->name('teller-compelete-health-list-as-json');
    Route::get('listCompeleteHealthPatientForTeller', ['as' => 'StaffController.list.compeleteHealthPatientForTeller', 'uses' => 'StaffController@listCompeleteHealthPatientForTeller']);
    Route::get('settingMedical', 'StaffController@settingMedical')
            ->name('settingMedical');
    Route::get('getListNotice', 'StaffController@getListNotice')
            ->name('getListNotice');
});

#Route for Bac si
# giap: them middleware web
Route::group(['prefix' => 'doctor', 'middleware' => 'web'], function () {
    Route::get('', function() {
        return redirect()->route('doctor-index');
    });

    Route::get('index', 'DoctorController@index')
            ->name('doctor-index');

    Route::get('list', 'DoctorController@listPatient')
            ->name('doctor-list');
    Route::get('listSick', 'DoctorController@listSick')
            ->name('doctor-sick-list');
    Route::get('waitForTestList', 'DoctorController@WaitForTestListPatient')
            ->name('doctor-for-test-list');
    Route::get('diagnodeList', 'DoctorController@DiagnodeListPatient')
            ->name('doctor-diagnode-list');
    Route::get('compeleteList', 'DoctorController@CompeleteListPatient')
            ->name('doctor-compelete-list');
    Route::get('list.json', 'DoctorController@listAsJson')
            ->name('list-as-json');
    Route::get('waitForTestList.json', 'DoctorController@WaitForTestListAsJson')
            ->name('wait-for-test-list-as-json');
    Route::get('diagnodeList.json', 'DoctorController@DiagnodeListAsJson')
            ->name('diagnode-list-as-json');
    Route::get('compeleteList.json', 'DoctorController@CompeleteListAsJson')
            ->name('compelete-list-as-json');
    Route::get('testDetailDoctor.json/{id}', 'DoctorController@medical_test_detail_as_json')
            ->name('test-detail-json');
    // Below route is handle by id
    Route::get('medical_exam/{id}', 'DoctorController@medical_exam')
            ->name('medical_exam_by_id');
    Route::post('update-medical-info', 'DoctorController@updateMedicalInfo')
            ->name('update-medical-info');
    
     Route::get('MedicalListAsJson','DoctorController@MedicalListAsJson')
        ->name('medical-list-as-json');
     
      Route::get('medical_list','DoctorController@MedicalList')
        ->name('doctor-medical-list');
      
       Route::get('MedicalListCompleteAsJson','DoctorController@MedicalListCompleteAsJson')
        ->name('medical-list-complete-as-json');
     
      Route::get('medical_list_complete','DoctorController@MedicalListComplete')
        ->name('doctor-medical-list-complete');

    //Route seach patient
    Route::get('search.json', 'DoctorController@searchAsJson')
            ->name('search-as-json');
    // Below route is handle by id
    //thua
    Route::get('his_patient/{id}', 'DoctorController@history_patient')
            ->name('history_patient_by_id');
    Route::get('his_patient/{id}', 'DoctorController@history_patient')
            ->name('history_patient_by_id');
    Route::get('info', 'DoctorController@info')
            ->name('doctor-info');
    Route::get('getInfoPatient/{id}', 'DoctorController@getInfoPatient')
            ->name('doctor-getInfoPatient');
    Route::post('info', 'DoctorController@updateInfo');
    Route::get('search', 'DoctorController@search')
            ->name('doctor-search');

    Route::get('about', 'DoctorController@about')
            ->name('doctor-about');

    Route::post('share', 'DoctorController@postShare')->name('doctor-share');

    //khám chuyên khoa
    Route::post('examination_begin', 'DoctorController@ExaminationBegin')
            ->name('examination_begin');
    Route::post('examination_end', 'DoctorController@ExaminationEnd')
            ->name('examination_end');
    Route::get('getListNotice', 'DoctorController@getListNotice')
            ->name('getListNotice');
    Route::post('test_insert', 'DoctorController@testInsert')
            ->name('test_insert');

//lấy kết quả và gửi lại kết quả qua Api
     Route::get('get_API_connect/{roomID}', 'DoctorController@getAPIConnect')
            ->name('get_API_connect');
     Route::get('get_API_disconnect/{roomID}', 'DoctorController@getAPIDisconnect')
            ->name('get_API_disconnect');
     Route::get('get_API_result', 'DoctorController@getAPIResult');

});

Route::post('remove-medical-application', 'PatientController@removeMedical');

Route::post('share', 'OAuthController@postShare')->name('oauth-share');


//Route::post('logout','Auth\LoginController@logout');

//Oauth

