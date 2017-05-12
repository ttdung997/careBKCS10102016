<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\RBACController\UserManagement;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        // if(Auth::user()->position ==  UserManagement::ADMIN_POSITION){
        //     return redirect()->route('AdminController.index');
        // }
        return view('home');
    }
}
