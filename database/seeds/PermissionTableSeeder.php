<?php

use Illuminate\Database\Seeder;
use App\Model\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->insert([
        	'id'	=> Permission::TL_PERMISSION,
            'name' => 'khám thể lực',
        ]);

        DB::table('permission')->insert([
        	'id'	=> Permission::NK_PERMISSION,
            'name' => 'khám nội khoa',
        ]);

        DB::table('permission')->insert([
        	'id'	=> Permission::MAT_PERMISSION,
            'name' => 'khám mắt',
        ]);

        DB::table('permission')->insert([
        	'id'	=> Permission::TMH_PERMISSION,
            'name' => 'khám tai mũi họng',
        ]);

        DB::table('permission')->insert([
        	'id'	=> Permission::RHM_PERMISSION,
            'name' => 'khám răng hàm mặt',
        ]);

        DB::table('permission')->insert([
        	'id'	=> Permission::DL_PERMISSION,
            'name' => 'khám da liễu',
        ]);

        DB::table('permission')->insert([
        	'id'	=> Permission::CLS_PERMISSION,
            'name' => 'khám cận lâm sàng',
        ]);

        DB::table('permission')->insert([
        	'id'	=> Permission::TQ_PERMISSION,
            'name' => 'khám tổng quan',
        ]);

        DB::table('permission')->insert([
            'id'    => Permission::VIEW_PERMISSION,
            'name' => 'xem',
        ]);

        DB::table('permission')->insert([
            'id'    => Permission::EDIT_PERMISSION,
            'name' => 'Sửa',
        ]);

        DB::table('permission')->insert([
            'id'    => Permission::DELETE_PERMISSION,
            'name' => 'Xóa',
        ]);

        DB::table('permission')->insert([
            'id'    => Permission::SHARE_PERMISSION,
            'name' => 'Chia sẻ',
        ]);

        DB::table('permission')->insert([
            'id'    => Permission::CREATE_PERMISSION,
            'name' => 'Tạo mới hồ sơ bệnh nhân',
        ]);
    }
}
