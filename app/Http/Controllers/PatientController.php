<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Carbon\Carbon; //Dung de quan ly ngay thang
use App\Http\Requests\MedicalApplicationRequest;
use App\Model\MedicalApplication;
use App\Model\MedicalSpecialistApplication;
use App\Model\MedicalTestApplication;
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
use App\RBACController\MedicialManagement;
use App\RBACController\PatientManagement;
use App\RBACController\RoleManagement;
use App\Model\Role;
use App\Model\Share;
use App\RBACController\ShareManagement;

class PatientController extends Controller {

    private $patient_mng;

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('patient');
        $this->patient_mng = new PatientManagement();
    }

    public function index() {
        return view('patient.index');
    }

    public function info() {

        $patient_info = array(
            'fullname' => Auth::user()->name,
            'avatar' => '/upload/avatars/' . Auth::user()->avatar,
            'is_male' => (Auth::user()->gender == 'Nam' ? 'checked' : '' ),
            'is_female' => (Auth::user()->gender == 'Nữ' ? 'checked' : '' ),
            'birthday' => Carbon::parse(Auth::user()->birthday)->toDateString(),
            'id_number' => Auth::user()->id_number,
            'id_date' => Carbon::parse(Auth::user()->id_date)->toDateString(),
            'id_address' => Auth::user()->id_address,
            'permanent_residence' => Auth::user()->permanent_residence,
            'staying_address' => Auth::user()->staying_address,
            'job' => Auth::user()->job,
            'company' => Auth::user()->company,
            'family_history' => Auth::user()->family_history,
            'personal_history' => Auth::user()->personal_history,
        );
        return view('patient.info')->with($patient_info);
    }

    public function register() {
        $user_id = Auth::user()->id;

        $don_kham_suc_khoe = DB::table('medical_applications')->where
                        ([
                    ['patient_id', Auth::user()->id],
                    ['status', 1],
                ])
                ->first();
        if ($don_kham_suc_khoe === null) {
            return view('patient.register');
        } else {
            $don_kham = $don_kham_suc_khoe;
            $type = "Khám sức khỏe";
            $khoa = "Chăm sóc sức khỏe";
            $loaikham = "khám sức khỏe";
            if ($don_kham->Shift == 1)
                $Shift = "Buổi sáng";
            else
                $Shift = "Buổi chiều";
            $data = array(
                'don_kham_id' => $don_kham->id,
                'ngay_kham' => $don_kham->medical_date,
                'khoa' => $khoa,
                'loaikham' => $loaikham,
                'type' => $type,
                'Shift' => $Shift,
            );
            return view('patient.register-info')->with($data);
        }
    }

    public function registerS() {
        $user_id = Auth::user()->id;


        $don_kham_chuyen_khoa = DB::table('medical_specialist_applications')->where
                        ([
                    ['patient_id', Auth::user()->id],
                    ['status', '<>', 0],
                    ['medical_date', Carbon::now()->toDateString()]
                ])
                ->first();

        if ($don_kham_chuyen_khoa === null) {
            $data = array(
                'don_kham_id' => "",
                'ngay_kham' => "",
                'khoa' => "chuyên khoa",
                'loaikham' => "",
                'type' => "",
                'Shift' => "",
                'phong' => '',
            );
            return view('patient.registerS')->with($data);
        } else {
            $don_kham = $don_kham_chuyen_khoa;
            $khoa = DB::table('departments')->where('id', $don_kham->khoa)->first()->name;
            $phong = DB::table('user_room')->where('department', $don_kham->khoa)->first()->name;
            $so_phong = DB::table('user_room')->where('department', $don_kham->khoa)->first()->room_number;
            $phong = $phong . "(số phòng " . $so_phong . ")";

            $type = "Khám chuyên khoa";
            $loaikham = DB::table('medical_specialist_type')->where('id', $don_kham->medical_type)->first()->name;
            if ($don_kham->Shift == 1)
                $Shift = "Buổi sáng";
            else
                $Shift = "Buổi chiều";

            $data = array(
                'don_kham_id' => $don_kham->id,
                'ngay_kham' => $don_kham->medical_date,
                'khoa' => $khoa,
                'loaikham' => $loaikham,
                'type' => $type,
                'Shift' => $Shift,
                'phong' => $phong,
            );
            return view('patient.registerS')->with($data);
        }
    }

    public function history() {
        $role_be_shareds = Share::where('resource_owner', '=', Auth::user()->id)->get();
        $medical = DB::table('medical_applications')->where('patient_id', Auth::user()->id)->get();
        $name = array();
        foreach ($medical as $medical) {
            $name[] = "khám sức khỏe";
        }
        $roles = array();
        foreach ($role_be_shareds as $item) {
            $roles[] = $item->role_id;
        }
        $role_data = Role::wherenotIn('id', [RoleManagement::PATIENT_ROLE, RoleManagement::STAFF_ROLE])->orderBy('id')->get()->toArray();
        return view('patient.history', compact('name', 'role_data', 'roles'));
    }

    public function health_history() {
        $role_be_shareds = Share::where('resource_owner', '=', Auth::user()->id)->get();
        $medical = DB::table('medical_applications')->where('patient_id', Auth::user()->id)->get();
        $name = array();
        foreach ($medical as $medical) {
            $name[] = "khám sức khỏe";
        }
        $roles = array();
        foreach ($role_be_shareds as $item) {
            $roles[] = $item->role_id;
        }
        $role_data = Role::wherenotIn('id', [RoleManagement::PATIENT_ROLE, RoleManagement::STAFF_ROLE])->orderBy('id')->get()->toArray();
        return view('patient.history_health', compact('name', 'role_data', 'roles'));
    }

    public function specialist_history() {
        $role_be_shareds = Share::where('resource_owner', '=', Auth::user()->id)->get();
        $medical = DB::table('medical_applications')->where('patient_id', Auth::user()->id)->get();
        $name = array();
        foreach ($medical as $medical) {
            $name[] = "khám sức khỏe";
        }
        $roles = array();
        foreach ($role_be_shareds as $item) {
            $roles[] = $item->role_id;
        }
        $role_data = Role::wherenotIn('id', [RoleManagement::PATIENT_ROLE, RoleManagement::STAFF_ROLE])->orderBy('id')->get()->toArray();
        return view('patient.history_specialist', compact('name', 'role_data', 'roles'));
    }

    public function test_history() {
        $role_be_shareds = Share::where('resource_owner', '=', Auth::user()->id)->get();
        $medical = DB::table('medical_applications')->where('patient_id', Auth::user()->id)->get();
        $name = array();
        foreach ($medical as $medical) {
            $name[] = "khám sức khỏe";
        }
        $roles = array();
        foreach ($role_be_shareds as $item) {
            $roles[] = $item->role_id;
        }
        $role_data = Role::wherenotIn('id', [RoleManagement::PATIENT_ROLE, RoleManagement::STAFF_ROLE])->orderBy('id')->get()->toArray();
        return view('patient.history_test', compact('name', 'role_data', 'roles'));
    }

    public function history_as_json() {
        $medical_list = MedicalApplication::where('patient_id', Auth::user()->id)->get();
        return $medical_list;
    }

    public function history_specialist_as_json() {
        $medical_list = MedicalSpecialistApplication::join('departments', 'medical_specialist_applications.khoa', '=', 'departments.id')
                        ->select('medical_specialist_applications.id', 'medical_specialist_applications.date', 'medical_specialist_applications.medical_date', 'departments.name', 'medical_specialist_applications.status')
                        ->where('medical_specialist_applications.patient_id', Auth::user()->id)->get();
        return $medical_list;
    }

    public function history_test_as_json() {
        $medical_list = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                ->select('medical_test_applications.id', 'medical_test_applications.date', 'medical_test_applications.medical_date', 'medical_test_type.name', 'medical_test_applications.status')
                ->where('medical_test_applications.patient_id', Auth::user()->id)
                ->get();
        return $medical_list;
    }

    public function wait_history_as_json() {
        $medical_list = MedicalApplication::where('patient_id', Auth::user()->id)
                        ->where('medical_applications.status', '<>', 0)->get();
        return $medical_list;
    }

    public function wait_history_specialist_as_json() {
        $medical_list = MedicalSpecialistApplication::join('departments', 'medical_specialist_applications.khoa', '=', 'departments.id')
                        ->select('medical_specialist_applications.id', 'medical_specialist_applications.date', 'medical_specialist_applications.medical_date', 'departments.name', 'medical_specialist_applications.status')
                        ->where('medical_specialist_applications.patient_id', Auth::user()->id)
                        ->where('medical_specialist_applications.status', '<>', 0)->get();
        ;
        return $medical_list;
    }

    public function wait_history_test_as_json() {
        $medical_list = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->select('medical_test_applications.id', 'medical_test_applications.date', 'medical_test_applications.medical_date', 'medical_test_type.name', 'medical_test_applications.status')
                        ->where('medical_test_applications.patient_id', Auth::user()->id)
                        ->where('medical_test_applications.status', '<>', 0)->get();
        return $medical_list;
    }

    public function medical_app_detail_as_json($id) {
        $medical = MedicalApplication::where('id', $id)->first();

        try {
            $contents = Storage::get($medical->url);
        } catch (\Exception $e) {
            return "Không tìm thấy file đơn khám";
        }



        $medical_application_xml = simplexml_load_string($contents);


// Chứng thực người dùng có quyền truy cập đơn khám hay không.
        if (Auth::user()->id == $medical->patient_id) {

            $data = ((array) $medical_application_xml);
            return view('json.medical')->with($data);
        } else {
            return "Bạn không có quyền truy cập vào trang này.";
        }
    }

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

