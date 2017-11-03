<?php

namespace App\RBACController;

use App\Model\Role;
use App\Model\User_Role;
use App\Model\Role_Permission;
use App\User;

/**
 * class này quản lý về Role
 */
class RoleManagement {

    const PATIENT_ROLE = 1; //role bệnh nhân
    const STAFF_ROLE = 2;  //role nhân viên
    const DOCTOR_ROLE = 3;  //role bác sĩ

    /**
     * Lấy ra danh sách các role
     */

    public function getListOfRole() {
        $list_role = Role::orderBy('id', 'DESC')->get();
        return $list_role;
    }

    public static function getListRole() {
        $list_role = Role::orderBy('id', 'DESC')->get();
        return $list_role;
    }

    /**
     * Lấy ra thông tin của một Role
     */
    public function getInfoOfRole($role_id) {
        $role = Role::findOrFail($role_id);
        return $role;
    }

    /**
     * Thêm Role
     */
    public function addRole($role_id = null, $name, $description) {
        $role = new Role();
        if ($role_id != null) {
            $role->id = $role_id;
        }
        $role->name = $name;
        $role->description = $description;
        $role->save();
    }

    /**
     * Xoá một Role
     */
    public function deleteRole($role_id) {
        Role::findOrFail($role_id)->delete();
    }

    /**
     * Sửa role
     */
    public function editRole($role_id, $name, $description) {
        $role = Role::findOrFail($role_id);
        $role->name = $name;
        $role->description = $description;
        $role->save();
    }

    /**
     * đưa ra danh sách người dùng của một role nào đó
     */
    public function getListUserOfRole($role_id) {
        $list_patienrole = User::join('user_role', 'users.id', '=', 'user_role.user_id')
                ->where('user_role.role_id', '=', $role_id)
                ->select('users.id', 'users.name', 'users.email')
                ->get();
        return $list_patienrole;
    }

    /**
     * thêm một User vào trong Role nào đó
     */
    public function addUserforRole($role_id, $user_id) {
        $user_role = new User_Role();
        $user_role->user_id = $user_id;
        $user_role->role_id = $role_id;
        $user_role->save();
    }

    /**
     * Xoá một Role_User
     */
    public function deleteUserRole($role_id, $user_id) {
        User_Role::where('user_id', '=', $user_id)
                ->where('role_id', '=', $role_id)
                ->delete();
    }

    /**
     * Thêm một Permission vào trong Role nào đó
     */
    public function addPermissionForRole($role_id, $permission_id) {
        $role_permission = new Role_Permission();
        $role_permission->role_id = $role_id;
        $role_permission->permission_id = $permission_id;
        $role_permission->save();
    }

    /**
     * xoá Permission cuả Role
     */
    public function deletePermissionOfRole($role_id = null, $permission_id = null) {
        if ($role_id != null && $permission_id != null) {
            Role_Permission::where('role_id', '=', $role_id)
                    ->where('permission_id', '=', $permission_id)
                    ->delete();
        } elseif ($role_id != null && $permission_id == null) {
            Role_Permission::where('role_id', '=', $role_id)
                    ->delete();
        } elseif ($role_id == null && $permission_id != null) {
            Role_Permission::where('permission_id', '=', $permission_id)
                    ->delete();
        } else {
            return "Tham số đầu vào không đúng";
        }
    }

    /**
     * Lấy ra danh sách permission của role
     */
    public function getListPermissionOfRole($role_id) {
        $list_permissionrole = Role_Permission::where('role_id', $role_id)
                ->get();
        return $list_permissionrole;
    }

    public function testVN() {
        return 'test 2134';
    }

}

?>