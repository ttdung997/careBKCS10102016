<?php

use Illuminate\Database\Seeder;
use App\RBACController\RoleManagement;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_mng = new RoleManagement();
        $role_mng ->addRole(RoleManagement::PATIENT_ROLE,'role bệnh nhân','role này là role của các bệnh nhân');
        $role_mng ->addRole(RoleManagement::STAFF_ROLE,'role nhân viên','role này quản lý các nhân viên');
        
    }
}