// Chứng thực người dùng có quyền truy cập đơn khám hay không.
//        if (Auth::user()->id == $medical->user_id) {
//
//       
//        } else {
//            return "Bạn không có quyền truy cập vào trang này.";
//        }
    }

    public function getMedicalSpecialistInfo($i) {
        $medical = MedicalSpecialistApplication::where('id', $i)->first();
        $xetnghiem = MedicalTestApplication::where('patient_id', $medical->patient_id)->where('medical_date', $medical->medical_date)->where('status', MedicialManagement::COMPLETE_STATUS)->where('register_by', 2)->get();
        $so_bo = $medical->so_bo;

        if ($medical->chan_doan)
            $chan_doan = $medical->chan_doan;
        else
            $chan_doan = "";
        $xet_nghiem = "";
        $i = 1;
        foreach ($xetnghiem as $xetnghiem) {
            if ($i == 1)
                $button = "btn-primary";
            if ($i == 2)
                $button = "btn-warning";
            if ($i == 3) {
                $button = "btn-success";
                $i = 1;
            }
            $type = DB::table('medical_test_type')->where('id', $xetnghiem->xetnghiem)->first();
            $xet_nghiem = $xet_nghiem . '<a  class="btn ' . $button . ' showButton" onclick="getTestmedical(' . $xetnghiem->id . ')" data-toggle="modal" data-target="#modalTable">' . $type->name . '</a>';
            $i++;
        }
        return response()->json(array('so_bo' => $so_bo, 'xet_nghiem' => $xet_nghiem, 'chan_doan' => $chan_doan), 200);
    }

    public function medical_specialist_detail_as_json($id) {
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

    public function about() {
        return view('patient.about');
    }

    public function capNhatInfo(Request $request) {
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
        if ($request->hasFile('avatar')) {

            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->fit(400, 600)->save(public_path('/upload/avatars/' . $filename));
            $patient_data['avatar'] = $filename;
            $this->patient_mng->updatePatient($patient_id, $patient_data);
        }
        return redirect()->route('patient-info');
    }

    public function sendRegister(MedicalApplicationRequest $request) {
        $medical_application = new MedicalApplication();
        $medical_application->patient_id = Auth::user()->id;
        $medical_application->medical_date = $request->medical_date;
        $medical_application->status = 1;
        $medical_application->Shift = $request->Shift;
        $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';
        $medical_application->url = $url;
        $medical_application->date = date("Y-m-d H:i:s");
        $medical_application->save();
        Storage::copy('donkham.xml', $url);
        return redirect()->route('patient-register');
    }

    public function sendRegisterS(MedicalApplicationRequest $request) {

        $medical_application = new MedicalSpecialistApplication();
        $medical_application->patient_id = Auth::user()->id;
        $medical_application->status = 1;
        $medical_application->Shift = $request->Shift;
        $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';
        $medical_application->medical_date = $request->medical_date;
        $medical_application->khoa = $request->khoa;
        $medical_application->medical_type = $request->medical_type;
        $medical_application->url = $url;
        $medical_application->date = date("Y-m-d H:i:s");

        $medical_application->save();
        Storage::copy('donkham.xml', $url);

        return redirect()->route('patient-registerS');
    }

    public function cancelRegister() {
        $id = Input::get('don_kham_id');
        $medical = MedicalApplication::where('id', $id)->delete();
        return redirect()->route('patient-register');
    }

    public function cancelRegisterS() {
        $id = Input::get('don_kham_id');
        $medical = MedicalSpecialistApplication::where('id', $id)->delete();
        return redirect()->route('patient-registerS');
    }

    public function removeMedical() {
        $id = Input::get('medical_id');
        $medical = MedicalApplication::where('id', $id)->delete();
        $medical = MedicalTestApplication::where('id', $id)->delete();
        $medical = MedicalSpecialistApplication::where('id', $id)->delete();
        return redirect()->route('patient-history');
    }

    public function postShare(Request $request) {
        $roles = $request->role;
        $resource_owner = Auth::user()->id;
        $medical = MedicalApplication::where('patient_id', '=', $resource_owner)->first();
// dd($medicals->id);

        $share_mng = new ShareManagement();
        if ($medical) {
            $roles = $request->role;
            $resource_id = $medical->id;
            $resource_owner = Auth::user()->id;
            $share_mng->addShare($resource_owner, $roles, $resource_id);
            return redirect()->route('patient-history', ['id' => $resource_id])->with(['flash_level' => 'success', 'flash_message_success' => 'thành công !! Bạn đã thực hiện chia sẻ bệnh án thành công']);
        } else {
            return redirect()->route('patient-history')->with(['flash_level' => 'success', 'flash_message' => 'Cảnh báo!! Bạn chưa đăng ký khám lần nào']);
            ;
        }
    }

    public function sendTestRegister(MedicalApplicationRequest $request) {

        $medical = $_POST['Medical'];
        foreach ($medical as $medical) {
            $medical_application = new MedicalTestApplication();
            $medical_application->patient_id = Auth::user()->id;
            $medical_application->status = 1;
            $medical_application->Shift = $request->Shift;
            $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';

            $medical_application->xetnghiem = $medical;

            $medical_application->url = $url;

            $medical_application->medical_date = $request->medical_date;
            $medical_application->date = date("Y-m-d H:i:s");
            $medical_application->save();
            if ($medical != 4)
                Storage::copy('XN_chieucao.xml', $url);
            else
                Storage::copy('COPD.xml', $url);
        }

        return redirect()->route('patient-testRegister');
    }

    public function TestRegister() {
        $user_id = Auth::user()->id;

        $don_xet_nghiem = DB::table('medical_test_applications')->where
                        ([
                    ['patient_id', Auth::user()->id],
                    ['status', 1]
                ])
                ->get();

        if (strlen($don_xet_nghiem) < 3) {
            return view('patient.testRegister');
        } else {
            if ($don_xet_nghiem[0]->Shift == 1)
                $Shift = "Buổi sáng";
            else
                $Shift = "Buổi chiều";
            $data = array(
                'xet_nghiem' => $don_xet_nghiem[0]->id,
                'ngay_xet_nghiem' => $don_xet_nghiem[0]->medical_date,
                'Shift' => $Shift,
            );
            return view('patient.testRegister-info', ['don_xet_nghiem' => $don_xet_nghiem], $data);
        }
    }

    public function cancelTestRegister() {
        $id = Input::get('user_id');
        $medical = MedicalTestApplication::where('patient_id', $id)->where('status', '<>', 0)->delete();
        return redirect()->route('patient-testRegister');
    }

    public function getPosition() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;

        $que1 = DB::table('medical_applications')->where('medical_date', \Carbon\Carbon::now()->toDateString())->where('Shift', $Shift)->where('status', 1)->first();
        $que2 = DB::table('medical_applications')->where('medical_date', \Carbon\Carbon::now()->toDateString())->where('patient_id', Auth::user()->id)->where('Shift', $Shift)->where('status', 1)->first();
        $khamsuckhoe = "";
        // $khamsuckhoe="";
        if ($que2) {
            $idNow = $que1->id;
            $idUser = $que2->id;
            $count = DB::table('medical_applications')->where('medical_date', Carbon::now()->toDateString())->where('Shift', $Shift)->where('status', 1)->whereBetween('id', [$idNow, $idUser])->count();
            $count = $count - 1;

            if ($count == 0) {
                $khamsuckhoe = $khamsuckhoe . '<p><a href="register">đã đến lượt khám của bạn</a></p>';
            } else {
                $khamsuckhoe = $khamsuckhoe . '<p>Bạn còn phải đợi: ' . $count . ' người nữa</p>';
            }
        }

        $que1 = DB::table('medical_specialist_applications')->where('medical_date', Carbon::now()->toDateString())->where('Shift', $Shift)->where('status', 1)->first();
        $que2 = DB::table('medical_specialist_applications')->where('medical_date', Carbon::now()->toDateString())->where('patient_id', Auth::user()->id)->where('status', 1)->where('Shift', $Shift)->first();
        $khamchuyenkhoa = "";
        if ($que2) {
            $idNow = $que1->id;
            $idUser = $que2->id;
            $count = DB::table('medical_specialist_applications')->where('medical_date', Carbon::now()->toDateString())->where('Shift', $Shift)->where('status', 1)->whereBetween('id', [$idNow, $idUser])->count();
            $count = $count - 1;

            if ($count == 0) {
                $khamchuyenkhoa = $khamchuyenkhoa . '<p><a href="registerS">đã đến lượt khám của bạn</a></p>';
            } else {
                $khamchuyenkhoa = $khamchuyenkhoa . ' <p>Bạn còn phải đợi: ' . $count . ' người nữa</p>';
            }
        }
        $que = DB::table('medical_specialist_applications')->where('medical_date', Carbon::now()->toDateString())->where('patient_id', Auth::user()->id)->where('status', '<>', 0)->where('Shift', $Shift)->first();
        if ($que)
            $khamchuyenkhoa = "<a href='/patient/registerS'>Đang khám,xem hướng dẫn</a>";
        $queryType = DB::table('medical_test_type')->get();
        $queryCheck = DB::table('medical_test_applications')->where('patient_id', Auth::user()->id)->where('Shift', $Shift)->where('status', 1)->first();
        $xetnghiem = "";
        if ($queryCheck) {
            foreach ($queryType as $type) {
                $que1 = DB::table('medical_test_applications')->where('xetnghiem', $type->id)->where('medical_date', \Carbon\Carbon::now()->toDateString())->where('Shift', $Shift)->where('status', 1)->first();
                $que2 = DB::table('medical_test_applications')->where('xetnghiem', $type->id)->where('medical_date', \Carbon\Carbon::now()->toDateString())->where('patient_id', Auth::user()->id)->where('Shift', $Shift)->where('status', 1)->first();
                if ($que2) {
                    $idNow = $que1->id;
                    $idUser = $que2->id;
                    $count = DB::table('medical_test_applications')->where('xetnghiem', $type->id)->where('medical_date', Carbon::now()->toDateString())->where('Shift', $Shift)->where('status', 1)->whereBetween('id', [$idNow, $idUser])->count();
                    $count = $count - 1;

                    $xetnghiem = $xetnghiem . '<tr>
                    <td>' . $type->name . '</td>
                    <td >';
                    $room = DB::table('user_room')->where('id', $type->phongban)->first();
                    if ($count !== 0)
                        $xetnghiem = $xetnghiem . $count . ' người';
                    else
                        $xetnghiem = $xetnghiem . 'Đã đến lượt,đến phòng ' . $room->name . "(phòng " . $room->room_number . ')';

                    $xetnghiem = $xetnghiem . '</td></tr>';
                }
            }
        }
        return response()->json(array('khamsuckhoe' => $khamsuckhoe, 'khamchuyenkhoa' => $khamchuyenkhoa, 'xetnghiem' => $xetnghiem), 200);
    }

}
