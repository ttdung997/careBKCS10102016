<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
        	'name'	=> 'Nội Khoa',
            'description' => 'Có chức năng đặc biệt',
        ]);

        DB::table('departments')->insert([
        	'name'	=> 'Ngoại khoa',
            'description' => 'Cũng có chức năng đặc biệt',
        ]);
    }
}
