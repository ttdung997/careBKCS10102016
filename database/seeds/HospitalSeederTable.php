<?php

use Illuminate\Database\Seeder;

class HospitalSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hospital')->insert([
        	'name'	=> 'Bệnh Viện A',
            'description' => 'Bệnh viện A liên kết vs bệnh viện',
            'role_id' => 1
        ]);
    }
}
