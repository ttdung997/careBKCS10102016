<?php

/**
 * 
 */

namespace App\RBACController;

include 'config.php';
/**
 * class này quản lý Api
 */
class ApiManagement {
    // //DEFINE
    // const PORT = 8080;
    // const HOST = "https://bkcs.om2m.com";

    public function stripVN($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = str_replace(" ", "_", $str);
        return $str;
    }

    public function ApiAddDepartment($department) {
        $curl = curl_init();
        $postData = array(
            "m2m:ae" => array(
                "rn" => $department,
                "api" => $department,
                "rr" => TRUE
            )
        );

        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest",
                "Content-Type: application/json;ty=2"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            $flag = 0;
            $msg = "Kết nối tới dữ liệu thất bại";
        } else {
            $flag = 1;
            $msg = "Đã thêm khoa!";
        }
        $data['msg'] = $msg;
        $data['flag'] = $flag;
        return $data;
    }

    public function ApiRemoveDepartment($department) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/" . $department,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest",
                "Content-Type: application/json;ty=2"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            $flag = 0;
            $msg = "Kết nối tới dữ liệu thất bại";
        } else {
            $flag = 1;
            $msg = "Đã xóa khoa!";
        }
        $data['msg'] = $department;
        $data['flag'] = $flag;
        return $data;
    }

    public function ApiAddRoom($department, $room) {
        $curl = curl_init();
        $postData = array(
            "m2m:cnt" => array(
                "rn" => $room,
                "lbl" => 'room',
            )
        );

        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/" . $department,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest",
                "Content-Type: application/json;ty=3"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            $flag = 0;
            $msg = "Kết nối tới dữ liệu thất bại";
        } else {
            $flag = 1;
            $msg = "Đã thêm phòng!";
        }
        $data['msg'] = $msg;
        $data['flag'] = $flag;
        return $data;
    }

    public function ApiRemoveRoom($department, $room) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/" . $department . "/" . $room,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest",
                "Content-Type: application/json;ty=3"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        if ($err) {
            $flag = 0;
            $msg = "Kết nối tới dữ liệu thất bại";
        } else {
            $flag = 1;
            $msg = "Đã thêm phòng!";
        }
        $data['msg'] = $msg;
        $data['flag'] = $flag;
        return $data;
    }

    public function ApiGetDevice($department, $room) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/.$department./.$room.?rcn=6",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        if ($err) {
            $msg = "cURL Error #:" . $err;
        } else {
            $xml = simplexml_load_string($response);
            //$device[] = $xml->ch[0]->attributes()->val[0];
            //$msg= $response;
            $device[] = 'máy 1';
            $device[] = 'máy 2';
        }
        $data['msg'] = $msg;
        $data['device'] = $device;
        return $data;
    }

    public function ApiConnect($department, $room, $addr, $MACAddr, $port) {
        // print_r(HOST);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/SOICT?op=dtls_start_client&ipaddr=192.168.0.101&macaddr=0:12:4b:0:6:15:a9:74&room=ROOM_405&department=SOICT&port=20000&data=1",
            // CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/SOICT?op=dtls_start_client&ipaddr=".$addr."&macaddr=".$MACAddr.":&room=".$room."&department=".$department."&port=".$port."&data=1",
           
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest"
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            $msg = "cURL Error #:" . $err;
            $flag = 0;
        } else {
            if (strpos($response, 'error') == false) {
                $msg = "đã kết nối ";
                $flag = 1;
            } else {
                $msg = "Lỗi kết nối thiết bị";
                $flag = 0;
            }
        }
        $data['msg'] = $msg;
        $data['flag'] = $flag;
        return $data;
    }

    public function ApiDisconnect($department, $Addr) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/SOICT?op=dtls_stop_client&ipaddr=om2m.com&port=20000",
            // CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/SOICT?op=dtls_stop_client&ipaddr=".$Addr."&port=".$port,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $msg = "cURL Error #:" . $err;
            $flag = 0;
        } else {
            //$msg= $response;
            if (strpos($response, 'error') == false) {
                $msg = "đã ngắt kết nối";
                $flag = 1;
            } else {
                $msg = "Lỗi kết nối thiết bị khi ngắt";
                $flag = 0;
            }
        }
        $data['msg'] = $msg;
        $data['flag'] = $flag;
        return $data;
    }

    public function ApiResult($department, $port, $addr) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT
            . "/~/mn-cse/mn-name/SOICT?"
            . "op=current_pulse&ipaddr=" . $addr . "&port=" . $port,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $msg = "cURL Error #:" . $err;
        } else {
            //$msg= $response;
            $xml = simplexml_load_string($response);
            $FVC = $xml->int[0]->attributes()->val[0];
            $FEV1 = $xml->int[1]->attributes()->val[0];
            $PEF = $xml->int[2]->attributes()->val[0];
        }
        $data['FVC'] = $FVC;
        $data['FEV1'] = $FEV1;
        $data['PEF'] = $PEF;
        return $data;
    }
    public function ApiTemResult($department, $port, $addr) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/SOICT?op=dtls_data&ipaddr=om2m.com&port=20000&data=1",
            // CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/SOICT?op=dtls_data&ipaddr=".$addr."&port=".$port."&data=1",
            
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $msg = "cURL Error #:" . $err;
        } else {
            //$msg= $response;
            $xml = simplexml_load_string($response);
            $tem = $xml->int[0]->attributes()->val[0];
        }
        $data['tem'] = $tem;
        return $data;
    }

    public function ApiInfomation() {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/CA?op=list_dev_6lbr&ipaddr=[bbbb::100]",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $msg = "cURL Error #:" . $err;
        } else {
            $json = json_decode($response, true);

            return $json;
        }
    }

    public function ApiMedicalTest() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT => PORT,
            CURLOPT_URL => HOST . ":" . PORT . "/~/mn-cse/mn-name/PULSE?op=currentPulse",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "origin: " . HOST . ":" . PORT,
                "user-agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
                "x-m2m-origin: admin:admin",
                "x-requested-with: XMLHttpRequest"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $msg = "cURL Error #:" . $err;
            $FVC = 0;
            $FEV1 = 0;
            $PEF = 0;
        } else {
            //$msg= $response;
            $xml = simplexml_load_string($response);
            $FVC = $xml->int[0]->attributes()->val[0];
            $FEV1 = $xml->int[1]->attributes()->val[0];
            $PEF = $xml->int[2]->attributes()->val[0];
        }
        $data['FVC'] = $FVC;
        $data['FEV'] = $FEV1;
        $data['PEF'] = $PEF;
        return $data;
    }

}

?>