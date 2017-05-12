<?php 
namespace App\RBACController;
use App\Model\Share;
/**
* Class này quản lý việc chia sẻ tài nguyên
*/
class ShareManagement
{
	
	function __construct()
	{
		
	}

	/**
	* Lưu thông tin chia sẻ tài nguyên vào bảng share trong cơ sở dữ liệu
	*/
	public function addShare($resource_owner, $roles = array(), $resource_id){
		Share::where('resource_owner','=',$resource_owner)->delete();
		for($i = 0; $i < count($roles); $i++){
            if(isset($roles[$i])){
                $share = new Share();
                $share ->resource_owner = $resource_owner;
                $share ->role_id = $roles[$i];
                $share ->resource_id = $resource_id;
                $share ->save();
            }
	    }
	}


}
 ?>