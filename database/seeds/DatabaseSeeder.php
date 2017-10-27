<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $this->call(PositionTableSeeder::class);
//	$this->call(PermissionTableSeeder::class);
//	$this->call(DepartmentsTableSeeder::class);
//	$this->call(RolesTableSeeder::class);
//	$this->call(RolePermissionTableSeeder::class);
//        $this->call(UsersTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);   
    }
}
