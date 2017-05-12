<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Share;
use Auth;
use App\OAuth\OAuthorization;

class OAuthController extends Controller
{
    public function postShare(Request $request){
        $oauth = new OAuthorization();
        if($oauth->getLocal()==true){
        	$role = $request ->role;
        	$resource_id = $request ->resource_id;
            $resource_owner = Auth::user()->id;

            Share::where('resource_owner','=',$resource_owner)->delete();

        	for($i = 0; $i < count($role); $i++){
                if(isset($role[$i])){
                    $share = new Share();
                    $share ->resource_owner = $resource_owner;
                    $share ->role_id = $role[$i];
                    $share ->resource_id = $resource_id;
                    $share ->save();
                }
        	}
            return "bạn đã chia sẻ thành công";
        }else{
            return "Bạn không có quyền chia sẻ";
        }
    }

    
}
