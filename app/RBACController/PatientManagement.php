<?php 
namespace App\RBACController;

use App\RBACController\UserManagement;
use App\RBACController\MedicialManagement;

use App\User;





/**
* Class naỳ quản lý thông tin của bệnh nhân
*/
class PatientManagement extends UserManagement
{
	
	function __construct()
	{
	}

	/**
	* Cập nhật thông tin bệnh nhân
	*/
 	public function updatePatient($user_id,$patient_data = array()){
 		if(!empty($user_data)){
 			$patient = User::findOrFail($user_id);
 			$patient ->name = $patient_data['name'];
 			$patient ->gender = $patient_data['gender'];
 			$patient ->birthday = $patient_data['birthday'];
 			$patient ->id_number = $patient_data['id_number'];
 			$patient ->id_address = $patient_data['id_address'];
 			$patient ->job = $patient_data['job'];
 			$patient ->company = $patient_data['company'];
 			$patient ->family_history = $patient_data['family_history'];
 			$patient ->personal_history = $patient_data['personal_history'];
 			$patient ->avatar = $patient_data['avatar'];

 			$patient ->save();
 		}
	}

	/**
	* Tạo mới bệnh nhân
	*/
	public function addPatient($name, $email, $password){
		$this->addUser($name, $email, $password, self::PATIENT_POSITION);
	}

	/**
	* Lấy ra thông tin bệnh nhân
	*/
	public function getInfoPatient($patient_id){
		return $this->getUser($patient_id);
	}

	/**
	* Xóa bệnh nhân khỏi hệ thống
	*/
	public function deletePatient($patient_id){
		$this->deleteUser($patient_id);
	}


	/**
	* Lấy ra danh sách bệnh nhân
	*/
	public function getListPatient(){
		return $this->getListUserFollowPosition(self::PATIENT_POSITION);
	}

	/**
	* Sửa thông tin bệnh nhân
	*/
	public function editPatient($patient_id, $name, $email, $password){
		$this ->editUser($patient_id, $name, $email, $password);
	}

	/**
	* Đăng ký khám cho bệnh nhân
	*/
	public function registerExaminal($patient_id, $medicial_data = array()){
		$medicial_mng = new MedicialManagement();
		$medicial_mng ->addMedicialApplication($patient_id,MedicialManagement::AWAIT_STATUS,$medicial_data);
	}

}

 ?>