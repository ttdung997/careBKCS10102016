<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;
use App\RBACController\RoleManagement;


class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$role_mng = new RoleManagement();
//    	$role_mng->addPermissionForRole(RoleManagement::PATIENT_ROLE,Permission::VIEW_PERMISSION);
//    	$role_mng->addPermissionForRole(RoleManagement::STAFF_ROLE,Permission::CREATE_PERMISSION);
    	$role_mng->addPermissionForRole(RoleManagement::DOCTOR_ROLE,Permission::TL_PERMISSION);
        
    }
}
