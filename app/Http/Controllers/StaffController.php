<?php

namespace App\Http\Controllers;

use App\Model\MedicalApplication;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\MedicalApplicationRequest;
use Response;
use Auth;
use Symfony\Component\VarDumper\Cloner\Data;
use Validator;
use File;
use Session;
use Carbon\Carbon;
use Storage;
use App\RBACController\PatientManagement;
use App\RBACController\MedicialManagement;

class StaffController extends Controller
{
    private $patient_mng;
    private $medicial_mng;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('staff');
        $this->patient_mng = new PatientManagement();
        $this->medicial_mng = new MedicialManagement();
    }
    
    public function index()
    {
        return view('staff.index');
    }

    /**
    * Lấy ra danh sách bệnh nhân
    */ 
    public function listPatient()
    {
        $patients = $this->patient_mng->getListPatient();
        return Response::json(['data' => $patients]);
    }

    /**
    * Hiện ra view bệnh nhân để làm việc
    */ 
    public function indexPatient()
    {
        return view('staff.patient');
    }

    /**
    * Trả về danh sách đơn khám đang ở trạng thái chờ khám
    */ 
    public function listAsJson(){
        $medical_list_staff = $this ->medicial_mng ->getListMedicialExam(MedicialManagement::AWAIT_STATUS);
        return $medical_list_staff;  
    }


    //đây là cái cũ, cái này có giá trị trả về hàm bên trên thì ko
     public function listAsJson2(){
        //return file Json medical list
        $medical_list_staff = MedicalApplication::where('status',1)->get();
     
        return $medical_list_staff;    
    }

    public function storePatient(UserRequest $request)
    {
        $this->patient_mng->addPatient($request->name, $request->email, $request->hashPass);

        return Response::json(['flash_message' => 'Đã thêm bệnh nhân!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function showPatient($id)
    {
        $patient = $this->patient_mng->getInfoPatient($id);
        return Response::json($patient);
    }

    public function updatePatient($id, UserRequest $request)
    {
        if ($request->isMethod('patch')) {
            $this->patient_mng ->editPatient($id, $request->name, $request ->email, $request ->hashPass);

            return Response::json(['flash_message' => 'Đã cập nhật thông tin bệnh nhân!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $patient = $this->patient_mng->getInfoPatient($id);
            return Response::json($patient);
        }
    }

    public function destroyPatient(UserRequest $request)
    {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL)
                $this->patient_mng ->deletePatient($user_id);
        }
        return Response::json(['flash_message' => 'Đã xóa bệnh nhân!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    // tạo mới hồ sơ khám
    public function storeMedicalApplication(MedicalApplicationRequest $request)
    {
        $medicial_data = array();
        $url = Carbon::now()->toDateString() .'-'. Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';
        $medicial_data['url'] = $url;
        $this->patient_mng ->registerExaminal($request->userId,$medicial_data);

        return Response::json(['flash_message' => 'Đã đăng ký khám cho bệnh nhân này!', 'message_level' => 'success', 'message_icon' => 'check']);
    }


    public function listMedicalApplication()
    {
        $users = User::where('position', 1)->orderBy('id', 'DESC')->get();
        return Response::json(['data' => $users]);
    }

    public function indexMedicalApplication()
    {
        return view('staff.MedicalApplication');
    }

    public function showMedicalApplication($id)
    {
        $user = User::findOrFail($id);
        return Response::json($user);
    }

    public function updateMedicalApplication($id, UserRequest $request)
    {
        if ($request->isMethod('patch')) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            if (isset($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            return Response::json(['flash_message' => 'Đã cập nhật thông tin bệnh nhân!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $user = User::findOrFail($id);
            return Response::json($user);
        }
    }

    public function destroyMedicalApplication(UserRequest $request)
    {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL)
                User::findOrFail($user_id)->delete();
        }
        return Response::json(['flash_message' => 'Đã huỷ đơn khám!', 'message_level' => 'success', 'message_icon' => 'check']);
    }
}
