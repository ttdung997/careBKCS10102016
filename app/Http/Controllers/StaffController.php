<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\MedicalApplication;
use App\Model\MedicalTestApplication;
use App\Model\MedicalSpecialistApplication;
use App\Model\Permission;
use App\Model\Role;
use App\Model\Patient;
use App\Model\Share;
use App\Model\Staff;
use App\User;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Http\Requests\MedicalApplicationRequest;
use Response;
use Auth;
use DB;
use Symfony\Component\VarDumper\Cloner\Data;
use Validator;
use File;
use Session;
use Carbon\Carbon;
use Storage;
use App\RBACController\PatientManagement;
use App\RBACController\MedicialManagement;
use App\RBACController\UserManagement;
use App\RBACController\ShareManagement;
use App\RBACController\RoleManagement;
use App\OAuth\OAuthorization;
use App\RBACController\ApiManagement;

class StaffController extends Controller {

    private $patient_mng;
    private $medicial_mng;

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('staff');
        $this->patient_mng = new PatientManagement();
        $this->medicial_mng = new MedicialManagement();
    }

    public function index() {
        return view('staff.index');
    }

    /**
     * Lấy ra danh sách bệnh nhân
     */
    public function listPatient() {
        $patients = $this->patient_mng->getListPatient();
        return Response::json(['data' => $patients]);
    }

    /**
     * Hiện ra view bệnh nhân để làm việc
     */
    public function indexPatient() {
        return view('staff.patient');
    }

    /**
     * Trả về danh sách đơn khám đang ở trạng thái chờ khám
     */
    public function listAsJson() {
        $medical_list_staff = $this->medicial_mng->getListMedicialExam(MedicialManagement::AWAIT_STATUS);
        return $medical_list_staff;
    }

