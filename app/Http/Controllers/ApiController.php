<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\RBACController\UserManagement;
use Giaptt\Oidcda\Authen;
use App\Http\email;
use Hash;
use DB;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return redirect()->route('patient-index');
        if(Auth::user()->position == UserManagement::PATIENT_POSITION){
            return redirect()->route('patient-index');
        }
        if(Auth::user()->position == UserManagement::DOCTOR_POSITION){
            return redirect()->route('doctor-index');
        }        
        if(Auth::user()->position == UserManagement::STAFF_POSITION){
            return redirect()->route('StaffController.index');
        }
//         if(Auth::user()->position ==  UserManagement::ADMIN_POSITION){
//             return redirect()->route('AdminController.index');
//         }
        return view('home');
    }
    public function getToken(Request $request){
        $user = DB::table('users')->where('email',$request->email)->first();
        if (hash('sha256', $request->password) == $user->password){
            print("creates new token\n");
            $token = $user->remember_token;
            print($token);
            setcookie('token', $token, time() + (100), "/");
            setcookie('login', 1, time() + (100), "/");
        }else{
            echo "can't not generate token";
            setcookie('login', 0, time() + (100), "/");
        }
        $msg = "oke";
        return response()->json(array('msg' => $msg), 200);

    }
    public function cacheDataFormMobile(Request $request){
        $email = $request->all();
        $user = DB::table('users')->where('remember_token',$request->remember_token)->first();
        // print_r($user);
        if($user != NULL){
            $check =  DB::table('medical_api_data')->where('medical_test_id',$request->medicalId)->first();
            print("Validate!!!\n");
            if($check == NULL){
                DB::table('medical_api_data')->insert(
                    ['medical_test_id' =>  $request->medicalId, 'param' => $request->param]
                );
            }else{
                DB::table('medical_api_data')
                    ->where('medical_test_id', $request->medicalId)
                    ->update(['param' => $request->param]);
            }
        }else{
            echo "can't not validate token";
            
        }
        $msg = "oke";
        return response()->json(array('msg' => $msg), 200);

    }
    public function getMedicalIDformMobile(Request $request){
        $email = $request->all();
        $user = DB::table('users')->where('remember_token',$request->remember_token)->first();
        // print_r($user);
        if($user != NULL){
            // print("Validate!!!\n");
            $id = DB::table('medical_test_applications')->where([
                ['xetnghiem', '=', $request->type],
                ['patient_id', '=', $request->patiend_id]
            ])->orderBy('id', 'desc')->first()->id;
        }
        else $id =-1;
        return response()->json(array('id' => $id), 200);

    }
}
