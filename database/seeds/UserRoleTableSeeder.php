<?php

use Illuminate\Database\Seeder;
use App\RBACController\RoleManagement;
use App\RBACController\UserManagement;


class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
    	$user_mng = new UserManagement();
    //	$list_patient = $user_mng ->getListUserFollowPosition(UserManagement::PATIENT_POSITION);
    	$docter_patient = $user_mng ->getListUserFollowPosition(UserManagement::DOCTOR_POSITION);
    	$role_mng = new RoleManagement();
        $role_mng-> addUserforRole(RoleManagement::DOCTOR_ROLE,$docter_patient[0]->id);
//    	foreach($list_patient as $patient){
//    		$role_mng-> addUserforRole(RoleManagement::PATIENT_ROLE,$patient->id);
//    	}
//        $list_staff = $user_mng ->getListUserFollowPosition(UserManagement::STAFF_POSITION);
//        foreach($list_staff as $staff){
//            $role_mng ->addUserforRole(RoleManagement::STAFF_ROLE,$staff->id);
//        }

    }
}
