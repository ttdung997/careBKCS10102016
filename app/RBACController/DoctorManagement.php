<?php

/**
 * 
 */

namespace App\RBACController;

use App\Model\Department;
use App\Model\Doctor;
use App\User;
use App\Http\Requests\UserRequest;
use Response;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Role;
use App\Model\User_Role;
use App\Model\Role_Permission;
use App\Model\Permission;
use App\Model\User_Department;
use App\RBACController\UserManagement;

class DoctorManagement extends UserManagement {

    /**
     * 
     * Lấy ra danh sách bác sĩ
     * */
    public function getListDoctor() {
        return $this->getListUserFollowPosition(self::DOCTOR_POSITION);
    }

    /**
     * Thêm bác sĩ mới
     *
     * */
    public function addDoctor($name, $email, $password,$khoa,$chucvu,$bangcap,$phongban) {

        $this->addUser($name, $email, $password, self::DOCTOR_POSITION,$khoa,$chucvu,$bangcap,$phongban);
    }

    /**
     * Lấy ra thông tin cơ bản của Bác Sĩ
     * 
     * */
    public function getInfoDoctor($doctor_id) {
        return $this->getUser($doctor_id);
    }

    /**
     * Cập nhật thông tin Bác Sĩ
     * 
     * */
    public function updateDoctorInfo($id, UserRequest $request) {
        if ($request->isMethod('patch')) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
//            $user->khoa = $request->departments;
//            $user->bangcap = $request->bangcap;
//            $user->chucvu = $request->chucvu;
            if (isset($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            return Response::json(['flash_message' => 'Đã cập nhật thông tin bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $user = User::findOrFail($id);
            return Response::json($user);
        }
    }

    /**
     * Xóa bác sĩ
     */
    public function deleteDoctor(UserRequest $request) {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL)
                User::findOrFail($user_id)->delete();
        }
    }

}

?>