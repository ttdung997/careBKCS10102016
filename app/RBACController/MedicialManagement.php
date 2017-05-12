<?php 
namespace App\RBACController;
use App\Model\MedicalApplication;
use App\User;
use Storage;

/**
* Class này quản lý hồ sơ khám bệnh
*/
class MedicialManagement
{
	const AWAIT_STATUS = 1;

	function __construct()
	{
	}

	/**
	* Tạo mới hồ sơ
	*/
	public function addMedicialApplication($patient_id,$status, $medicial_data = array()){
		$medical_application = new MedicalApplication();
		$medical_application->user_id = $patient_id;
        $medical_application->status = $status;
        $medical_application->url = $medicial_data['url'];
        Storage::copy('donkham.xml', $medicial_data['url']);
        $medical_application->date = date("Y-m-d H:i:s");
        $medical_application->save();
	}

	/**
	* Lấy ra danh sách khám theo trạng thái
	*/
	public function getListMedicialExam($status){
		$list_medicial = User::join('medical_applications', 'medical_applications.user_id', '=', 'users.id')
							->select('medical_applications.id','medical_applications.date','users.name','medical_applications.status')
				            ->where('status',$status)
				            ->get();
		return $list_medicial;
	}

	/**
	* Lấy ra danh sách khám theo trạng thái và tài nguyên nó được chia sẻ
	*/
	public function getListMedicialExamShare($status, array $resources = array()){
		$medicials = User::join('medical_applications', 'medical_applications.user_id', '=', 								'users.id')
							->select('medical_applications.id','medical_applications.date','users.name','medical_applications.status')
				            ->where('status',$status)
				            ->WhereIn('medical_applications.id',$resources)
				            ->get();
		return $medicials;
	}

	/**
	* Lấy ra đơn khám của người dùng nào đó
	*/
	public function getMedicialExamOfPatient($patient_id){

	}

	/**
	* Lấy ra trạng thái đơn khám của người dùng nào đó
	*/
	public function getStatusMedicial($patient_id){

	}
}


 ?>