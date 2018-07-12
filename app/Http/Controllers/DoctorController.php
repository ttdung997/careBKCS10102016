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
use App\Model\Patient;
use App\User;
use App\Model\Role;
use App\Model\Share;
use App\Model\User_Permission;
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
use App\RBACController\UserManagement;
use App\RBACController\ShareManagement;
use App\RBACController\RoleManagement;
use App\Model\Permission;
use View;
use Cookie;
use App\RBACController\ApiManagement;

class DoctorController extends Controller {

    const healthDoctor = 1;
    const specialistDoctor = 2;
    const testDoctor = 3;

    private $oauth;
    private $medicial_mng;
    private $role_mng;

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('web');
        $this->middleware('doctor');
        $this->middleware('oauth2_refresh');
        $this->medicial_mng = new MedicialManagement();
    }

    public function index() {
        return view('doctor.index');
    }

    public function info() {

        $doctor_info = array(
            'fullname' => Auth::user()->name,
            'avatar' => '/upload/avatars/' . Auth::user()->avatar,
            'is_male' => (Auth::user()->gender == 'Nam' ? 'checked' : '' ),
            'is_female' => (Auth::user()->gender == 'Nữ' ? 'checked' : '' ),
            'birthday' => Carbon::parse(Auth::user()->birthday)->toDateString(),
            'id_number' => Auth::user()->id_number,
            'id_date' => Carbon::parse(Auth::user()->id_date)->toDateString(),
            'id_address' => Auth::user()->id_address,
            'permanent_residence' => Auth::user()->permanent_residence,
            'khoa' => (Auth::user()->khoa),
        );
        return view('doctor.info')->with($doctor_info);
    }

    //danh sách bệnh nhân
    public function listPatient() {
        $client_id = Session::get('client_id');
        $op_sess_endpoint = Session::get('ss_endpoint');

        return view('doctor.list', ['client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint]);
    }
   

    //danh sách bệnh nhân
    public function listSick() {
        $client_id = Session::get('client_id');
        $op_sess_endpoint = Session::get('ss_endpoint');

        return view('doctor.listSick', ['client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint]);
    }

    //danh sách đợi khám
    public function WaitForTestListPatient() {
        $client_id = Session::get('client_id');
        $op_sess_endpoint = Session::get('ss_endpoint');

        return view('doctor.listWaitForTest', ['client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint]);
    }

    //danh sách chẩn đoán
    public function DiagnodeListPatient() {
        $client_id = Session::get('client_id');
        $op_sess_endpoint = Session::get('ss_endpoint');

        return view('doctor.listDiagnose', ['client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint]);
    }

    //danh sách kết quả
    public function CompeleteListPatient() {
        $client_id = Session::get('client_id');
        $op_sess_endpoint = Session::get('ss_endpoint');

        return view('doctor.listCompelete', ['client_id' => $client_id, 'ss_endpoint' => $op_sess_endpoint]);
    }

    /**
     * Lấy ra danh sách bệnh nhân đang chờ khám
     */
    public function HealthListAsJson(){
        $oauth = new OAuthorization();
        
        if($oauth->getLocal()){
            $medicial_list = $this->medicial_mng->getListMedicialExam(MedicialManagement::AWAIT_STATUS);
            return $medicial_list; 
        }
        $resources = $oauth->getResource();

        return $this->medicial_mng->getListMedicialExamShare(MedicialManagement::AWAIT_STATUS,$resources);
    }

    public function listAsJson() {
        $oauth = new OAuthorization();
        $doctor = DB::table('doctors')->where('doctor_id', Auth::user()->id)->first();
        $chucvu = $doctor->chucvu;
        $khoa = $doctor->khoa;
        $bangcap = $doctor->bangcap;
        $status = 1;
        if ($oauth->getLocal()) {
            $medicial_list = $this->medicial_mng->getListSpecialistMedicialForDoctor($khoa, $chucvu, $status);

            return $medicial_list;
        }
        $resources = $oauth->getResource();

        return $this->medicial_mng->getListMedicialExamShare(MedicialManagement::AWAIT_STATUS, $resources);
    }

    public function WaitForTestListAsJson() {
        $oauth = new OAuthorization();
        $doctor = DB::table('doctors')->where('doctor_id', Auth::user()->id)->first();
        $chucvu = $doctor->chucvu;
        $khoa = $doctor->khoa;
        $bangcap = $doctor->bangcap;
        $status = 2;
        if ($oauth->getLocal()) {
            $medicial_list = $this->medicial_mng->getListSpecialistMedicialForDoctor($khoa, $chucvu, $status);

            return $medicial_list;
        }
        $resources = $oauth->getResource();

        return $this->medicial_mng->getListMedicialExamShare(MedicialManagement::AWAIT_STATUS, $resources);
    }

    public function DiagnodelistAsJson() {
        $oauth = new OAuthorization();
        $doctor = DB::table('doctors')->where('doctor_id', Auth::user()->id)->first();
        $chucvu = $doctor->chucvu;
        $khoa = $doctor->khoa;
        $bangcap = $doctor->bangcap;
        $status = 3;
        if ($oauth->getLocal()) {
            $medicial_list = $this->medicial_mng->getListSpecialistMedicialForDoctor($khoa, $chucvu, $status);

            return $medicial_list;
        }
        $resources = $oauth->getResource();

        return $this->medicial_mng->getListMedicialExamShare(MedicialManagement::AWAIT_STATUS, $resources);
    }

    public function CompeletelistAsJson() {
        $oauth = new OAuthorization();
        $doctor = DB::table('doctors')->where('doctor_id', Auth::user()->id)->first();
        $chucvu = $doctor->chucvu;
        $khoa = $doctor->khoa;
        $bangcap = $doctor->bangcap;
        $status = 0;
        if ($oauth->getLocal()) {
            $medicial_list = $this->medicial_mng->getListSpecialistMedicialForDoctor($khoa, $chucvu, $status);

            return $medicial_list;
        }
        $resources = $oauth->getResource();

        return $this->medicial_mng->getListMedicialExamShare(MedicialManagement::AWAIT_STATUS, $resources);
    }
    
    public function MedicalList() {
        return view('doctor.medical_list');
    }

    public function MedicalListAsJson() {
        $oauth = new OAuthorization();

        if ($oauth->getLocal()) {
            $medicial_list = $this->medicial_mng->getListMedicialExam(MedicialManagement::AWAIT_STATUS);
            return $medicial_list;
        }
        $resources = $oauth->getResource();

        return $this->medicial_mng->getListMedicialExamShare(MedicialManagement::AWAIT_STATUS, $resources);
    }
    public function MedicalListComplete() {
        return view('doctor.medical_list_complete');
    }

    public function MedicalListCompleteAsJson() {
        $oauth = new OAuthorization();

        if ($oauth->getLocal()) {
            $medicial_list = $this->medicial_mng->getListMedicialExam(MedicialManagement::COMPLETE_STATUS);
            return $medicial_list;
        }
        $resources = $oauth->getResource();

        return $this->medicial_mng->getListMedicialExamShare(MedicialManagement::COMPLETE_STATUS, $resources);
    }
    public function medical_exam($medical_id) {

        $oauth = new OAuthorization();
        if ($oauth->checkResource($medical_id)) {
            // Từ id đơn khám, đọc từ database kiểm tra xem có đơn khám nào trùng id với id ban đầu không?
            $medical = MedicalApplication::where('id', $medical_id)->first();
            /*
              Thử lấy url từ đơn khám, sau đó đọc nội dung file từ đơn khám, xuất ra dạng string đưa vào $contents
              Sau đó load contents thành một đối tượng XML để dễ dàng xử lý.
             */

            try {
                $contents = Storage::get($medical->url);
            } catch (\Exception $e) {
                return "Không tìm thấy file đơn khám";
            }

            if ($oauth->getLocal() == true) {
                $hidden = false;
            } else {
                $hidden = true;
            }

            $user = Patient::where('patient_id', $medical->patient_id)->first();
            $birthday = substr($user->birthday, 0, 10);

            $medical_application_xml = simplexml_load_string($contents);
            $ktl = $medical_application_xml->kham_the_luc;
            $kls = $medical_application_xml->kham_lam_sang;
            $kcls = $medical_application_xml->kham_can_lam_sang;
            $kl = $medical_application_xml->ket_luan;

            /*
             * Kiểm tra quyền, nếu hợp lệ bỏ Disable
             *
             */
            if ($oauth->checkPermission(Permission::TL_PERMISSION)) {
                $kham_the_luc_disabled = false;
            } else {
                $kham_the_luc_disabled = true;
            }
            if ($oauth->checkPermission(Permission::NK_PERMISSION)) {
                $noi_khoa_disabled = false;
            } else {
                $noi_khoa_disabled = true;
            }
            if ($oauth->checkPermission(Permission::MAT_PERMISSION)) {
                $mat_disabled = false;
            } else {
                $mat_disabled = true;
            }
            if ($oauth->checkPermission(Permission::TMH_PERMISSION)) {
                $tai_mui_hong_disabled = false;
            } else {
                $tai_mui_hong_disabled = true;
            }
            if ($oauth->checkPermission(Permission::RHM_PERMISSION)) {
                $rang_ham_mat_disabled = false;
            } else {
                $rang_ham_mat_disabled = true;
            }
            if ($oauth->checkPermission(Permission::DL_PERMISSION)) {
                $da_lieu_disabled = false;
            } else {
                $da_lieu_disabled = true;
            }
            if ($oauth->checkPermission(Permission::CLS_PERMISSION)) {
                $can_lam_sang_disabled = false;
            } else {
                $can_lam_sang_disabled = true;
            }
            if ($oauth->checkPermission(Permission::TQ_PERMISSION)) {
                $tong_quan_disabled = false;
            } else {
                $tong_quan_disabled = true;
            }

            // Lay ra danh sach role da duoc chia se tai nguyen
            $role_be_shareds = Share::where('resource_owner', '=', Auth::user()->id)->get();
            $roles = array();
            foreach ($role_be_shareds as $item) {
                $roles[] = $item->role_id;
            }

            $medical_data = array(
                'ten_benh_nhan' => $user->fullname,
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
                'tuan_hoan' => $kls->noi_khoa->tuan_hoan,
                'phan_loai_tuan_hoan' => $kls->noi_khoa->phan_loai_tuan_hoan,
                'ho_hap' => $kls->noi_khoa->ho_hap,
                'phan_loai_ho_hap' => $kls->noi_khoa->phan_loai_ho_hap,
                'tieu_hoa' => $kls->noi_khoa->tieu_hoa,
                'phan_loai_tieu_hoa' => $kls->noi_khoa->phan_loai_tieu_hoa,
                'than_tiet_nieu' => $kls->noi_khoa->than_tiet_nieu,
                'phan_loai_than_tiet_nieu' => $kls->noi_khoa->phan_loai_than_tiet_nieu,
                'noi_tiet' => $kls->noi_khoa->noi_tiet,
                'phan_loai_noi_tiet' => $kls->noi_khoa->phan_loai_noi_tiet,
                'co_xuong_khop' => $kls->noi_khoa->co_xuong_khop,
                'phan_loai_co_xuong_khop' => $kls->noi_khoa->phan_loai_co_xuong_khop,
                'than_kinh' => $kls->noi_khoa->than_kinh,
                'phan_loai_than_kinh' => $kls->noi_khoa->phan_loai_than_kinh,
                'tam_than' => $kls->noi_khoa->tam_than,
                'phan_loai_tam_than' => $kls->noi_khoa->phan_loai_co_tam_than,
                'mat_trai' => $kls->mat->thi_luc->mat_trai,
                'mat_phai' => $kls->mat->thi_luc->mat_phai,
                'benh_ve_mat' => $kls->mat->benh_neu_co,
                'phan_loai_mat' => $kls->mat->phan_loai,
                'tai_trai' => $kls->tai_mui_hong->thinh_luc->tai_trai,
                'tai_phai' => $kls->tai_mui_hong->thinh_luc->tai_phai,
                'benh_ve_tai_mui_hong' => $kls->tai_mui_hong->benh_neu_co,
                'phan_loai_tai_mui_hong' => $kls->tai_mui_hong->phan_loai,
                'ham_tren' => $kls->rang_ham_mat->ham_tren,
                'ham_duoi' => $kls->rang_ham_mat->ham_duoi,
                'phan_loai_rang_ham_mat' => $kls->rang_ham_mat->phan_loai,
                'phan_loai_da_lieu' => $kls->da_lieu->phan_loai,
                'ket_qua' => $kcls->ket_qua,
                'danh_gia' => $kcls->danh_gia,
                'phan_loai' => $kl->phan_loai,
                'benh_neu_co' => $kl->benh_neu_co,
                'bs_kl' => $kl->bs_kl,
            );

            $role_data = Role::wherenotIn('id', [RoleManagement::PATIENT_ROLE, RoleManagement::STAFF_ROLE])->orderBy('id')->get()->toArray();
            return view('doctor.medical_exam', compact('role_data', 'medical_id', 'roles', 'hidden'))->with($medical_data);
        } else {
            echo "bạn không có quyền hạn với tài nguyên này";
        }
    }

    public function updateMedicalInfo(Request $request) {
        $oauth = new OAuthorization();
        $medical_id = $request->input('medicalID');

        if ($oauth->checkResource($medical_id)) {
            $medical = MedicalApplication::where('id', $medical_id)->first();
            $contents = Storage::get($medical->url);
            $medical_application_xml = simplexml_load_string($contents);

            if ($oauth->checkPermission(Permission::TL_PERMISSION)) {
                $chieu_cao = $request->input('chieu_cao');
                $medical_application_xml->kham_the_luc->chieu_cao = $chieu_cao;
                $can_nang = $request->input('can_nang');
                $medical_application_xml->kham_the_luc->can_nang = $can_nang;
                $huyet_ap = $request->input('huyet_ap');
                $medical_application_xml->kham_the_luc->huyet_ap = $huyet_ap;
            }

            if ($oauth->checkPermission(Permission::NK_PERMISSION)) {
                $tuan_hoan = $request->input('tuan_hoan');
                $medical_application_xml->kham_lam_sang->noi_khoa->tuan_hoan = $tuan_hoan;
                $phan_loai_tuan_hoan = $request->input('phan_loai_tuan_hoan');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_tuan_hoan = $phan_loai_tuan_hoan;

                $tieu_hoa = $request->input('tieu_hoa');
                $medical_application_xml->kham_lam_sang->noi_khoa->tieu_hoa = $tieu_hoa;
                $phan_loai_tieu_hoa = $request->input('phan_loai_tieu_hoa');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_tieu_hoa = $phan_loai_tieu_hoa;

                $ho_hap = $request->input('ho_hap');
                $medical_application_xml->kham_lam_sang->noi_khoa->ho_hap = $ho_hap;
                $phan_loai_ho_hap = $request->input('phan_loai_ho_hap');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_ho_hap = $phan_loai_ho_hap;

                $noi_tiet = $request->input('noi_tiet');
                $medical_application_xml->kham_lam_sang->noi_khoa->noi_tiet = $noi_tiet;
                $phan_loai_noi_tiet = $request->input('phan_loai_noi_tiet');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_noi_tiet = $phan_loai_noi_tiet;

                $than_tiet_nieu = $request->input('than_tiet_nieu');
                $medical_application_xml->kham_lam_sang->noi_khoa->than_tiet_nieu = $than_tiet_nieu;
                $phan_loai_than_tiet_nieu = $request->input('phan_loai_tuan_hoan');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_than_tiet_nieu = $phan_loai_than_tiet_nieu;

                $co_xuong_khop = $request->input('co_xuong_khop');
                $medical_application_xml->kham_lam_sang->noi_khoa->co_xuong_khop = $co_xuong_khop;
                $phan_loai_co_xuong_khop = $request->input('phan_loai_co_xuong_khop');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_co_xuong_khop = $phan_loai_co_xuong_khop;

                $than_kinh = $request->input('than_kinh');
                $medical_application_xml->kham_lam_sang->noi_khoa->than_kinh = $than_kinh;
                $phan_loai_than_kinh = $request->input('phan_loai_than_kinh');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_than_kinh = $phan_loai_than_kinh;

                $tam_than = $request->input('tam_than');
                $medical_application_xml->kham_lam_sang->noi_khoa->tam_than = $tam_than;
                $phan_loai_tam_than = $request->input('phan_loai_tam_than');
                $medical_application_xml->kham_lam_sang->noi_khoa->phan_loai_tam_than = $phan_loai_tam_than;
            }

            if ($oauth->checkPermission(Permission::MAT_PERMISSION)) {
                $mat_trai = $request->input('mat_trai');
                $medical_application_xml->kham_lam_sang->mat->thi_luc->mat_trai = $mat_trai;
                $mat_phai = $request->input('mat_phai');
                $medical_application_xml->kham_lam_sang->mat->thi_luc->mat_phai = $mat_phai;
                $benh_ve_mat = $request->input('benh_ve_mat');
                $medical_application_xml->kham_lam_sang->mat->benh_neu_co = $benh_ve_mat;
                $phan_loai_mat = $request->input('phan_loai_mat');
                $medical_application_xml->kham_lam_sang->mat->phan_loai = $phan_loai_mat;
            }

            if ($oauth->checkPermission(Permission::TMH_PERMISSION)) {
                $tai_trai = $request->input('tai_trai');
                $medical_application_xml->kham_lam_sang->tai_mui_hong->thinh_luc->tai_trai = $tai_trai;
                $tai_phai = $request->input('tai_phai');
                $medical_application_xml->kham_lam_sang->tai_mui_hong->thinh_luc->tai_phai = $tai_phai;
                $benh_ve_tai_mui_hong = $request->input('benh_ve_tai_mui_hong');
                $medical_application_xml->kham_lam_sang->tai_mui_hong->benh_neu_co = $benh_ve_mat;
                $phan_loai_tai_mui_hong = $request->input('phan_loai_tai_mui_hong');
                $medical_application_xml->kham_lam_sang->tai_mui_hong->phan_loai = $phan_loai_tai_mui_hong;
            }

            if ($oauth->checkPermission(Permission::RHM_PERMISSION)) {
                $ham_tren = $request->input('ham_tren');
                $medical_application_xml->kham_lam_sang->rang_ham_mat->ham_tren = $ham_tren;
                $ham_duoi = $request->input('ham_duoi');
                $medical_application_xml->kham_lam_sang->rang_ham_mat->ham_duoi = $ham_duoi;
                $phan_loai_rang_ham_mat = $request->input('phan_loai_rang_ham_mat');
                $medical_application_xml->kham_lam_sang->rang_ham_mat->phan_loai = $phan_loai_rang_ham_mat;
            }

            if ($oauth->checkPermission(Permission::DL_PERMISSION)) {
                $phan_loai_da_lieu = $request->input('phan_loai_da_lieu');
                $medical_application_xml->kham_lam_sang->da_lieu->phan_loai = $phan_loai_da_lieu;
            }

            if ($oauth->checkPermission(Permission::CLS_PERMISSION)) {
                $ket_qua = $request->input('ket_qua');
                $medical_application_xml->kham_can_lam_sang->ket_qua = $ket_qua;
                $danh_gia = $request->input('danh_gia');
                $medical_application_xml->kham_can_lam_sang->danh_gia = $danh_gia;
            }

            if ($oauth->checkPermission(Permission::TQ_PERMISSION)) {
                $phan_loai = $request->input('phan_loai');
                $medical_application_xml->ket_luan->phan_loai = $phan_loai;
                $benh_neu_co = $request->input('benh_neu_co');
                $medical_application_xml->ket_luan->benh_neu_co = $benh_neu_co;
                if ($benh_neu_co) {
                    $medical->status = 0;
                    $medical->save();
                }
            }

            $resource = $medical_application_xml->asXML();
            Storage::put($medical->url, $resource);
            return redirect()->route('medical_exam_by_id', ['id' => $medical_id]);
        } else {
            echo "Bạn không có quyền hạn với tài nguyên này";
        }
    }

    //them danh sách bênh nhan trong search
    public function searchAsJson() {

        $patientinfo = User::where('position', UserManagement::PATIENT_POSITION)->get();
        return $patientinfo;
    }

    public function history_patient($id) {

        return view('doctor.his_patient', ['id' => $id]);
    }

    public function search() {
        return view('doctor.search');
    }

    public function about() {
        return view('doctor.about');
    }

    public function updateInfo(Request $request) {
        $userID = Auth::user()->id;

        DB::table('users')
                ->where('id', $userID)
                ->update([
                    'name' => Input::get('fullname'),
                    'gender' => Input::get('gender'),
                    'birthday' => Input::get('birthday'),
                    'id_number' => Input::get('id_number'),
                    'id_date' => Input::get('id_date'),
                    'id_address' => Input::get('id_address'),
                    'permanent_residence' => Input::get('permanent_residence'),
                    'khoa' => Input::get('khoa'),
        ]);

        if ($request->hasFile('avatar')) {
            //return "Has file";
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->fit(300, 300)->save(public_path('/upload/avatars/' . $filename));
            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }
        return redirect()->route('doctor-info');
    }

    /**
     * Chia sẻ tài nguyên là hồ sơ bệnh nhân với các role
     */
    public function postShare(Request $request) {
        $oauth = new OAuthorization();
        $share_mng = new ShareManagement();
        if ($oauth->getLocal() == true) {
            $roles = $request->role;
            $resource_id = $request->resource_id;
            $resource_owner = Auth::user()->id;

            $share_mng->addShare($resource_owner, $roles, $resource_id);
            return redirect()->route('medical_exam_by_id', ['id' => $resource_id])->with(['flash_level' => 'success', 'flash_message_success' => 'thành công !! Bạn đã thực hiện chia sẻ tài nguyên thành công']);
        } else {
            return redirect()->route('medical_exam_by_id', ['id' => $resource_id])->with(['flash_level' => 'success', 'flash_message' => 'Cảnh báo!! Bạn không có quyền thực hiện tác vụ này']);
        }
    }

    //lưu kết quả ban đầu và gửi các xét nghiệm
    public function ExaminationBegin(MedicalApplicationRequest $request) {
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;
        $medical = $_POST['Medical'];
        //echo count($medical);
        MedicalSpecialistApplication::where('id', $request->id)->update(['so_bo' => $request->so_bo]);


        $id = MedicalSpecialistApplication::where('id', $request->id)->first()->patient_id;
        if (count($medical) > 1) {
            //  echo "dăng kí xét nghiệm";
            MedicalSpecialistApplication::where('id', $request->id)->update([ 'status' => 2]);
            foreach ($medical as $medical) {
                if ($medical == 0)
                    continue;
                $medical_application = new MedicalTestApplication();
                $medical_application->patient_id = $id;
                $medical_application->status = 1;
                $medical_application->Shift = $Shift;
                $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';

                $medical_application->xetnghiem = $medical;

                $medical_application->url = $url;
                $medical_application->register_by = 2;

                $medical_application->medical_date = $request->medical_date;
                $medical_application->date = date("Y-m-d H:i:s");
                $medical_application->save();
                Storage::copy('XN_chieucao.xml', $url);
            }
        } else {
            //  echo "khong xét nghiệm";
            MedicalSpecialistApplication::where('id', $request->id)->update(['status' => 3]);
        }

        return redirect()->route('doctor-list');
    }

    //lưu kết quả chuẩn đoán bệnh 
    public function ExaminationEnd(MedicalApplicationRequest $request) {
        //thông tin bệnh nhân
//        $user_id = MedicalSpecialistApplication::where('id', $request->id)->first()->patient_id;
//        echo $user_id;
//        $patient = Patient::where('patient_id', $user_id)->first();
//
//        echo "<br>" . $patient->fullname;
//        echo "<br>" . $patient->gender;
//        echo "<br>" . $patient->birthday;
//        echo "<br>" . $patient->staying_address;
//        
//        echo "<br>" . $request->sick_name;
//        echo "<br>" . $request->sick_id;
//        $ghichu = "Kết quả khám sơ bộ :<br>";
//        $ghichu = $ghichu . $request->so_bo_submit;
//        $ghichu = $ghichu . "<br>Chuẩn đoán: <br>";
//        $ghichu = $ghichu . "-Bệnh " . $request->sick_name . "<br>";
//        $ghichu = $ghichu . $request->chan_doan;
//        echo "<br><br>GHI CHÚ<br>" . $ghichu;
//        $link=$patient->fullname
//        . '&sex='.$patient->gender
//        . '&DOB='.$patient->birthday
//        . '&address='.$patient->staying_address
//        . '&obx_name='.$request->sick_name
//        . '&obx_result=5'
//        . '&obx_code='.$request->sick_id
//        . '&obx_note='.$ghichu;
//        $link='http://192.168.0.105:3900/result/?name='.urlencode($link);
//       
//        $result = file_get_contents($link, false);
        MedicalSpecialistApplication::where('id', $request->id)->update(['chan_doan' => $request->chan_doan, 'status' => 0]);
        return redirect()->route('doctor-compelete-list');
    }

    //lấy thông tin bệnh nhân
    public function getInfoPatient($i) {
        $medical = MedicalSpecialistApplication::where('id', $i)->first();
        $xetnghiem = MedicalTestApplication::where('patient_id', $medical->patient_id)->where('medical_date', $medical->medical_date)->where('status', MedicialManagement::COMPLETE_STATUS)->where('register_by', 2)->get();
        $so_bo = $medical->so_bo;

        if ($medical->chan_doan)
            $chan_doan = $medical->chan_doan;
        else
            $chan_doan = "";
        $xet_nghiem = "";
        $xet_nghiem_form = "";
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
        $type = DB::table('medical_test_type')->get();
        foreach ($type as $type) {
            $flag = 0;
            $xetnghiem = MedicalTestApplication::where('patient_id', $medical->patient_id)->where('medical_date', $medical->medical_date)->where('status', MedicialManagement::COMPLETE_STATUS)->where('register_by', 2)->get();
            foreach ($xetnghiem as $xetnghiem) {

                if ($type->id == $xetnghiem->xetnghiem) {
                    $flag = 1;
                    break;
                }
            }
            if ($flag == 0) {
                $xet_nghiem_form = $xet_nghiem_form . '<div class="form-group medical_test_type">

                            <input type="checkbox" name="Medical[]" value="' . $type->id . '" class="testAble" />
                            <label for="cheese">' . $type->name . '</label>
                        </div>
                        <br />';
            }
        }

        return response()->json(array('so_bo' => $so_bo, 'xet_nghiem' => $xet_nghiem, 'xet_nghiem_form' => $xet_nghiem_form, 'chan_doan' => $chan_doan), 200);
    }

    public function medical_test_detail_as_json($id) {
        $medical = MedicalTestApplication::where('id', $id)->first();
        $xetnghiem = $medical->xetnghiem;
        try {
            $contents = Storage::get($medical->url);
        } catch (\Exception $e) {
            return "Không tìm thấy file đơn khám";
        }


        $medical_application_xml = simplexml_load_string($contents);
        $data = ((array) $medical_application_xml);
        if ($xetnghiem != 4) {
            return view('json.test')->with($data);
        } else {
            return view('json.COPD')->with($data);
        }
    }

    public function getListNotice() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;
        $Wait1 = MedicalSpecialistApplication::where('status', 1)
                        ->where('Shift', $Shift)->count();
        $Wait2 = MedicalSpecialistApplication::where('status', 3)
                        ->where('Shift', $Shift)->count();

        return response()->json(array('Wait1' => $Wait1, 'Wait2' => $Wait2), 200);
    }

    public function testInsert(MedicalApplicationRequest $request) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        if (Carbon::now()->hour < 12)
            $Shift = 1;
        else
            $Shift = 2;
        $medical = $_POST['Medical'];
        //echo count($medical);
        if (count($medical) > 1) {
            //  echo "dăng kí xét nghiệm";
            MedicalSpecialistApplication::where('id', $request->id)->update([ 'status' => 2]);
            $patient_id = MedicalSpecialistApplication::where('id', $request->id)->first()->patient_id;
            foreach ($medical as $medical) {
                if ($medical == 0)
                    continue;
                $medical_application = new MedicalTestApplication();
                $medical_application->patient_id = $patient_id;
                $medical_application->status = 1;
                $medical_application->Shift = $Shift;
                $url = Carbon::now()->toDateString() . '-' . Auth::user()->id . '-' . substr(sha1(rand()), 0, 15) . '.xml';

                $medical_application->xetnghiem = $medical;

                $medical_application->url = $url;
                $medical_application->register_by = 2;

                $medical_application->medical_date = Carbon::now()->toDateString();
                $medical_application->date = date("Y-m-d H:i:s");
                $medical_application->save();
                Storage::copy('XN_chieucao.xml', $url);
            }
        } else {
            //  echo "khong xét nghiệm";
            MedicalSpecialistApplication::where('id', $request->id)->update(['status' => 3]);
        }

        return redirect()->route('doctor-list');
    }
        public function getAPIConnect($roomID) {
        $api = new ApiManagement();
//dien tam cac them so
        $department = "SOICT";
        $MACAddr = "20000";
        $port = "20000";
        $addr = "10000";
        $room = "room405";
        $om2m= $api->ApiConnect($department,$room,$addr,$MACAddr,$port);
       $msg=$om2m['msg'];
       $flag =$om2m['flag'];


        return response()->json(array('flag' => $flag, 'msg' => $msg), 200);
    }

    public function getAPIDisconnect($roomID) {
        $api = new ApiManagement();

       
        //dien tam cac them so
        $department = "SOICT";
        $MACAddr = "20000";
        $om2m = $api->ApiDisconnect($department, $MACAddr);

       $msg = $om2m['msg'];
       $flag =$om2m['flag'];

       
        return response()->json(array('msg' => $msg, 'flag' => $flag), 200);
    }
     public function getAPIResult() {
        $msg = "đã nhận kết quả";
        $api = new ApiManagement();

        //dien tam cac them so
        $department = "SOICT";
        $port = "20000";
        $addr = "10000";

        // $om2m = $api->ApiTemResult($department, $port, $addr);
        // $tem = $om2m['tem'];
        return response()->json(array('tem' => '100'), 200);
    }

}
