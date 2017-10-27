<?php

use Illuminate\Database\Seeder;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('position')->insert([
            'id' => 1,
            'name' => 'Bệnh nhân',
            'description' => 'Người đến khám bệnh trong bệnh viện'
        ]);

        DB::table('position')->insert([
            'id' => 2,
            'name' => 'Bác sĩ',
            'description' => 'Người khám bệnh cho bệnh nhân'
        ]);

        DB::table('position')->insert([
            'id' => 3,
            'name' => 'Nhân viên',
            'description' => 'Người thực hiện các công vụ trong bệnh viện'
        ]);

        DB::table('position')->insert([
            'id' => 4,
            'name' => 'Admin',
            'description' => 'Người quản lý trang của bệnh viện'
        ]);
    }
}
