<?php

use Illuminate\Database\Seeder;

class DoctorSettingsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('user_office')->insert([
            'name' => 'Trưởng khoa',
            'position_id' => self::DOCTOR_POSITION
        ]);
        DB::table('user_office')->insert([
            'name' => 'Phó khoa',
            'position_id' => self::DOCTOR_POSITION
        ]);
        DB::table('user_office')->insert([
            'name' => 'Bác sĩ',
            'position_id' => self::DOCTOR_POSITION
        ]);
        DB::table('user_office')->insert([
            'name' => 'Bác sĩ nội chú',
            'position_id' => self::DOCTOR_POSITION
        ]);
        DB::table('user_degree')->insert([
            'name' => 'Giáo sư',
        ]);
        DB::table('user_degree')->insert([
            'name' => 'Tiến sĩ',
        ]);
        DB::table('user_degree')->insert([
            'name' => 'Thạc sĩ',
        ]);
        DB::table('user_degree')->insert([
            'name' => 'Cao học',
        ]);
    }

}
