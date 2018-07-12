<?php

namespace App\RBACController;

use App\Model\MedicalApplication;
use App\Model\MedicalTestApplication;
use App\Model\MedicalSpecialistApplication;
use App\Model\Patient;
use App\User;
use Carbon\Carbon;
use Storage;

/**
 * Class này quản lý hồ sơ khám bệnh
 */
class MedicialManagement {

    const COMPLETE_STATUS = 0;
    const AWAIT_STATUS = 1;
    const WAITING_STATUS = 2;

    function __construct() {
        
    }

    /**
     * Tạo mới hồ sơ
     */
    public function addMedicialApplication($patient_id, $status, $medicial_data = array()) {
        $medical_application = new MedicalApplication();
        $medical_application->patient_id = $patient_id;
        $medical_application->status = $status;
        $medical_application->medical_date = Carbon::now()->toDateString();
        $medical_application->url = $medicial_data['url'];
        $medical_application->Shift = $medicial_data['Shift'];
        Storage::copy('donkham.xml', $medicial_data['url']);
        $medical_application->date = date("Y-m-d H:i:s");
        $medical_application->save();
    }

    /**
     * Lấy ra danh sách khám theo trạng thái
     */
    public function getListMedicialExam($status) {
        $list_medicial = Patient::join('medical_applications', 'medical_applications.patient_id', '=', 'patients.patient_id')
                ->select('medical_applications.id', 'medical_applications.date', 'patients.fullname', 'medical_applications.status')
                ->where('status', $status)
                ->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách khám theo trạng thái và tài nguyên nó được chia sẻ
     */
    public function getListMedicialExamShare($status, array $resources = array()) {
        $medicials = Patient::join('medical_applications', 'medical_applications.patient_id', '=', 'patients.patient_id')
                ->select('medical_applications.id', 'medical_applications.date', 'patients.fullname', 'medical_applications.status')
                ->where('status', $status)
                ->WhereIn('medical_applications.id', $resources)
                ->get();
        return $medicials;
    }

    /**
     * Lấy ra danh sách khám sức khỏe
     */
    public function getListMedicialHealth($status) {
        $list_medicial = Patient::join('medical_applications', 'medical_applications.patient_id', '=', 'patients.patient_id')
                ->select('medical_applications.id', 'medical_applications.date', 'patients.fullname', 'medical_applications.status')
                ->where('status', $status)
                ->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách khám theo thông tin bác sĩ
     */
    public function getListMedicialByDoctorInfo($status, $chucvu, $bangcap) {
        $list_medicial = Patient::join('medical_applications', 'medical_applications.patient_id', '=', 'patients.patient_id')
                ->select('medical_applications.id', 'medical_applications.date', 'patients.fullname', 'medical_applications.status')
                ->where('status', $status)
                ->where('medical_applications.chucvu', $chucvu)
                ->where('medical_applications.bangcap', $bangcap)
                ->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách khám chuyên khoa theo thông tin bác sĩ
     */
    public function getListSpecialistMedicialForDoctor($khoa, $chucvu, $status) {
        $list_medicial = MedicalSpecialistApplication::join('departments', 'medical_specialist_applications.khoa', '=', 'departments.id')
                        ->join('patients', 'medical_specialist_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_specialist_applications.id', 'medical_specialist_applications.date', 'medical_specialist_applications.medical_date', 'departments.name', 'patients.fullname as usersname', 'medical_specialist_applications.status')
                        ->where('medical_specialist_applications.status', $status)
                        ->where('medical_specialist_applications.khoa', $khoa)
                        ->whereBetween('medical_specialist_applications.medical_type', [1, 2])
                        ->orderBy('medical_specialist_applications.medical_date', 'desc')->get();
//        if(chucvu==3){
//                       $list_medicial=$list_medicial ->whereBetween('medical_specialist_applications.medical_type', [1, 2])
//                       ->orderBy('medical_specialist_applications.medical_date', 'desc')->get(); 
//        }else $list_medicial=$list_medicial->orderBy('medical_specialist_applications.medical_date', 'desc')->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách thí nghiệm
     */
    public function getListMedicialByTest($status, $khoa) {
        $list_medicial = Patient::join('medical_applications', 'medical_applications.patient_id', '=', 'patients.patient_id')
                ->select('medical_applications.id', 'medical_applications.date', 'patients.fullname', 'medical_applications.status')
                ->where('status', $status)
                ->where('medical_applications.kham', 3)
                ->where('medical_applications.khoa', $khoa)
                ->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách xét nghiệm cho nhân viên y tế
     */
    public function getListTestMedicial($status, $number) {
        $list_medicial = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->join('patients', 'medical_test_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_test_applications.id', 'medical_test_applications.date', 'medical_test_type.name', 'patients.fullname as usersname', 'medical_test_applications.status')
                        ->where('medical_test_applications.status', $status)
                        ->where('medical_test_type.phongban', $number)
                        ->orderBy('medical_test_applications.medical_date', 'desc')->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách xét nghiệm hôm nay cho nhân viên y tế
     */
    public function getListTestMedicialToday($status, $number) {
        $list_medicial = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->join('patients', 'medical_test_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_test_applications.id', 'medical_test_applications.date', 'medical_test_applications.medical_date', 'medical_test_type.name', 'patients.fullname as usersname', 'medical_test_applications.status')
                        ->where('medical_test_applications.status', $status)
                        ->where('medical_test_type.phongban', $number)
                        ->where('medical_test_applications.medical_date', Carbon::now()->toDateString())
                        ->orderBy('medical_test_applications.date', 'asc')->get();

        return $list_medicial;
    }

    /**
     * Lấy ra danh sách đăng kí xét nghiệm  cho nhân viên y tế
     */
    public function getListFutureTestMedicial($status, $number) {
        $list_medicial = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                ->join('patients', 'medical_test_applications.patient_id', '=', 'patients.patient_id')
                ->select('medical_test_applications.id', 'medical_test_applications.date', 'medical_test_applications.medical_date', 'medical_test_type.name', 'patients.fullname as usersname', 'medical_test_applications.status')
                ->where('medical_test_applications.status', $status)
                ->where('medical_test_type.phongban', $number)
                ->where('medical_test_applications.medical_date', '>=', Carbon::now()->toDateString())
                ->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách khám chuyên khoa cho nhân viên tiếp tân
     */
    public function getListSpecialistMedicialForTeller() {
        $list_medicial = MedicalSpecialistApplication::join('departments', 'medical_specialist_applications.khoa', '=', 'departments.id')
                        ->join('patients', 'medical_specialist_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_specialist_applications.id', 'medical_specialist_applications.date', 'medical_specialist_applications.medical_date', 'departments.name', 'patients.fullname as usersname', 'medical_specialist_applications.status')
                        ->where('medical_specialist_applications.status', '<>', 0)
                        ->orderBy('medical_specialist_applications.medical_date', 'desc')->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh khám chuyên khoa cho nhân viên tiếp tân
     */
    public function getListCompeleteSpecialistMedicialForTeller() {
        $list_medicial = MedicalSpecialistApplication::join('departments', 'medical_specialist_applications.khoa', '=', 'departments.id')
                        ->join('patients', 'medical_specialist_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_specialist_applications.id', 'medical_specialist_applications.date', 'medical_specialist_applications.medical_date', 'departments.name', 'patients.fullname as usersname', 'medical_specialist_applications.status')
                        ->where('medical_specialist_applications.status', 0)
                        ->orderBy('medical_specialist_applications.medical_date', 'desc')->get();
        return $list_medicial;
    }

    public function getListHealthMedicialForTeller() {
        $list_medicial = MedicalApplication::join('patients', 'medical_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_applications.id', 'medical_applications.date', 'medical_applications.medical_date', 'patients.fullname as usersname', 'medical_applications.status')
                        ->where('medical_applications.status', '<>', 0)
                        ->orderBy('medical_applications.medical_date', 'desc')->get();


        return $list_medicial;
    }

    /**
     * Lấy ra danh sách khám sức khỏe cho nhân viên tiếp tân
     */
    public function getListCompeleteHealthMedicialForTeller() {
        $list_medicial = MedicalApplication::join('patients', 'medical_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_applications.id', 'medical_applications.date', 'medical_applications.medical_date', 'patients.fullname as usersname', 'medical_applications.status')
                        ->where('medical_applications.status', 0)
                        ->orderBy('medical_applications.medical_date', 'desc')->get();
        return $list_medicial;
    }

    public function getListTestMedicialForTeller() {
        $list_medicial = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->join('patients', 'medical_test_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_test_applications.id', 'medical_test_applications.date', 'medical_test_applications.medical_date', 'medical_test_type.name', 'patients.fullname as usersname', 'medical_test_applications.status','medical_test_applications.register_by')
                        ->where('medical_test_applications.status', '<>', 0)
                        ->orderBy('medical_test_applications.medical_date', 'desc')->get();
        return $list_medicial;
    }

    /**
     * Lấy ra danh sách khám sức khỏe cho nhân viên tiếp tân
     */
    public function getListCompeleteTestMedicialForTeller() {
        $list_medicial = MedicalTestApplication::join('medical_test_type', 'medical_test_applications.xetnghiem', '=', 'medical_test_type.id')
                        ->join('patients', 'medical_test_applications.patient_id', '=', 'patients.patient_id')
                        ->select('medical_test_applications.id', 'medical_test_applications.date', 'medical_test_applications.medical_date', 'medical_test_type.name', 'patients.fullname as usersname', 'medical_test_applications.status')
                        ->where('medical_test_applications.status', 0)
                        ->orderBy('medical_test_applications.medical_date', 'desc')->get();
        return $list_medicial;
    }

    /**
     * Lấy ra đơn khám của người dùng nào đó
     */
    public function getMedicialExamOfPatient($patient_id) {
        
    }

    /**
     * Lấy ra trạng thái đơn khám của người dùng nào đó
     */
    public function getStatusMedicial($patient_id) {
        
    }

}

?>