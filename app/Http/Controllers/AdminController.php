<?php

namespace App\Http\Controllers;

use App\Model\Department;
use App\Model\Client;
use App\User;   
use App\Http\Requests\UserRequest;
use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\RoleRequest;
use Response;
use Auth;
use Validator;
use File;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Role;
use App\Model\User_Role;
use App\Model\Role_Permission;
use App\Model\Permission;
use App\Model\User_Department;
use App\Model\Hospital;
use App\Model\Client_Role;
use App\RBACController\DoctorManagement;
use App\RBACController\RoleManagement;
use App\RBACController\UserManagement;

class AdminController extends Controller
{
    private $role_mng;
    private $doctor_mng;
    private $user_mng;
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('admin');
        $this->role_mng = new RoleManagement();
        $this->doctor_mng = new DoctorManagement();
        $this->user_mng = new UserManagement();
    }

    /**
    * Hiện trang quản lý chung của Admin
    *
    */

    public function index()
    {
        return view('admin.index');
    }

    /**
    * Lấy danh sách các nhân viên
    *
    */

    public function listStaff()
    {
        $users = User::where('id', '!=', Auth::id())->where('position', 3)->orderBy('id', 'DESC')->get();
        $result = [];
        foreach ($users as $user) {
            // dd($user_role);
            $attrs = $user->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($user->{$attr});
            }
            $result[] = $data;
        }
        return Response::json(['data' => $result]);
    }

    /**
    * Hiện danh sách các nhân viên
    *
    */

    public function indexStaff()
    {
        return view('admin.staff');
    }

    /**
    * Lưu nhân viên
    *
    */

    public function storeStaff(UserRequest $request)
    {
        // $user = new User();
        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->password = bcrypt($request->password);
        // $user->password = $request->hashPass;
        // $user->position = UserManagement::STAFF_POSITION;

        // $user->save();

        //them vao bang staffs
        // $id_user = $user->id;
        // $staff = new Staff();
        // $staff->staff_id = $id_user;
        // $staff->save();
        $this->user_mng->addUser($request->name,$request->email,$request->hashPass,UserManagement::STAFF_POSITION);

        return Response::json(['flash_message' => 'Đã thêm nhân viên!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Hiện thông tin cơ bản của nhân viên
    *
    */

    public function showStaff($id)
    {
        $user = User::findOrFail($id);
        $result = [];
        
            // dd($user_role);
        $attrs = $user->getAttributes();

        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($user->{$attr});
        }
        return Response::json($result);
    }

    /**
    * Cập nhật thông tin nhân viên
    *
    */

    public function updateStaff($id, UserRequest $request)
    {
        if ($request->isMethod('patch')) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            if (isset($request->hashPass)) {
                $user->password = $request->hashPass;
            }
            $user->save();

            return Response::json(['flash_message' => 'Đã cập nhật thông tin nhân viên!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $user = User::findOrFail($id);
            return Response::json($user);
        }
    }

    /**
    * Xóa nhân viên
    *
    */

    public function destroyStaff(UserRequest $request)
    {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL){
                // giáp: xóa cả ở bảng 'staffs'
                DB::table('staffs')->where('staff_id', $user_id)->delete();
                User::findOrFail($user_id)->delete();
            }
        }
        return Response::json(['flash_message' => 'Đã xóa nhân viên!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Lấy ra danh sách bác sĩ
    *
    */

    public function listDoctor()
    {
        $list_doctor = $this->doctor_mng ->getListDoctor();
            $result = [];
            foreach ($list_doctor as $doctor) {
                // dd($user_role);
                $attrs = $doctor->getAttributes();

                $data = [];
                foreach (array_keys($attrs) as $attr) {
                    $data[$attr] = e($doctor->{$attr});
                }
                $result[] = $data;
            }
        return Response::json(['data' => $result]);
    }

    /**
    * Hiện danh sách bác sĩ chung
    *
    */

    public function indexDoctor()
    {
        $departments = Department::orderBy('id','DESC')->get();
        return view('admin.doctor',compact('departments'));
    }

    /**
    * Lưu bác sĩ mới
    *
    */
    public function storeDoctor(Request $request)
    {
        $this->doctor_mng ->addDoctor($request->name, $request->email, $request->hashPass, $request->departments);
        return Response::json(['flash_message' => 'Đã thêm bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Hiện thông tin cơ bản của bác sĩ
    *
    */
    public function showDoctor($id)
    {
        $doctor = $this->doctor_mng ->getInfoDoctor($id);
        $result = [];
        $attrs = $doctor->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($doctor->{$attr});
        }
        return Response::json($result);
    }

    /**
    * Cập nhật thông tin bác sĩ
    *
    */

    public function updateDoctor($id, UserRequest $request)
    {
        $doctormng = new DoctorManagement();
        if ($request->isMethod('patch')) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            if (isset($request->hashPass)) {
                $user->password = $request->hashPass;
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
    *
    */

    public function destroyDoctor(UserRequest $request)
    {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL){
                // giáp: xóa cả ở bảng 'doctor'
                DB::table('doctors')->where('doctor_id', $user_id)->delete();
                User::findOrFail($user_id)->delete();
            }
        }
        return Response::json(['flash_message' => 'Đã xóa bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Hiện danh sách role của bác sĩ
    *
    */

    public function showRoleDoctor($id){
        return view('admin.doctorrole',compact('id'));
    }

    /**
    * Lấy ra danh sách role của bác sĩ
    *
    */

    public function listRoleOfDoctor($id){
        $user_roles = User_Role::join('roles','user_role.role_id','=','roles.id')
                        ->where('user_role.user_id','=',$id)
                        ->select('roles.id','roles.name','roles.description')
                        ->get();
        $result = [];
        foreach ($user_roles as $user_role) {
            // dd($user_role);
            $attrs = $user_role->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($user_role->{$attr});
            }
            $result[] = $data;
        }
        return Response::json([
            'data' => $result
        ]);
    }

    /**
    * Xóa role của bác sĩ
    *
    */

    public function deleteRoleOfDoctor(UserRequest $request){
        $doctor_id = $request->doctor_id;
        $role_ids = $request->role_ids;
        for($i = 0; $i<count($role_ids); $i++){
            DB::table('user_role')->where('user_id','=',$doctor_id,'and','role_id','=',$role_ids[$i])->delete();
        }
        return Response::json(['flash_message' => 'Đã xóa thành công role trong bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Thêm role cho bác sĩ
    *
    */

    public function addRoleforDoctor(Request $request){
        $doctor_id = $request->doctor_id;
        $role_ids = $request ->role_ids;
        for($i = 0; $i<count($role_ids); $i++){
            $old_user_role = User_Role::where('user_id','=',$doctor_id)->where('role_id','=',$role_ids[$i])->count();
            if($old_user_role<=0){
                $user_role = new User_Role();
                $user_role->user_id = $doctor_id;
                $user_role->role_id = $role_ids[$i];
                $user_role->save();
            }
        }

        return Response::json(['flash_message' => 'Đã thêm role cho bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }


    /**
    *Department manage
    *
    */
    public function listDepartment()
    {
        $departments = Department::orderBy('id', 'DESC')->get();
        $result = [];
        foreach ($departments as $department) {
            // dd($user_role);
            $attrs = $department->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($department->{$attr});
            }
            $result[] = $data;
        }
        return Response::json(['data' => $result]);
    }

    public function indexDepartment()
    {
        return view('admin.department');
    }

    /**
    * Lưu thông tin khoa
    *
    */

    public function storeDepartment(DepartmentRequest $request)
    {
        $department = new Department();
        $department->name = $request->name;
        $department->description = $request->description;
        $department->save();

        return Response::json(['flash_message' => 'Đã thêm khoa!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Hiện ra thông tin khoa
    *
    */

    public function showDepartment($id)
    {
        $department = Department::findOrFail($id);
        $result = [];
        $attrs = $department->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($department->{$attr});
        }
        return Response::json($result);
    }

    /**
    * Cập nhật thông tin khoa
    *
    */

    public function updateDepartment($id, DepartmentRequest $request)
    {
        if ($request->isMethod('patch')) {
            $department = Department::findOrFail($id);
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();

            return Response::json(['flash_message' => 'Đã cập nhật thông tin khoa!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $department = Department::findOrFail($id);
            $result = [];
            $attrs = $department->getAttributes();
            foreach (array_keys($attrs) as $attr) {
                $result[$attr] = e($department->{$attr});
            }
            return Response::json($result);
        }
    }

    /**
    * Xóa khoa
    *
    */

    public function destroyDepartment(DepartmentRequest $request)
    {
        if (is_string($request->ids))
            $department_ids = explode(' ', $request->ids);

        foreach ($department_ids as $department_id) {
            if ($department_id != NULL)
                Department::findOrFail($department_id)->delete();
        }
        return Response::json(['flash_message' => 'Đã xóa khoa!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    *Role management
    *
    */
    public function indexRole()
    {
        return view('admin.role', [
            'permissions' => Permission::orderBy('id','DESC')->get()
        ]);
    }

    /**
    * Lấy ra danh sách role
    *
    */

    public function listRole(){
        
        $roles = $this->role_mng -> getListOfRole();
        $result = [];
        foreach ($roles as $role) {
            $attrs = $role->getAttributes();
            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($role->{$attr});
            }
            $result[] = $data;
        }
        return Response::json([
            'data' => $result
        ]);
    }

    /**
    * Hiện thông tin của role
    *
    */

    public function showRole($id){

        $role = $this->role_mng->getInfoOfRole($id);
        $result = [];
        $attrs = $role->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($role->{$attr});
        }
        return Response::json($result);
    }

    /**
    * Lưu thông tin role
    *
    */

    public function storeRole(RoleRequest $request){
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        $role_id = $role->id;

        $permissions = $request->permissions;
        for($i = 0; $i < count($permissions); $i++){
            if(isset($permissions[$i])){
                $this->role_mng->addPermissionForRole($role_id,$permissions[$i]);
            }
        }

        return Response::json(['flash_message' => 'Đã thêm role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Sửa đổi, update thông tin role
    *
    */

    public function updateRole(RoleRequest $request,$id){
        if ($request->isMethod('patch')) {
            $this->role_mng->editRole($id,$request->name,$request->description);

            $this->role_mng->deletePermissionOfRole($id);

            $permissions = $request->permissions;

            for($i = 0; $i < count($permissions); $i++){
                if(isset($permissions[$i])){
                    $this->role_mng -> addPermissionForRole($id,$permissions[$i]);
                }
            }

            return Response::json(['flash_message' => 'Đã cập nhật thông tin role!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $role = $this->role_mng->getInfoOfRole($id);
            if (!$role) {
                return Response::json([]);
            }
            $result = [];

            $role_permission = Role_Permission::where('role_id','=',$id)->select('permission_id')->groupBy('permission_id')->get();
            $permissions =[];
            foreach($role_permission as $item){
                $permissions[] = $item->permission_id;
            }
            $result = array(
                        "id"    => $id,
                        "name" => $role->name,
                        "description" => $role->description,
                        "permissions"  => $permissions
                        );
            return Response::json($result);
        }
    }

    /**
    * Xóa role
    *
    */

    public function destroyRole(RoleRequest $request){
        if (is_string($request->ids))
            $role_ids = explode(' ', $request->ids);

        foreach ($role_ids as $role_id) {
            if ($role_id != NULL)
                $this->role_mng->deleteRole($role_id);
        }
        return Response::json(['flash_message' => 'Đã xóa role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Hiện danh sách bác sĩ của role
    *
    */

    public function showDoctorRole($id){
        $IdRoleOfPatient = RoleManagement::PATIENT_ROLE;
        return view('admin.roledoctor',compact('id','IdRoleOfPatient'));
    }

    /**
    * Lấy ra danh sách bác sĩ của role
    *
    */

    public function listUserOfRole($id){
        $user_roles = $this->role_mng->getListUserOfRole($id);
        $result = [];
        foreach ($user_roles as $user_role) {
            // dd($user_role);
            $attrs = $user_role->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($user_role->{$attr});
            }
            $result[] = $data;
        }
        return Response::json([
            'data' => $result
        ]);
    }

    /**
    * Xóa bác sĩ trong role
    *
    */

    public function deleteDoctorOfRole(RoleRequest $request){
        $doctor_ids = $request->doctor_ids;
        $role_id = $request->role_id;
        for($i = 0; $i<count($doctor_ids); $i++){
            $this->role_mng->deleteUserRole($role_id,$doctor_ids[$i]);
        }
        return Response::json(['flash_message' => 'Đã xóa thành công bác sĩ trong role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Thêm bác sĩ vào role
    *
    */

    public function addDoctorforRole(Request $request){
        $doctor_ids = $request->doctor_ids;
        $role_id = $request ->role_id;
        for($i = 0; $i<count($doctor_ids); $i++){
            $old_user_role = User_Role::where('role_id','=',$role_id)->where('user_id','=',$doctor_ids[$i])->count();
            if($old_user_role<=0){
                $this->role_mng->addUserforRole($role_id,$doctor_ids[$i]);
            }
        }

        return Response::json(['flash_message' => 'Đã thêm bác sĩ vào role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
    * Đưa ra danh sách các bệnh viên đối tác
    *
    */
    public function indexHospital(){
        return view('admin.hospital');
    }

    public function listHospital(){
        $hospital_data = Hospital::orderBy('id','DESC')->get();
        return Response::json(['data' => $hospital_data]);
    }

    public function showHospital($id){
        // $role = $this->role_mng->getInfoOfRole($id);
        $hospital = Hospital::findOrFail($id);
        $result = [];
        $attrs = $hospital->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($hospital->{$attr});
        }
        return Response::json($result);
    }

    /**
    * Thêm role cho provider
    */
    public function addRoleForProvider(Request $request){
        $role_id = $request->role_id;
        $provider_id = $request->provider_id;

        // dd($role_id);

        // $client = Client::findOrFail($client_id);
        // $client ->role_id = $role_id;
        // $client ->save();
        
        DB::table('oidcproviders')->where('id', $provider_id)->update([
            'role_id' => $role_id
            ]);
        $provider = DB::table('oidcproviders')->where('id',$provider_id);
        //$provider->role_id = $role_id;
        return Response::json(['flash_message' => 'Đã cập nhật role cho provider!', 'message_level' => 'success', 'message_icon' => 'check']);
        //return $provider->role_id;
        
    }

}