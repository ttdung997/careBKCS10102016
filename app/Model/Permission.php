<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    const TL_PERMISSION = 1; // quyền khám thể lực
    const NK_PERMISSION = 2; //quyền khám nội khoa
    const MAT_PERMISSION = 3; //quyền khám mắt
    const TMH_PERMISSION = 4; //quyền khám tai mũi họng
    const RHM_PERMISSION = 5; //quyền khám răng hàm mặt
    const DL_PERMISSION = 6;  //quyền khám da liễu
    const CLS_PERMISSION = 7; //quyền khám cận lâm sàng
    const TQ_PERMISSION = 8;  //quyền khám tổng quan
    const VIEW_PERMISSION = 9; //Quyền xem hồ sơ bệnh nhân
    const EDIT_PERMISSION = 10; //quyền sửa hồ sơ bệnh nhân
    const DELETE_PERMISSION = 11; //quyền xóa hồ sơ bệnh nhân
    const SHARE_PERMISSION = 12; //quyền chia sẻ hồ sơ bệnh nhân
    const CREATE_PERMISSION = 13; //quyền tạo mới hồ sơ bệnh nhân

	protected $table ='permission';
    protected $fillable = [
        'name', 'cate'
    ];

    public function user_Permission(){
        return $this->hasMany('App\Model\User_Permission');
    }

    public function role_Permission(){
        return $this->hasMany('App\Model\Role_Permission');
    }

}
