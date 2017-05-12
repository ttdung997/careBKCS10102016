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
Route::get('/',function(){
  return view('welcome');
});
Route::get('/home', 'HomeController@index');

#login and logout
// Auth::routes();
#
#Route for patient
Route::group(['prefix' => 'patient'], function () {
  Route::get('',function(){
    return redirect()->route('patient-index');
  });
  Route::get('index','PatientController@index')
    -> name('patient-index');
  Route::get('info','PatientController@info')
    -> name('patient-info');
  Route::post('info','PatientController@capNhatInfo');
  Route::get('register','PatientController@register')
    -> name('patient-register');
  Route::get('history','PatientController@history')
    -> name('patient-history');
  Route::get('history.json','PatientController@history_as_json')
    -> name('history-json');
  Route::get('detail.json/{id}','PatientController@medical_app_detail_as_json')
    -> name('detail-json');
  Route::get('detail.json','PatientController@detail_json')
    -> name('detail-json-demo');
  Route::get('about','PatientController@about');
  Route::post('register','PatientController@sendRegister');
  Route::post('cancel-register','PatientController@cancelRegister');
  Route::post('share','PatientController@postShare')
    -> name('patient-share');
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
    Route::get('role/doctor/{id}',['as' => 'AdminController.role.doctor','uses' => 'AdminController@showDoctorRole']);
    Route::get('/listDoctorOfRole/{id}',['as'=>'AdminController.role.listDoctorOfRole','uses'=>'AdminController@listUserOfRole']);
    Route::delete('role/deleteDoctor/',['as'=>'AdminController.role.deleteDoctor','uses'=>'AdminController@deleteDoctorOfRole']);
    Route::post('role/addDoctorforRole',['as'=>'AdminController.role.addDoctorforRole','uses'=>'AdminController@addDoctorforRole']);

    //Doctor management
    Route::get('listDoctor', ['as' => 'AdminController.list.doctor', 'uses' => 'AdminController@listDoctor']);
    Route::get('doctor', ['as' => 'AdminController.index.doctor', 'uses' => 'AdminController@indexDoctor']);
    Route::get('doctor/show/{id}', ['as' => 'AdminController.show.doctor', 'uses' => 'AdminController@showDoctor']);
    Route::post('doctor/add', ['as' => 'AdminController.store.doctor', 'uses' => 'AdminController@storeDoctor']);
    Route::match(['get', 'patch'], 'doctor/edit/{id}', ['as' => 'AdminController.update.doctor', 'uses' => 'AdminController@updateDoctor']);
    Route::delete('doctor/destroy', ['as' => 'AdminController.destroy.doctor', 'uses' => 'AdminController@destroyDoctor']);
    Route::get('doctor/role/{id}',['as'=>'AdmonController.doctor.role','uses'=>'AdminController@showRoleDoctor']);
    Route::get('/listRoleOfDoctor/{id}',['as'=>'AdminController.doctor.listRoleOfDoctor','uses'=>'AdminController@listRoleOfDoctor']);
    Route::delete('doctor/deleteRole/',['as'=>'AdminController.doctor.deleteRole','uses'=>'AdminController@deleteRoleOfDoctor']);
    Route::post('doctor/addRoleforDoctor',['as'=>'AdminController.doctor.addRoleforDoctor','uses'=>'AdminController@addRoleforDoctor']);

    // Hospital management
    Route::get('hospital',['as'=>'AdminController.index.hospital','uses'=>'AdminController@indexHospital']);
    Route::get('listHospital',['as'=>'AdminController.index.listHospital','uses'=>'AdminController@listHospital']);
    Route::get('hospital/show/{id}', ['as' => 'AdminController.show.hospital', 'uses' => 'AdminController@showHospital']);

    //Department management
    Route::get('listDepartment', ['as' => 'AdminController.list.department', 'uses' => 'AdminController@listDepartment']);
    Route::get('department', ['as' => 'AdminController.index.department', 'uses' => 'AdminController@indexDepartment']);
    Route::get('department/show/{id}', ['as' => 'AdminController.show.department', 'uses' => 'AdminController@showDepartment']);
    Route::post('department/add', ['as' => 'AdminController.store.department', 'uses' => 'AdminController@storeDepartment']);
    Route::match(['get', 'patch'], 'department/edit/{id}', ['as' => 'AdminController.update.department', 'uses' => 'AdminController@updateDepartment']);
    Route::delete('department/destroy', ['as' => 'AdminController.destroy.department', 'uses' => 'AdminController@destroyDepartment']);

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
    Route::match(['get', 'patch'], 'medicalApplication/edit/{id}', ['as' => 'StaffController.update.medicalApplication', 'uses' => 'StaffController@updateMedicalApplication']);
    Route::delete('medicalApplication/destroy', ['as' => 'StaffController.destroy.medicalApplication', 'uses' => 'StaffController@destroyMedicalApplication']);
    //them by me
    Route::get('list2.json','StaffController@listAsJson')
        ->name('list-as-json-staff');


    //Patient management
    Route::get('listPatient', ['as' => 'StaffController.list.patient', 'uses' => 'StaffController@listPatient']);
    Route::get('patient', ['as' => 'StaffController.index.patient', 'uses' => 'StaffController@indexPatient']);
    Route::get('patient/show/{id}', ['as' => 'StaffController.show.patient', 'uses' => 'StaffController@showPatient']);
    Route::post('patient/add', ['as' => 'StaffController.store.patient', 'uses' => 'StaffController@storePatient']);
    Route::match(['get', 'patch'], 'patient/edit/{id}', ['as' => 'StaffController.update.patient', 'uses' => 'StaffController@updatePatient']);
    Route::delete('patient/destroy', ['as' => 'StaffController.destroy.patient', 'uses' => 'StaffController@destroyPatient']);
});

#Route for Bac si
Route::group(['prefix' => 'doctor'], function () {
    Route::get('',function(){
      return redirect()->route('doctor-index');
    });

    Route::get('index','DoctorController@index')
      ->name('doctor-index');

    Route::get('list','DoctorController@listPatient')
       ->name('doctor-list');
    Route::get('list.json','DoctorController@listAsJson')
        ->name('list-as-json');
    // Below route is handle by id
    Route::get('medical_exam/{id}','DoctorController@medical_exam')
        ->name('medical_exam_by_id');
    Route::post('update-medical-info','DoctorController@updateMedicalInfo')
        -> name('update-medical-info');

    //Route seach patient
    Route::get('search.json','DoctorController@searchAsJson')
        ->name('search-as-json');
    // Below route is handle by id

    //thua
    Route::get('his_patient/{id}','DoctorController@history_patient')
        ->name('history_patient_by_id');
    Route::get('his_patient/{id}','DoctorController@history_patient')
        ->name('history_patient_by_id');



    Route::get('info','DoctorController@info')
        ->name('doctor-info');
    Route::post('info','DoctorController@updateInfo');
    Route::get('search','DoctorController@search')
        ->name('doctor-search');

    Route::get('about','DoctorController@about')
        ->name('doctor-about');

    Route::post('share','DoctorController@postShare')->name('doctor-share');

});

Route::post('remove-medical-application','PatientController@removeMedical');

Route::post('share','OAuthController@postShare')->name('oauth-share');


//Route::post('logout','Auth\LoginController@logout');

//Oauth

