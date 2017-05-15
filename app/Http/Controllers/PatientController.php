<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon; //Dung de quan ly ngay thang
use App\Http\Requests\MedicalApplicationRequest;
use App\Model\MedicalApplication;
use App\User;
use App\Http\Requests\UserRequest;
use Response;
use Auth;
use Symfony\Component\VarDumper\Cloner\Data;
use Validator;
use File;
use Session;
use Image;
use Storage;
use App\OAuth\OAuthorization;
use App\RBACController\PatientManagement;
use App\RBACController\RoleManagement;
use App\Model\Role;
use App\Model\Share;
use App\RBACController\ShareManagement;






class PatientController extends Controller
{
    private $patient_mng;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('patient');
        $this->patient_mng = new PatientManagement();
    }

    public function index(){
        return view('patient.index'); 
    }

    public function info(){
        
        $patient_info = array(
            'fullname' => Auth::user()->name,
            'avatar' => '/upload/avatars/'.Auth::user()->avatar,
            'is_male' =>   (Auth::user()->gender=='Nam' ? 'checked' : '' ),
            'is_female' => (Auth::user()->gender=='Nữ' ? 'checked' : '' ),
            'birthday' =>   Carbon::parse(Auth::user()->birthday)->toDateString(),
            'id_number' =>   Auth::user()->id_number,           
            'id_date' =>   Carbon::parse(Auth::user()->id_date)->toDateString(),
            'id_address' =>   Auth::user()->id_address,
            'permanent_residence' =>  Auth::user()->permanent_residence,
            'staying_address' =>   Auth::user()->staying_address,
            'job' =>   Auth::user()->job,
            'company' =>   Auth::user()->company,
            'family_history' =>   Auth::user()->family_history,
            'personal_history' =>   Auth::user()->personal_history,
            );
        return view('patient.info')->with($patient_info);
    }
    public function register(){
        $user_id = Auth::user()->id;
        
        $don_kham = DB::table('medical_applications')->where
            ([
                ['user_id' , Auth::user()->id],
                ['status' , 1 ]
                ])
        ->first();
        
        if( $don_kham === null){
            return view('patient.register');
        }
        else{
            $data = array(
                'don_kham_id' => $don_kham->id,
                'ngay_kham' => $don_kham->date,
            );
            return view('patient.register-info')->with($data);
        }
    }


    public function history(){
        $role_be_shareds = Share::where('resource_owner','=',Auth::user()->id)->get();
        $roles = array();
        foreach ($role_be_shareds as $item) {
            $roles[] = $item->role_id;
        }
        $role_data = Role::wherenotIn('id',[RoleManagement::PATIENT_ROLE,RoleManagement::STAFF_ROLE])->orderBy('id')->get()->toArray();
        return view('patient.history',compact('role_data','roles'));
    }

    public function history_as_json(){
        $medical_list = MedicalApplication::where('user_id',Auth::user()->id)->get();
        return $medical_list;
    }

    public function medical_app_detail_as_json($id){
        $medical = MedicalApplication::where('id',$id)->first();

        try {
            $contents = Storage::get($medical->url);    
        } catch (\Exception $e) {
            return "Không tìm thấy file đơn khám";
        }
        


        $medical_application_xml = simplexml_load_string($contents);


        // Chứng thực người dùng có quyền truy cập đơn khám hay không.
        if (Auth::user()->id == $medical->user_id ){
            
            $data = ((array)$medical_application_xml);
            return view('json.medical')->with($data);

        }
        else{
            return "Bạn không có quyền truy cập vào trang này.";
        }
    }

    public function about(){
        return view('patient.about');
    }


    public function capNhatInfo(Request $request){
        // Lấy ra id của bệnh nhân
        $patient_id = Auth::user()->id;

        $patient_data = array(
            'name' => Input::get('fullname'),
                'gender' => Input::get('gender'),
                'birthday' => Input::get('birthday'),
                'id_number' => Input::get('id_number'),           
                'id_date' => Input::get('id_date'),
                'id_address' => Input::get('id_address'),
                'permanent_residence' => Input::get('permanent_residence'),
                'staying_address' => Input::get('staying_address'),
                'job' => Input::get('job'),
                'company' => Input::get('company'),
                'family_history' => Input::get('family_history'),
                'personal_history' => Input::get('personal_history'),
            );
        if($request->hasFile('avatar')){

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->fit(400,600)->save( public_path('/upload/avatars/' . $filename ) );
            $patient_data['avatar'] = $filename;
            $this->patient_mng ->updatePatient($patient_id,$patient_data);
        
        }
        return redirect()->route('patient-info');
    }

    public function sendRegister(MedicalApplicationRequest $request){
        

        $medical_application = new MedicalApplication();
        $medical_application->user_id = Auth::user()->id;
        $medical_application->status = 1;
        $url = Carbon::now()->toDateString() .'-'. Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';
        $medical_application->url = $url;
        $medical_application->date = date("Y-m-d H:i:s");
        $medical_application->save();
        Storage::copy('donkham.xml', $url);

        return redirect()->route('patient-register');

    }
    
    public function cancelRegister(){
        $id = Input::get('don_kham_id');
        $medical = MedicalApplication::where('id',$id)->delete();
        return redirect()->route('patient-register');
    }

    public function removeMedical(){
        $id = Input::get('medical_id');
        $medical = MedicalApplication::where('id',$id)->delete();
        return redirect()->route('patient-history');
    }

    public function postShare(Request $request){
        $roles = $request ->role;
        $resource_owner = Auth::user()->id;
        $medical = MedicalApplication::where('user_id','=',$resource_owner)->first();
        // dd($medicals->id);

        $share_mng = new ShareManagement();
        if($medical){
            $roles = $request ->role;
            $resource_id = $medical->id;
            $resource_owner = Auth::user()->id;
            $share_mng ->addShare($resource_owner, $roles, $resource_id);
            return redirect()->route('patient-history',['id' => $resource_id])->with(['flash_level' => 'success', 'flash_message_success' => 'thành công !! Bạn đã thực hiện chia sẻ bệnh án thành công']);
        }
        else{
            return redirect()->route('patient-history')->with(['flash_level' => 'success', 'flash_message' => 'Cảnh báo!! Bạn chưa đăng ký khám lần nào']);;
        }
    }
}
