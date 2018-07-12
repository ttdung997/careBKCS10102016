<?php

namespace App\RBACController;

use App\User;
use App\Model\User_Department;
use App\RBACController\RoleManagement;
use App\Model\Doctor;
use App\Model\Staff;
use App\Model\Patient;
use App\Model\Infomation;

/**
 * class này dùng để quản lý người dùng
 */
class UserManagement {

    const PATIENT_POSITION = 1; //bệnh nhân
    const DOCTOR_POSITION = 2;  // bác sĩ
    const STAFF_POSITION = 3;   // nhân viên
    const ADMIN_POSITION = 4;   //admin

    function __construct() {
        
    }

    /**
     * Lấy ra danh sách người dùng theo chức vụ
     */
    public function getListUserFollowPosition($position) {
        $user_list = User::where('position', '=', $position)->orderBy('id', 'DESC')->get();
        return $user_list;
    }

    /**
     * Thêm người dùng vào hệ thống
     */
    public function addUser($name, $email, $password, $position, $departments = null, $chucvu = null, $bangcap = null, $phongban = null) {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->position = $position;
        $user->save();

        $user_id = $user->id;

        if ($departments != null) {

            for ($i = 0; $i < count($departments); $i++) {
                $user_depart = new User_Department();
                $user_depart->user_id = $user_id;
                $user_depart->department_id = $departments[$i];
            }
        }

        if ($chucvu != null) {
            $info = new Infomation();
            $info->user_id = $user_id;
            $info->khoa_id = $departments;
            $info->chucvu_id = $chucvu;
            $info->bangcap_id = $bangcap;
            $info->phongban_id = $phongban;
            $info->save();
        }
        $role_mng = new RoleManagement();

        if ($position == UserManagement::PATIENT_POSITION) {
            $role_mng->addUserforRole(RoleManagement::PATIENT_ROLE, $user_id);
            $patient = new Patient();
            $patient->patient_id = $user_id;
            $patient->fullname = $name;
            $patient->save();
        } elseif ($position == UserManagement::STAFF_POSITION) {
            $role_mng->addUserforRole(RoleManagement::STAFF_ROLE, $user_id);
            $staff = new Staff();
            $staff->staff_id = $user_id;
            $staff->bangcap = $chucvu;
            $staff->chucvu = $bangcap;
            $staff->khoa = $departments;
            $staff->fullname = $name;
            $staff->save();
        } elseif ($position == UserManagement::DOCTOR_POSITION) {
            $doctor = new Doctor();
            $doctor->doctor_id = $user_id;
            $doctor->fullname = $name;
            $doctor->khoa = $departments;
            $doctor->chucvu = $chucvu;
            $doctor->bangcap = $bangcap;
            $doctor->save();
        }
    }

    /**
     * Xóa người dùng khỏi hệ thống
     */
    public function deleteUser($user_id) {
        User::findOrFail($user_id)->delete();
    }

    /**
     * Lấy thông tin của người dùng
     */
    public function getUser($user_id) {
        $user = User::findOrFail($user_id);
        return $user;
    }

    /**
     * Sửa thông tin của người dùng
     */
    public function editUser($user_id, $name, $email, $password, $departments = null) {
        $user = User::findOrFail($user_id);
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->save();
    }

}

?>