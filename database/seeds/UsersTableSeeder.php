<?php

use Illuminate\Database\Seeder;
use App\RBACController\UserManagement;
use App\RBACController\DoctorManagement;
use App\RBACController\PatientManagement;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctorMng = new DoctorManagement();
        $patientMng = new PatientManagement();
        $userMng = new UserManagement();
        $adminMng = new UserManagement();
        for($i = 1; $i<=20; $i++){
            $doctorMng ->addDoctor('Bác Sĩ '.$i, 'bs'.$i.'@gmail.com', hash('sha256', '123456'),[1]);
            $patientMng->addPatient('Bệnh nhân'.$i, 'bn'.$i.'@gmail.com', hash('sha256', '123456'));
            $userMng->addUser('Nhân viên'.$i, 'nv'.$i.'@gmail.com', hash('sha256', '123456'), UserManagement::STAFF_POSITION);
        }
 //        $adminMng->addUser('admin1', 'ad1@gmail.com', hash('sha256', '123456'), UserManagement::ADMIN_POSITION);
    }
}