//đây là cái cũ, cái này có giá trị trả về hàm bên trên thì ko
    public function listAsJson2() {
//return file Json medical list
        $medical_list_staff = MedicalApplication::where('status', 1)->get();

        return $medical_list_staff;
    }

    public function storePatient(UserRequest $request) {
        $this->patient_mng->addPatient($request->name, $request->email, $request->hashPass);
        $patientInfo = Patient::orderBy('patient_id', 'desc')->update([
            'gender' => $request->gender,
            'birthday' => $request->birthday,
            'personal_history' => $request->personal_history,
            'family_history' => $request->family_history,
        ]);
        return Response::json(['flash_message' => 'Đã thêm bệnh nhân!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function showPatient($id) {
        $patient = $this->patient_mng->getInfoPatient($id);
        $patientInfo = Patient::where('patient_id', $id)->first();
        return Response::json(array('patient' => $patient, 'patientInfo' => $patientInfo));
    }

    public function updatePatient($id, UserRequest $request) {
        if ($request->isMethod('patch')) {
            $this->patient_mng->editPatient($id, $request->name, $request->email, $request->hashPass);
            $patient = Patient::where('patient_id', $id)
                    ->update(['fullname' => $request->name]);
//            if (!$patient) {
//                $patient = Patient::insert(['name' => $request->fullname,'patient_id' => $id]);
//            }
            return Response::json(['flash_message' => 'Đã cập nhật thông tin bệnh nhân!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $patient = $this->patient_mng->getInfoPatient($id);
            return Response::json($patient);
        }
    }

    public function destroyPatient(UserRequest $request) {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL) {
                $que1 = DB::table('medical_applications')->where('patient_id', $user_id)->first();
                $que2 = DB::table('medical_specialist_applications')->where('patient_id', $user_id)->first();
                $que3 = DB::table('medical_test_applications')->where('patient_id', $user_id)->first();
                if ($que1 || $que2 || $que3) {
                    $name = Patient::where('patient_id', $user_id)->first()->fullname;
                    return Response::json(['flash_message' => 'Không thể xóa bệnh nhân ' . $name, 'message_level' => 'danger', 'message_icon' => 'exclamation-circle']);
                } else {
                    $this->patient_mng->deletePatient($user_id);
                    Patient::where('patient_id', $user_id)->delete();
                }
            }
        }
        return Response::json(['flash_message' => 'Đã xóa bệnh nhân!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

// tạo mới hồ sơ khám
// 
//khám sức khoe

    public function storeMedicalApplication(MedicalApplicationRequest $request) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;
        $checkQuery = MedicalApplication::where('patient_id', $request->userId)
                        ->where('status', 1)->first();
        if (!$checkQuery) {
            $medicial_data = array();
            $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';
            $medicial_data['url'] = $url;
            $medicial_data['Shift'] = $Shift;
            $this->patient_mng->registerExaminal($request->userId, $medicial_data);

            return Response::json(['flash_message' => 'Đã đăng ký khám cho bệnh nhân này!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            return Response::json(['flash_message' => 'Bệnh nhân đã được đăng kí từ trước!', 'message_level' => 'danger', 'message_icon' => 'exclamation-circle']);
        }
    }

//khám chuyên khoa

    public function storeMedicalSpecialistApplication(MedicalApplicationRequest $request) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;
        $checkQuery = MedicalSpecialistApplication::where('patient_id', $request->userId)
                        ->where('status', 1)->first();
        if (!$checkQuery) {
            $medical_application = new MedicalSpecialistApplication();
            $medical_application->patient_id = $request->userId;
            $medical_application->status = 1;
            $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';
            $medical_application->medical_date = $request->medical_date;
            $medical_application->khoa = $request->khoa;
            $medical_application->Shift = $Shift;
            $medical_application->medical_type = $request->medical_type;
            $medical_application->url = $url;
            $medical_application->date = date("Y-m-d H:i:s");
            $medical_application->save();
            Storage::copy('donkham.xml', $url);

            return Response::json(['flash_message' => 'Đã đăng ký khám cho bệnh nhân này!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            return Response::json(['flash_message' => 'Bệnh nhân đã được đăng kí từ trước!', 'message_level' => 'danger', 'message_icon' => 'exclamation-circle']);
        }
    }

    public function storeMedicalTestApplication(MedicalApplicationRequest $request) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;
        $checkQuery = MedicalTestApplication::where('patient_id', $request->userId)
                        ->where('status', 1)->first();
        if (!$checkQuery) {
            $medical = $_GET['Medical'];
            foreach ($medical as $medical) {
                $medical_application = new MedicalTestApplication();
                $medical_application->patient_id = $request->userId;
                $medical_application->status = 1;
                $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';

                $medical_application->xetnghiem = $medical;

                $medical_application->url = $url;
                $medical_application->Shift = $Shift;

                $medical_application->medical_date = $request->medical_date;
                $medical_application->date = date("Y-m-d H:i:s");
                $medical_application->save();
                Storage::copy('XN_chieucao.xml', $url);
            }
            return Response::json(['flash_message' => 'Đã đăng ký khám cho bệnh nhân này!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            return Response::json(['flash_message' => 'Bệnh nhân đã được đăng kí từ trước!', 'message_level' => 'danger', 'message_icon' => 'exclamation-circle']);
        }
    }

    public function listMedicalApplication() {
        $users = User::where('position', 1)->orderBy('id', 'DESC')->get();
        return Response::json(['data' => $users]);
    }

    public function indexMedicalApplication() {
        return view('staff.MedicalApplication');
    }

    public function showMedicalApplication($id) {
        $user = User::findOrFail($id);
        return Response::json($user);
    }

    public function updateMedicalApplication($id, UserRequest $request) {
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

    public function destroyMedicalApplication(UserRequest $request) {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL)
                User::findOrFail($user_id)->delete();
        }
        return Response::json(['flash_message' => 'Đã huỷ đơn khám!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    public function listTestPatient() {
        return view('staff.testPatient');
    }

    public function listWaitingTestPatient() {
        return view('staff.testPatient-waiting');
    }

    public function listCompeleteTestPatient() {
        return view('staff.testPatient-compelete');
    }

    public function listFutureTestPatient() {
        return view('staff.testPatient-future');
    }

    /**
     * Lấy ra danh sách bệnh nhân đang chờ khám
     */
    public function listTestAsJson() {
//$number = DB::table('user_infomation')->where('user_id', Auth::user()->id)->first()->phongban_id;
        $number = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->phongban;
        $medicial_list = $this->medicial_mng->getListTestMedicialToday(MedicialManagement::AWAIT_STATUS, $number);
        return $medicial_list;
    }

    public function listWaitingTestAsJson() {
//  $number = DB::table('user_infomation')->where('user_id', Auth::user()->id)->first()->phongban_id;
        $number = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->phongban;

        $medicial_list = $this->medicial_mng->getListTestMedicial(MedicialManagement::WAITING_STATUS, $number);
        return $medicial_list;
    }

    public function listCompeleteTestAsJson() {
// $number = DB::table('user_infomation')->where('user_id', Auth::user()->id)->first()->phongban_id;
        $number = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->phongban;
        $medicial_list = $this->medicial_mng->getListTestMedicial(MedicialManagement::COMPLETE_STATUS, $number);
        return $medicial_list;
    }

    public function listFutureTestAsJson() {
// $number = DB::table('user_infomation')->where('user_id', Auth::user()->id)->first()->phongban_id;
        $number = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->phongban;
        $medicial_list = $this->medicial_mng->getListFutureTestMedicial(MedicialManagement::AWAIT_STATUS, $number);
        return $medicial_list;
    }

//nhân viên tiếp tân
    public function listWaitingTestPatientForTeller() {
        return view('staff.teller.testPatient-waiting');
    }

    public function listCompeleteTestPatientForTeller() {
        return view('staff.teller.testPatient-compelete');
    }

    public function listWaitingSpecialistPatientForTeller() {
        return view('staff.teller.specialistPatient-waiting');
    }

    public function listCompeleteSpecialistPatientForTeller() {
        return view('staff.teller.specialistPatient-compelete');
    }

    public function listWaitingHealthPatientForTeller() {
        return view('staff.teller.healthPatient-waiting');
    }

    public function listCompeleteHealthPatientForTeller() {
        return view('staff.teller.healthPatient-compelete');
    }

    public function listWaitingTestForTellerAsJson() {
        $medicial_list = $this->medicial_mng->getListTestMedicialForTeller();
        return $medicial_list;
    }

    public function listCompeleteTestForTellerAsJson() {

        $medicial_list = $this->medicial_mng->getListCompeleteTestMedicialForTeller();
        return $medicial_list;
    }

    public function listWaitingSpecialistForTellerAsJson() {
        $medicial_list = $this->medicial_mng->getListSpecialistMedicialForTeller();
        return $medicial_list;
    }

    public function listCompeleteSpecialistForTellerAsJson() {

        $medicial_list = $this->medicial_mng->getListCompeleteSpecialistMedicialForTeller();
        return $medicial_list;
    }

    public function listWaitingHealthForTellerAsJson() {
        $medicial_list = $this->medicial_mng->getListHealthMedicialForTeller();
        return $medicial_list;
    }

    public function listCompeleteHealthForTellerAsJson() {

        $medicial_list = $this->medicial_mng->getListCompeleteHealthMedicialForTeller();
        return $medicial_list;
    }

//lấy ra file hr7 của đơn thuốc và ghi kết quả
    public function medical_test($medical_id) {


        $oauth = new OAuthorization();
// Từ id đơn khám, đọc từ database kiểm tra xem có đơn khám nào trùng id với id ban đầu không?
        $medical = MedicalTestApplication::where('id', $medical_id)->first();
        $xetnghiem = $medical->xetnghiem;
        /*
          Thử lấy url từ đơn khám, sau đó đọc nội dung file từ đơn khám, xuất ra dạng string đưa vào $contents
          Sau đó load contents thành một đối tượng XML để dễ dàng xử lý.
         */

        try {
            $contents = Storage::get($medical->url);
        } catch (\Exception $e) {
            return "Không tìm thấy file đơn khám";
        }



        $user = User::where('id', $medical->patient_id)->first();
        $birthday = substr($user->birthday, 0, 10);

        $medical_application_xml = simplexml_load_string($contents);
        $ktl = $medical_application_xml->kham_the_luc;
        $kls = $medical_application_xml->kham_lam_sang;
        $kcls = $medical_application_xml->kham_can_lam_sang;
        $kl = $medical_application_xml->ket_luan;
        $kham_the_luc_disabled = false;
        $noi_khoa_disabled = true;
        $mat_disabled = true;
        $rang_ham_mat_disabled = true;
        $can_lam_sang_disabled = true;
        $tong_quan_disabled = true;
        $tai_mui_hong_disabled = true;
        $da_lieu_disabled = true;

//dành cho xet nghiệm phổi

        $ktp = $medical_application_xml->phe_dung;

        /*
         * Kiểm tra quyền, nếu hợp lệ bỏ Disable
         *
         */
//            if ($oauth->checkPermission(Permission::TL_PERMISSION)) {
//                $kham_the_luc_disabled = false;
//            } else {
//                $kham_the_luc_disabled = true;
//            }
//            if ($oauth->checkPermission(Permission::NK_PERMISSION)) {
//                $noi_khoa_disabled = false;
//            } else {
//                $noi_khoa_disabled = true;
//            }
//            if ($oauth->checkPermission(Permission::MAT_PERMISSION)) {
//                $mat_disabled = false;
//            } else {
//                $mat_disabled = true;
//            }
//            if ($oauth->checkPermission(Permission::TMH_PERMISSION)) {
//                $tai_mui_hong_disabled = false;
//            } else {
//                $tai_mui_hong_disabled = true;
//            }
//            if ($oauth->checkPermission(Permission::RHM_PERMISSION)) {
//                $rang_ham_mat_disabled = false;
//            } else {
//                $rang_ham_mat_disabled = true;
//            }
//            if ($oauth->checkPermission(Permission::DL_PERMISSION)) {
//                $da_lieu_disabled = false;
//            } else {
//                $da_lieu_disabled = true;
//            }
//            if ($oauth->checkPermission(Permission::CLS_PERMISSION)) {
//                $can_lam_sang_disabled = false;
//            } else {
//                $can_lam_sang_disabled = true;
//            }
//            if ($oauth->checkPermission(Permission::TQ_PERMISSION)) {
//                $tong_quan_disabled = false;
//            } else {
//                $tong_quan_disabled = true;
//            }
// Lay ra danh sach role da duoc chia se tai nguyen
        $role_be_shareds = Share::where('resource_owner', '=', Auth::user()->id)->get();
        $roles = array();
        foreach ($role_be_shareds as $item) {
            $roles[] = $item->role_id;
        }

        $medical_data = array(
            'ten_benh_nhan' => $user->name,
            'ngay_sinh' => $birthday,
            'ho_khau' => $user->permanent_residence,
            'kham_the_luc_disabled' => $kham_the_luc_disabled,
            'noi_khoa_disabled' => $noi_khoa_disabled,
            'mat_disabled' => $mat_disabled,
            'tai_mui_hong_disabled' => $tai_mui_hong_disabled,
            'rang_ham_mat_disabled' => $rang_ham_mat_disabled,
            'da_lieu_disabled' => $da_lieu_disabled,
            'can_lam_sang_disabled' => $can_lam_sang_disabled,
            'tong_quan_disabled' => $tong_quan_disabled,
            'medical_id' => $medical_id,
            'chieu_cao' => $ktl->chieu_cao,
            'can_nang' => $ktl->can_nang,
            'huyet_ap' => $ktl->huyet_ap,
            //
            'FVC' => $ktp->FVC,
            'FEV1' => $ktp->FEV1,
            'PEF' => $ktp->PEF,
            'medical_id'=>$medical_id,
        );
        $medical = MedicalTestApplication::where('id', $medical_id)->update(['status' => MedicialManagement::WAITING_STATUS]);
        $role_data = Role::wherenotIn('id', [RoleManagement::PATIENT_ROLE, RoleManagement::STAFF_ROLE])->orderBy('id')->get()->toArray();
        if ($xetnghiem != 4) {
            return view('staff.medical_test', compact('role_data', 'medical_id', 'roles', 'hidden'))->with($medical_data);
        } else {
            return view('staff.COPD_test', compact('role_data', 'medical_id', 'roles', 'hidden'))->with($medical_data);
        }
    }

//ghi dữ liệu xét nghiệm
    public function updateTestMedicalInfo(Request $request) {

        $medical_id = $request->input('medicalID');
        $medical = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->where('medical_test_type.phongban', $request->input('room'))
                        ->where('medical_test_applications.id', $medical_id)->first();
        $contents = Storage::get($medical->url);
        $medical_application_xml = simplexml_load_string($contents);


        $chieu_cao = $request->input('chieu_cao');
        $medical_application_xml->kham_the_luc->chieu_cao = $chieu_cao;
        $can_nang = $request->input('can_nang');
        $medical_application_xml->kham_the_luc->can_nang = $can_nang;
        $huyet_ap = $request->input('huyet_ap');
        $medical_application_xml->kham_the_luc->huyet_ap = $huyet_ap;
        $check = $request->input('checkSubmit');
        $resource = $medical_application_xml->asXML();
        Storage::put($medical->url, $resource);
        if ($check) {
            $test = MedicalTestApplication::where('id', $medical_id)->update(['status' => MedicialManagement::COMPLETE_STATUS]);

            if ($test) {
                echo "đã thực hiện lệnh";
                $que = MedicalTestApplication::where('id', $medical_id)->where('status', '<>', MedicialManagement::COMPLETE_STATUS)->where('register_by', 2)->first();
                if (!$que)
                    MedicalSpecialistApplication::where('patient_id', $medical->patient_id)->where('status', 2)->update(['status' => 3]);
                return redirect('staff/listCompeleteTestPatient');
            }
        } else {
            return redirect('staff/listWaitingTestPatient');
            "lệnh sap sai!";
        }
    }

    public function updateCOPDTestMedicalInfo(Request $request) {

        $medical_id = $request->input('medicalID');
        $medical = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->where('medical_test_type.phongban', $request->input('room'))
                        ->where('medical_test_applications.id', $medical_id)->first();
        $contents = Storage::get($medical->url);
        $medical_application_xml = simplexml_load_string($contents);


        $FVC = $request->input('FVC');
        $medical_application_xml->phe_dung->FVC = $FVC;
        $FEV1 = $request->input('FEV1');
        $medical_application_xml->phe_dung->FEV1 = $FEV1;
        $PEF = $request->input('PEF');
        $medical_application_xml->phe_dung->PEF = $PEF;
        $check = $request->input('checkSubmit');
        $resource = $medical_application_xml->asXML();
        Storage::put($medical->url, $resource);
        if ($check) {
            $test = MedicalTestApplication::where('id', $medical_id)->update(['status' => MedicialManagement::COMPLETE_STATUS]);

            if ($test) {
                echo "đã thực hiện lệnh";
                $que = MedicalTestApplication::where('id', $medical_id)->where('status', '<>', MedicialManagement::COMPLETE_STATUS)->where('register_by', 2)->first();
                if (!$que)
                    MedicalSpecialistApplication::where('patient_id', $medical->patient_id)->where('status', 2)->update(['status' => 3]);
                //return redirect('staff/listCompeleteTestPatient');
            }
        } else {
            //return redirect('staff/listWaitingTestPatient');
            "lệnh sap sai!";
        }
    }

//lấy dữ liệu xét nghiệm của bệnh nhân
    public function medical_test_detail_as_json($id) {
        $medical = MedicalTestApplication::where('id', $id)->first();

        try {
            $contents = Storage::get($medical->url);
        } catch (\Exception $e) {
            return "Không tìm thấy file đơn khám";
        }



        $medical_application_xml = simplexml_load_string($contents);
        $data = ((array) $medical_application_xml);
        return view('json.test')->with($data);
    }

    public function medical_COPD_test_detail_as_json($id) {
        $medical = MedicalTestApplication::where('id', $id)->first();

        try {
            $contents = Storage::get($medical->url);
        } catch (\Exception $e) {
            return "Không tìm thấy file đơn khám";
        }



        $medical_application_xml = simplexml_load_string($contents);
        $data = ((array) $medical_application_xml);
        return view('json.COPD')->with($data);
    }

//lọc hẹ thống,xóa dữ liệu thừa
    public function settingMedical() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        //xóa các dữ liệu từ quá các ngày trước,làm sạch hệ thống
        MedicalApplication::where('medical_date', '<', \Carbon\Carbon::now()->toDateString())->where('status', 1)->delete();
        MedicalSpecialistApplication::where('medical_date', '<', \Carbon\Carbon::now()->toDateString())->where('status', 1)->delete();
        MedicalTestApplication::where('medical_date', '<', \Carbon\Carbon::now()->toDateString())->where('status', 1)->delete();

        //Lọc danh sách bệnh nhân,nếu không đến thì xóa toàn bộ bệnh nhân 

        if (Carbon::now()->hour > 17) {
            MedicalApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('status', 1)->delete();
            MedicalSpecialistApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('status', 1)->delete();
            MedicalTestApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('status', 1)->delete();
            MedicalApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('status', '>', 1)->update(['medical_date' => \Carbon\Carbon::tomorrow()->toDateString()]);
            MedicalSpecialistApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('status', '>', 1)->update(['medical_date' => \Carbon\Carbon::tomorrow()->toDateString()]);
            MedicalTestApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('status', '>', 1)->update(['medical_date' => \Carbon\Carbon::tomorrow()->toDateString()]);

            //Lọc danh sách,đổi ca khám    
        } else if (Carbon::now()->hour > 12) {
            MedicalApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('Shift', 1)->update(['Shift' => 2]);
            MedicalSpecialistApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('Shift', 1)->update(['Shift' => 2]);
            MedicalTestApplication::where('medical_date', \Carbon\Carbon::now()->toDateString())->where('Shift', 1)->update(['Shift' => 2]);
        }
        return redirect('staff/index');
    }

//lấy ra danh sách thông báo chờ
    public function getListNotice() {
        $room = Staff::where('staff_id', Auth::user()->id)->first()->phongban;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;
        $WaitTest = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->where('status', 1)
                        ->where('medical_test_applications.Shift', $Shift)
                        ->where('medical_test_type.phongban', $room)->count();
        $Waiting = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                ->where('status', 2)
                ->where('medical_test_applications.Shift', $Shift)
                ->where('medical_test_type.phongban', $room)
                ->count();

        return response()->json(array('WaitTest' => $WaitTest, 'Waiting' => $Waiting), 200);
    }

    public function getMedicalTestByAPi($id) {
        $msg = "đã nhận kết quả";
        $api = new ApiManagement();
        $om2m = $api->ApiMedicalTest();
        return response()->json(array('FVC' => $om2m['FVC'], 'FEV1' => $om2m['FEV1'], 'PEF' => $om2m['PEF']), 200);
    }

    public function getAPIConnect($roomID) {
        $api = new ApiManagement();

        $room = DB::table('user_room')->where('id', $roomID)->first();
        $roomName = $room->name;
        $department_id = $room->department;
        $department = DB::table('departments')->where('id', $department_id)->first()->name;
//        
//       
//        
//        $json = $api->ApiInfomation();
//        
//        $department = $api->stripVN($department);
//        $room = $api->stripVN($roomName);
//        $port = $json['sensor'][0]['portCoAP'];
//        $MACAddr = $json['sensor'][0]['MACAddr'];
//        $addr = $json['addr'];
//        
//        $om2m= $api->ApiConnect($department,$room,$addr,$MACAddr,$port);
//        $msg=$om2m['msg'];
//        $flag =$om2m['flag'];

        $msg = "đã kết nối ";
        $flag = 1;

        return response()->json(array('flag' => $flag, 'msg' => $msg), 200);
    }

    public function getAPIDisconnect($roomID) {
        $api = new ApiManagement();

        // $room = DB::table('user_room')->where('id', $roomID)->first();
        // $department_id = $room->department;
        // $department = DB::table('departments')->where('id', $department_id)->first()->name;

        // $json = $api->ApiInfomation();

        // $department = $api->stripVN($department);
        // $MACAddr = $json['sensor'][0]['MACAddr'];
        // $om2m = $api->ApiDisconnect($department, $MACAddr);

//        $msg = $om2m['msg'];
//        $flag =$om2m['flag'];

        $msg = "đã ngắt kết nối";
        $flag = 1;
        return response()->json(array('msg' => $msg, 'flag' => $flag), 200);
    }

    public function getAPIResult() {
        $msg = "đã nhận kết quả";
        $api = new ApiManagement();

        // $department_id = DB::table('staffs')
        //                 ->where('staff_id', Auth::user()->id)->first()->khoa;
        // $department = DB::table('departments')->where('id', $department_id)->first()->name;

        // $json = $api->ApiInfomation();

        // $department = $api->stripVN($department);
        // $port = $json['sensor'][0]['portCoAP'];
        // $addr = $json['addr'];

        // $om2m = $api->ApiResult($department, $port, $addr);
        // $FVC = $om2m['FVC'];
        // $FEV1 = $om2m['FEV1'];
        // $PEF = $om2m['PEF'];


        $FVC = 10;
        $FEV1 = 80;
        $PEF = 70;
        return response()->json(array('FVC' => $FVC, 'FEV1' => $FEV1, 'PEF' => $PEF), 200);
    }

    public function getAPIData() {
        $msg = "đã nhận kết quả";
        return response()->json(array('msg' => $msg), 200);
    }

    public function getAPIDevice($roomID) {
        $room = DB::table('user_room')->where('id', $roomID)->first();
        $roomName = $room->name;
        $department = $room->department;

//        $api = new ApiManagement();
//        
//        $room = $api->stripVN($room);
//        $department= $api->stripVN($department);
//        
//        $om2m =  $api->ApiGetDevice($department, $room);
//        $device = $om2m['device'];


        $device[] = 'máy 1';
        $device[] = 'máy 2';
        return response()->json(array('device' => $device), 200);
    }
    public function getMedicalFormMobile($id){
        $output = DB::table('medical_api_data')->where('medical_test_id',$id)
        ->first();
        if($output != NULL){
            $flag = 1;
            $paramStr= $output->param;
            $param = explode("&",$paramStr);
            foreach ($param as $param) {
                $param = explode("=",$param);
                $data[$param[0]] = (float)$param[1];
            }
        }else {
            $flag = 0;
            $data = 0;
        }
        return response()->json(array('data' => $data,'flag'=>$flag), 200);
     }
}
