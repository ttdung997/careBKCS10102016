<?php

namespace App\Http\Controllers;

use App\Model\Department;
use App\Model\Degree;
use App\Model\Office;
use App\Model\Client;
use App\Model\Staff;
use App\Model\Doctor;
use App\Model\MedicalTestType;
use App\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\DepartmentRequest;
use App\Http\Requests\DegreeRequest;
use App\Http\Requests\OfficeRequest;
use App\Http\Requests\MedicalTestTypeRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoomRequest;
use Response;
use Auth;
use Validator;
use File;
use Session;
use Illuminate\Http\Request;
use DB;
use App\Model\Role;
use App\Model\User_Role;
use App\Model\Role_Permission;
use App\Model\Permission;
use App\Model\Room;
use App\Model\User_Department;
use App\Model\Hospital;
use App\Model\Client_Role;
use App\RBACController\DoctorManagement;
use App\RBACController\RoleManagement;
use App\RBACController\UserManagement;
use App\RBACController\ApiManagement;

class AdminController extends Controller {

    private $role_mng;
    private $doctor_mng;
    private $user_mng;

    public function __construct() {
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
    public function index() {
        return view('admin.index');
    }

    /**
     * Lấy danh sách các nhân viên
     *
     */
    public function listStaff() {
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
    public function indexStaff() {
        return view('admin.staff');
    }

    /**
     * Lưu nhân viên
     *
     */
    public function storeStaff(UserRequest $request) {
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
        $this->user_mng->addUser($request->name, $request->email, $request->hashPass, UserManagement::STAFF_POSITION, $request->khoa, $request->chucvu, $request->bangcap, $request->room_number);

        return Response::json(['flash_message' => 'Đã thêm nhân viên!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện thông tin cơ bản của nhân viên
     *
     */
    public function showStaff($id) {
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
    public function updateStaff($id, UserRequest $request) {
        if ($request->isMethod('patch')) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $staff = Staff::where('staff_id', $id)
                    ->update(['khoa' => $request->khoa,
                'chucvu' => $request->chucvu,
                'bangcap' => $request->bangcap,
                'phongban' => $request->room_number,
                'fullname' => $request->name,
            ]);
//            $que = DB::table('user_infomation')
//                    ->where('user_id', $id)
//                    ->update(['khoa_id' => $request->khoa,
//                'chucvu_id' => $request->chucvu,
//                'bangcap_id' => $request->bangcap,
//                'phongban_id' => $request->room_number,
//            ]);
//            if (!$que) {
//                $que = DB::table('user_infomation')
//                        ->insert([
//                    'user_id' => $id,
//                    'khoa_id' => $request->khoa,
//                    'chucvu_id' => $request->chucvu,
//                    'bangcap_id' => $request->bangcap,
//                    'phongban_id' => $request->room_number,
//                ]);
//            }
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
    public function destroyStaff(UserRequest $request) {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL) {
                // giáp: xóa cả ở bảng 'staffs'
                DB::table('staffs')->where('staff_id', $user_id)->delete();
                DB::table('user_infomation')->where('user_id', $user_id)->delete();
                User::findOrFail($user_id)->delete();
            }
        }
        return Response::json(['flash_message' => 'Đã xóa nhân viên!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Lấy ra danh sách bác sĩ
     *
     */
    public function listDoctor() {
        $list_doctor = $this->doctor_mng->getListDoctor();
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
    public function indexDoctor() {
        $departments = Department::orderBy('id', 'DESC')->get();
        return view('admin.doctor', compact('departments'));
    }

    /**
     * Lưu bác sĩ mới
     *
     */
    public function storeDoctor(Request $request) {
        $this->doctor_mng->addDoctor($request->name, $request->email, $request->hashPass, $request->khoa, $request->chucvu, $request->bangcap, $request->room_number);
        return Response::json(['flash_message' => 'Đã thêm bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện thông tin cơ bản của bác sĩ
     *
     */
    public function showDoctor($id) {
        $doctor = $this->doctor_mng->getInfoDoctor($id);
        $result = [];
        $attrs = $doctor->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($doctor->{$attr});
        }
        $info = DB::table('doctors')->where('doctor_id', $doctor->id)->first();



        $bangcap = DB::table('user_degree')->where('id', $info->bangcap)->first();
        $chucvu = DB::table('user_office')->where('id', $info->chucvu)->first();
        $khoa = DB::table('departments')->where('id', $info->khoa)->first();

        if ($info->bangcap == Null)
            $result['bangcap'] = "Trống";
        else
            $result['bangcap'] = $chucvu->name;
        if ($info->chucvu == Null)
            $result['chucvu'] = "Trống";
        else
            $result['chucvu'] = $chucvu->name;
        if ($info->khoa == Null)
            $result['khoa'] = "Trống";
        else
            $result['khoa'] = $khoa->name;
        return Response::json($result);
    }

    /**
     * Cập nhật thông tin bác sĩ
     *
     */
    public function updateDoctor($id, UserRequest $request) {
        $doctormng = new DoctorManagement();
        if ($request->isMethod('patch')) {
            $user = User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $doctor = Doctor::where('doctor_id', $id)
                    ->update(['khoa' => $request->khoa,
                'chucvu' => $request->chucvu,
                'bangcap' => $request->bangcap,
                'phongban' => $request->room_number,
                'fullname' => $request->name,
            ]);
//            $que = DB::table('user_infomation')
//                    ->where('user_id', $id)
//                    ->update(['khoa_id' => $request->khoa,
//                'chucvu_id' => $request->chucvu,
//                'bangcap_id' => $request->bangcap,
//                'phongban_id' => $request->room_number,
//            ]);
//            if (!$que) {
//                $que = DB::table('user_infomation')
//                        ->insert([
//                    'user_id' => $id,
//                    'khoa_id' => $request->khoa,
//                    'chucvu_id' => $request->chucvu,
//                    'bangcap_id' => $request->bangcap,
//                    'bangcap_id' => $request->bangcap,
//                    'phongban_id' => $request->room_number,
//                ]);
//            }
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
    public function destroyDoctor(UserRequest $request) {
        if (is_string($request->ids))
            $user_ids = explode(' ', $request->ids);

        foreach ($user_ids as $user_id) {
            if ($user_id != NULL) {
                // giáp: xóa cả ở bảng 'doctor'
                DB::table('doctors')->where('doctor_id', $user_id)->delete();
                DB::table('user_infomation')->where('user_id', $user_id)->delete();
                User::findOrFail($user_id)->delete();
            }
        }
        return Response::json(['flash_message' => 'Đã xóa bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện danh sách role của bác sĩ
     *
     */
    public function showRoleDoctor($id) {
        return view('admin.doctorrole', compact('id'));
    }

    /**
     * Lấy ra danh sách role của bác sĩ
     *
     */
    public function listRoleOfDoctor($id) {
        $user_roles = User_Role::join('roles', 'user_role.role_id', '=', 'roles.id')
                ->where('user_role.user_id', '=', $id)
                ->select('roles.id', 'roles.name', 'roles.description')
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
    public function deleteRoleOfDoctor(UserRequest $request) {
        $doctor_id = $request->doctor_id;
        $role_ids = $request->role_ids;
        for ($i = 0; $i < count($role_ids); $i++) {
            DB::table('user_role')->where('user_id', '=', $doctor_id, 'and', 'role_id', '=', $role_ids[$i])->delete();
        }
        return Response::json(['flash_message' => 'Đã xóa thành công role trong bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Thêm role cho bác sĩ
     *
     */
    public function addRoleforDoctor(Request $request) {
        $doctor_id = $request->doctor_id;
        $role_ids = $request->role_ids;
        for ($i = 0; $i < count($role_ids); $i++) {
            $old_user_role = User_Role::where('user_id', '=', $doctor_id)->where('role_id', '=', $role_ids[$i])->count();
            if ($old_user_role <= 0) {
                $user_role = new User_Role();
                $user_role->user_id = $doctor_id;
                $user_role->role_id = $role_ids[$i];
                $user_role->save();
            }
        }

        return Response::json(['flash_message' => 'Đã thêm role cho bác sĩ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Department manage
     *
     */
    public function listDepartment() {
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

    public function indexDepartment() {
        return view('admin.department');
    }

    /**
     * Lưu thông tin khoa
     *
     */
    public function storeDepartment(DepartmentRequest $request) {
        $department = new Department();
        $ApiManagement = new ApiManagement();
        $om2m = $ApiManagement->ApiAddDepartment($ApiManagement->stripVN($request->name));

        if ($om2m['flag'] == 1) {
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();
        }
        return Response::json(['flash_message' => $om2m['msg'], 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện ra thông tin khoa
     *
     */
    public function showDepartment($id) {
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
    public function updateDepartment($id, DepartmentRequest $request) {
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
    public function destroyDepartment(DepartmentRequest $request) {
        $msg = "Đã xóa khoa!";
        $ApiManagement = new ApiManagement();
        if (is_string($request->ids))
            $department_ids = explode(' ', $request->ids);

        foreach ($department_ids as $department_id) {
            if ($department_id != NULL) {
                $department = $ApiManagement->stripVN(DB::table('departments')
                                ->where('id', $department_id)->first()->name);
                $om2m = $ApiManagement->ApiRemoveDepartment($department);

                if ($om2m['flag'] == 0) {
                    $msg = $om2m['msg'];
                    break;
                }

                Department::findOrFail($department_id)->delete();
                DB::table('user_room')->where('department', $department_id)->delete();
            }
        }
        return Response::json(['flash_message' => $msg, 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Lưu thông tin học vị
     *
     */
    public function listDegree() {
        $degree = Degree::orderBy('id', 'DESC')->get();
        $result = [];
        foreach ($degree as $degree) {
            // dd($user_role);
            $attrs = $degree->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($degree->{$attr});
            }
            $result[] = $data;
        }
        return Response::json(['data' => $result]);
    }

    public function indexDegree() {
        return view('admin.doctordegree');
    }

    /**
     * Lưu thông tin học vị
     *
     */
    public function storeDegree(DegreeRequest $request) {
        $degree = new Degree();
        $degree->name = $request->name;
        $degree->save();

        return Response::json(['flash_message' => 'Đã thêm học vị!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện ra thông tin học vị
     *
     */
    public function showDegree($id) {
        $degree = Degree::findOrFail($id);
        $result = [];
        $attrs = $degree->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($degree->{$attr});
        }
        return Response::json($result);
    }

    /**
     * Cập nhật thông tin học vị
     *
     */
    public function updateDegree($id, DegreeRequest $request) {
        if ($request->isMethod('patch')) {
            $degree = Degree::findOrFail($id);
            $degree->name = $request->name;
            $degree->save();

            return Response::json(['flash_message' => 'Đã cập nhật thông tin học vị!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $degree = Degree::findOrFail($id);
            $result = [];
            $attrs = $degree->getAttributes();
            foreach (array_keys($attrs) as $attr) {
                $result[$attr] = e($degree->{$attr});
            }
            return Response::json($result);
        }
    }

    /**
     * Xóa học vị
     *
     */
    public function destroyDegree(DegreeRequest $request) {
        if (is_string($request->ids))
            $degree_ids = explode(' ', $request->ids);

        foreach ($degree_ids as $degree_id) {
            if ($degree_id != NULL)
                Degree::findOrFail($degree_id)->delete();
        }
        return Response::json(['flash_message' => 'Đã xóa học vị!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Lưu thông tin chức vụ 
     *
     */
    public function listOffice() {
        $office = Office::orderBy('id', 'DESC')->get();
        $result = [];
        foreach ($office as $office) {
            // dd($user_role);
            $attrs = $office->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($office->{$attr});
            }
            $position = DB::table('position')->where('id', $office->position_id)->first();
            $data['position_name'] = $position->name;
            $result[] = $data;
        }
        return Response::json(['data' => $result]);
    }

    public function indexOffice() {
        return view('admin.doctoroffice');
    }

    /**
     * Lưu thông tin chức vụ 
     *
     */
    public function storeOffice(OfficeRequest $request) {
        $office = new Office();
        $office->name = $request->name;
        $office->position_id = $request->position_id;
        $office->save();

        return Response::json(['flash_message' => 'Đã thêm chức vụ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện ra thông tin chức vụ 
     *
     */
    public function showOffice($id) {
        $office = Office::findOrFail($id);
        $result = [];
        $attrs = $office->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($office->{$attr});
        }
        return Response::json($result);
    }

    /**
     * Cập nhật thông tinchức vụ 
     *
     */
    public function updateOffice($id, DegreeRequest $request) {
        if ($request->isMethod('patch')) {
            $office = Office::findOrFail($id);
            $office->name = $request->name;
            $office->save();

            return Response::json(['flash_message' => 'Đã cập nhật thông tin chức vụ!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $office = Office::findOrFail($id);
            $result = [];
            $attrs = $office->getAttributes();
            foreach (array_keys($attrs) as $attr) {
                $office[$attr] = e($office->{$attr});
            }
            return Response::json($result);
        }
    }

    /**
     * Xóa chức vụ 
     *
     */
    public function destroyOffice(DegreeRequest $request) {
        if (is_string($request->ids))
            $ofice_ids = explode(' ', $request->ids);

        foreach ($ofice_ids as $ofice_id) {
            if ($ofice_id != NULL)
                Office::findOrFail($ofice_id)->delete();
        }
        return Response::json(['flash_message' => 'Đã xóa chức vụ!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Lưu thông tin phòng
     *
     */
    public function listRoom() {
        $room = Room::orderBy('id', 'DESC')->get();
        $result = [];
        foreach ($room as $room) {
            // dd($user_role);
            $attrs = $room->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($room->{$attr});
            }

            $result[] = $data;
        }
        return Response::json(['data' => $result]);
    }

    public function indexRoom() {
        return view('admin.room');
    }

    /**
     * Lưu thông tin phòng
     *
     */
    public function storeRoom(RoomRequest $request) {


        $ApiManagement = new ApiManagement();
        $department = $ApiManagement->stripVN(DB::table('departments')
                        ->where('id', $request->department)->first()->name);
        $room = $ApiManagement->stripVN($request->name);
        $om2m = $ApiManagement->ApiAddRoom($department, $room);

        if ($om2m['flag'] == 1) {
            $room = new Room();
            $room->name = $request->name;
            $room->room_number = $request->room_number;
            $room->department = $request->department;
            $room->save();
        }

        return Response::json(['flash_message' => $om2m['msg'], 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện ra thông tin phòng
     *
     */
    public function showRoom($id) {
        $room = Room::findOrFail($id);
        $result = [];
        $attrs = $room->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($room->{$attr});
        }
        return Response::json($result);
    }

    /**
     * Cập nhật thông tinphòng
     *
     */
    public function updateRoom($id, DegreeRequest $request) {
        if ($request->isMethod('patch')) {
            $room = Room::findOrFail($id);
            $room->name = $request->name;
            $room->room_number = $request->room_number;
            $room->department = $request->department;
            $room->save();

            return Response::json(['flash_message' => 'Đã cập nhật thông tin chức vụ!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $room = Room::findOrFail($id);
            $result = [];
            $attrs = $room->getAttributes();
            foreach (array_keys($attrs) as $attr) {
                $room[$attr] = e($room->{$attr});
            }
            return Response::json($result);
        }
    }

    /**
     * Xóa phòng
     *
     */
    public function destroyRoom(DegreeRequest $request) {
        $ApiManagement = new ApiManagement();
        if (is_string($request->ids))
            $room_ids = explode(' ', $request->ids);

        foreach ($room_ids as $room_id) {
            if ($room_id != NULL) {
                $Room = DB::table('user_room')
                                ->where('id', $room_id)->first();
                $department_id = $Room->department;
                $room = $ApiManagement->stripVN($Room->name);
                $department = DB::table('departments')->where('id', $department_id)->first()->name;
                $department = $ApiManagement->stripVN($department);
                $om2m = $ApiManagement->ApiRemoveRoom($department, $room);

                if ($om2m['flag'] == 0) {
                    $msg = $om2m['msg'];
                    break;
                }
                Room::findOrFail($room_id)->delete();
            }
        }
        return Response::json(['flash_message' => 'Đã xóa phòng!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * loại đơn xét nghiệm manage
     *
     */
    public function listMedicalTestType() {
        $MedicalTestTypes = MedicalTestType::orderBy('id', 'DESC')->get();
        $result = [];
        foreach ($MedicalTestTypes as $MedicalTestType) {
            // dd($user_role);
            $attrs = $MedicalTestType->getAttributes();

            $data = [];
            foreach (array_keys($attrs) as $attr) {
                $data[$attr] = e($MedicalTestType->{$attr});
            }
            $data['khoa'] = DB::table('departments')->where('id', $MedicalTestType->khoa)->first()->name;
            $result[] = $data;
        }
        return Response::json(['data' => $result]);
    }

    public function indexMedicalTestType() {
        return view('admin.MedicalTestType');
    }

    /**
     * Lưu thông tin loại đơn xét nghiệm
     *
     */
    public function storeMedicalTestType(MedicalTestTypeRequest $request) {
        $MedicalTestType = new MedicalTestType();
        $MedicalTestType->name = $request->name;

        $MedicalTestType->khoa = $request->khoa;
        $MedicalTestType->phongban = $request->room_number;
        $MedicalTestType->save();

        return Response::json(['flash_message' => 'Đã thêm loại đơn xét nghiệm!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Hiện ra thông tin loại đơn xét nghiệm
     *
     */
    public function showMedicalTestType($id) {
        $MedicalTestType = MedicalTestType::findOrFail($id);
        $result = [];
        $attrs = $MedicalTestType->getAttributes();
        foreach (array_keys($attrs) as $attr) {
            $result[$attr] = e($MedicalTestType->{$attr});
        }
        return Response::json($result);
    }

    /**
     * Cập nhật thông tin loại đơn xét nghiệm
     *
     */
    public function updateMedicalTestType($id, MedicalTestTypeRequest $request) {
        if ($request->isMethod('patch')) {
            $MedicalTestType = MedicalTestType::findOrFail($id);
            $MedicalTestType->name = $request->name;
            $MedicalTestType->khoa = $request->khoa;
            $MedicalTestType->phongban = $request->room_number;

            $MedicalTestType->save();

            return Response::json(['flash_message' => 'Đã cập nhật thông tin loại đơn xét nghiệm!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $MedicalTestType = MedicalTestType::findOrFail($id);
            $result = [];
            $attrs = $MedicalTestType->getAttributes();
            foreach (array_keys($attrs) as $attr) {
                $result[$attr] = e($MedicalTestType->{$attr});
            }
            return Response::json($result);
        }
    }

    /**
     * Xóa loại đơn xét nghiệm
     *
     */
    public function destroyMedicalTestType(MedicalTestTypeRequest $request) {
        if (is_string($request->ids))
            $MedicalTestType_ids = explode(' ', $request->ids);

        foreach ($MedicalTestType_ids as $MedicalTestType_id) {
            if ($MedicalTestType_id != NULL)
                MedicalTestType::findOrFail($MedicalTestType_id)->delete();
        }
        return Response::json(['flash_message' => 'Đã xóa loại đơn xét nghiệm!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Role management
     *
     */
    public function indexRole() {
        return view('admin.role', [
            'permissions' => Permission::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Lấy ra danh sách role
     *
     */
    public function listRole() {

        $roles = $this->role_mng->getListOfRole();
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
    public function showRole($id) {

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
    public function storeRole(RoleRequest $request) {
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        $role_id = $role->id;

        $permissions = $request->permissions;
        for ($i = 0; $i < count($permissions); $i++) {
            if (isset($permissions[$i])) {
                $this->role_mng->addPermissionForRole($role_id, $permissions[$i]);
            }
        }

        return Response::json(['flash_message' => 'Đã thêm role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Sửa đổi, update thông tin role
     *
     */
    public function updateRole(RoleRequest $request, $id) {
        if ($request->isMethod('patch')) {
            $this->role_mng->editRole($id, $request->name, $request->description);

            $this->role_mng->deletePermissionOfRole($id);

            $permissions = $request->permissions;

            for ($i = 0; $i < count($permissions); $i++) {
                if (isset($permissions[$i])) {
                    $this->role_mng->addPermissionForRole($id, $permissions[$i]);
                }
            }

            return Response::json(['flash_message' => 'Đã cập nhật thông tin role!', 'message_level' => 'success', 'message_icon' => 'check']);
        } else {
            $role = $this->role_mng->getInfoOfRole($id);
            if (!$role) {
                return Response::json([]);
            }
            $result = [];

            $role_permission = Role_Permission::where('role_id', '=', $id)->select('permission_id')->groupBy('permission_id')->get();
            $permissions = [];
            foreach ($role_permission as $item) {
                $permissions[] = $item->permission_id;
            }
            $result = array(
                "id" => $id,
                "name" => $role->name,
                "description" => $role->description,
                "permissions" => $permissions
            );
            return Response::json($result);
        }
    }

    /**
     * Xóa role
     *
     */
    public function destroyRole(RoleRequest $request) {
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
    public function showDoctorRole($id) {
        $IdRoleOfPatient = RoleManagement::PATIENT_ROLE;
        return view('admin.roledoctor', compact('id', 'IdRoleOfPatient'));
    }

    /**
     * Lấy ra danh sách bác sĩ của role
     *
     */
    public function listUserOfRole($id) {
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
    public function deleteDoctorOfRole(RoleRequest $request) {
        $doctor_ids = $request->doctor_ids;
        $role_id = $request->role_id;
        for ($i = 0; $i < count($doctor_ids); $i++) {
            $this->role_mng->deleteUserRole($role_id, $doctor_ids[$i]);
        }
        return Response::json(['flash_message' => 'Đã xóa thành công bác sĩ trong role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Thêm bác sĩ vào role
     *
     */
    public function addDoctorforRole(Request $request) {
        $doctor_ids = $request->doctor_ids;
        $role_id = $request->role_id;
        for ($i = 0; $i < count($doctor_ids); $i++) {
            $old_user_role = User_Role::where('role_id', '=', $role_id)->where('user_id', '=', $doctor_ids[$i])->count();
            if ($old_user_role <= 0) {
                $this->role_mng->addUserforRole($role_id, $doctor_ids[$i]);
            }
        }

        return Response::json(['flash_message' => 'Đã thêm bác sĩ vào role!', 'message_level' => 'success', 'message_icon' => 'check']);
    }

    /**
     * Đưa ra danh sách các bệnh viên đối tác
     *
     */
    public function indexHospital() {
        return view('admin.hospital');
    }

    public function listHospital() {
        $hospital_data = Hospital::orderBy('id', 'DESC')->get();
        return Response::json(['data' => $hospital_data]);
    }

    public function showHospital($id) {
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
    public function addRoleForProvider(Request $request) {
        $role_id = $request->role_id;
        $provider_id = $request->provider_id;

        // dd($role_id);
        // $client = Client::findOrFail($client_id);
        // $client ->role_id = $role_id;
        // $client ->save();

        DB::table('oidcproviders')->where('id', $provider_id)->update([
            'role_id' => $role_id
        ]);
        $provider = DB::table('oidcproviders')->where('id', $provider_id);
        //$provider->role_id = $role_id;
        return Response::json(['flash_message' => 'Đã cập nhật role cho provider!', 'message_level' => 'success', 'message_icon' => 'check']);
        //return $provider->role_id;
    }

}
