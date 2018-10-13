@extends('staff.layout.master')

@section('title')
Phiếu đo dung phế
@stop

@section('content')

@if(1)
<div class="form-group pull-right" >
    <button class="btn btn-default " data-toggle="modal" data-target="#myShare">Chia sẻ</button>
</div>
@endif

<div id="myShare" class="modal fade" role="dialog">
    <div class="modal-dialog" style="z-index:10241;width: 800px" >

        <!-- Modal content-->
        @if(1)
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chia sẻ với</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('doctor-share') }}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                    @foreach($role_data as $item)
                    @if(in_array($item['id'], $roles))
                    <div class="form-group">
                        <label>
                            <input name="role[]" type="checkbox" value="{{ $item['id'] }}" checked="">{{$item['name']}}
                        </label>
                    </div>   
                    @else
                    <div class="form-group">
                        <label>
                            <input name="role[]" type="checkbox" value="{{ $item['id'] }}">{{$item['name']}}
                        </label>
                    </div>
                    @endif
                    @endforeach
                    <input type="hidden" name="resource_id" value="{!!$medical_id!!}" />

                    <div>
                        <button class="btn btn-default" type="submit">Lưu thay đổi</button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        @endif

    </div>
</div>

<div class="col-lg-12  ">
    @if(Session::has('flash_message'))
    <div class="alert alert-danger {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
    </div>
    @elseif(Session::has('flash_message_success'))
    <div class="alert alert-success {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message_success') !!}
    </div>
    @endif
</div>

<form class="form-horizontal" action="{{ route('update-COPD-test-medical-info') }}" enctype="multipart/form-data" method="post">
    <h2 class="col-md-offset-3"> Thông tin bệnh nhân</h2>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Họ tên  :</label>
        <div class="col-md-10">
            <p class="form-control-static" style="font-size: 16px"><?php echo($ten_benh_nhan); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Ngày sinh  :</label>
        <div class="col-md-10">
            <p class="form-control-static" style="font-size: 16px"><?php echo($ngay_sinh); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Hộ khẩu thường trú  :</label>
        <div class="col-md-10">
            <p class="form-control-static" style="font-size: 16px"><?php echo($ho_khau); ?></p>
        </div>
    </div>
    <?php
    $roomID = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->phongban;
    $room = DB::table('user_room')->where('id', $roomID)->first();
    $roomName = $room->name;
    $roomNumber = $room->room_number;
    ?>
    <h2  class="col-md-offset-1">Danh sách các thiết bị ở phòng <?= $roomName . ' (' . $roomNumber . ')' ?></h2>

    <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDevice">test</button>-->
    <div id="divice-list">

    </div>

     <h2  class="col-md-offset-2">Cập nhật dữ liệu từ thiết bị di động</h2>
     

    <div class="form-group">
     <div class="col-md-offset-1 col-md-7">
             <button type="button" class="btn btn-primary form-control" onclick="getDataFromMobile()">nhận dữ liệu</button>
    

        </div></div>
     <br>
    <h2 class="col-md-offset-3">Kết quả Đo phế dung phổi</h2>
    <div id = "theluc" class="">
        <div class="form-group">
            <label for="input_FVC" class="col-md-2 control-label">FVC :</label>
            <div class="col-md-6">
                <input type="text" name="FVC" class="form-control" id="input_FVC" value="{{$FVC}}" >
            </div>
        </div>
        <div class="form-group">
            <label for="input_FEV1" class="col-md-2 control-label">FEV1 :</label>
            <div class="col-md-6">
                <input type="text" name="FEV1" class="form-control" id="input_FEV1" value="{{$FEV1}}" >
            </div>
        </div>
        <div class="form-group">
            <label for="input_PEF" class="col-md-2 control-label">PEF :</label>
            <div class="col-md-6">
                <input type="text"  name="PEF" class="form-control" id="input_PEF" value="{{$PEF}}" >
                <?php
                $room = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->phongban;
                ?>
                <input type="hidden" name="room" value="<?= $room ?>" >
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDevice" tabindex="-1" role="dialog" aria-labelledby="myTestLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button onclick="check(3)" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Máy test</h4>
                </div>
                <div class="modal-body">
                    <h1>kết quả</h1>
                    <div class="form-group">
                        <label for="input_FVC"  class="col-md-2 ">Chỉ số 1 :</label>
                        <div class="col-md-6">
                            <span id="chiso1">Đang cập nhật</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input_FVC"  class="col-md-2 ">Chỉ số 2 :</label>
                        <div class="col-md-6">
                            <span id="chiso2">Đang cập nhật</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input_FVC"  class="col-md-2">Chỉ số 3:</label>
                        <div class="col-md-6">
                            <span id="chiso3">Đang cập nhật</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" id="testStep">
                    <button onclick="check(1)" type="button" class="btn btn-warning">Kết nối thiết bị</button>
                    <button onclick="check(2)" type="button" class="btn btn-primary disabled">Đo kết quả</button>
                    <button onclick="check(3)" type="button" class="btn btn-success disabled" data-dismiss="modal">Ngắt thiết bị</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Thoát</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <div class="form-group">
        <input type="hidden" name="medicalID" value="<?php echo($medical_id); ?>">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-md-offset-4">
            <label>Hoàn thiện</label><input type="checkbox" value="1" name="checkSubmit" id="checkSubmit">
            <!--<button type="button" onclick="getApi()" class="btn btn-success btn-lg">Bắt đầu đo kết quả</button>-->
            <button type="submit" class="btn btn-primary btn-lg">Lưu kết quả </button>


        </div>
    </div>

</form>
<script>
//    function load() {
//        $.ajax({
//            type: 'GET',
//            url: '/staff/medical_test_by_api/<?php echo($medical_id); ?>',
//            data: '_token = <?php echo csrf_token() ?>',
//            success: function (data) {
//                document.getElementById('input_FVC').value = data.FVC[0];
//                document.getElementById('input_FEV1').value = data.FEV1[0];
//                document.getElementById('input_PEF').value = data.PEF[0];
//
//            }
//        });
//    }
    function getAPIConnect() {
        var flag = 0;
        $.ajax({
            type: 'GET',
            url: '/staff/get_API_connect/<?= $roomID ?>',
            async: false,
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                console.log(data.msg);
                flag = data.flag;
            }
        });
        console.log(flag);
        return flag;
    }

    function getAPIDisconnect(flag) {
        var flag = 0;
        $.ajax({
            type: 'GET',
            url: '/staff/get_API_disconnect/<?= $roomID ?>',
            async: false,
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                console.log(data.msg);
                flag = data.flag;
            }
        });
        return flag;
    }
    function getAPIResult() {
        $.ajax({
            type: 'GET',
            url: '/staff/get_API_result',
            async: false,
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                document.getElementById('chiso1').innerHTML = data.FVC;
                document.getElementById('chiso2').innerHTML = data.FEV1;
                document.getElementById('chiso3').innerHTML = data.PEF;
            }
        });
    }
//    function getApi() {
//        load();
////        window.setInterval(function () {
////            load();
////        }, 10000);
//    }
    var DV = document.getElementById('divice-list');
    function addDevide() {
        DV = DV + ' <div class="form-group">'
                + '<label for="input_FVC" class="col-md-2 control-label">Thiết bị:</label>'
                + '<div class="col-md-6">'
                + '<button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#modalDevice">test 2</button>'
                + ' </div>'
                + ' </div>';

    }
    function getAPIdevice() {
        $.ajax({
            type: 'GET',
            url: '/staff/get_API_device/<?= $roomID ?>',
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                var DV = document.getElementById('divice-list');
                var i;
                for (i = 0; i < data.device.length; i++) {
                    DV.innerHTML = DV.innerHTML + ' <div class="form-group">'
                            + '<label for="input_FVC" class="col-md-2 control-label">Thiết bị:</label>'
                            + '<div class="col-md-6">'
                            + '<button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#modalDevice">' + data.device[i] + '</button>'
                            + ' </div>'
                            + ' </div>';

                }
            }
        });
    }
    getAPIdevice();
    function check(checkValue) {
        var step = document.getElementById('testStep').children;
        if (checkValue == 1) {
            var flag = getAPIConnect();
            if (flag == 1) {
                console.log('step 1')
                step[0].classList.add("disabled");
                step[1].classList.remove("disabled");
                step[2].classList.remove("disabled");
                step[3].classList.add("disabled");
            } else
                alert("Không thể kết nối tới thiết bị");
        } else if (checkValue == 2) {
            getAPIResult();
            console.log('step 2');
        } else if (checkValue == 3) {
            console.log('step 3');
            var flag = getAPIDisconnect();
            if (flag == 1) {
                step[0].classList.remove("disabled");
                step[1].classList.add("disabled");
                step[2].classList.add("disabled");
                step[3].classList.remove("disabled");
                document.getElementById('chiso1').innerHTML = "Đang cập nhật";
                document.getElementById('chiso2').innerHTML = "Đang cập nhật";
                document.getElementById('chiso3').innerHTML = "Đang cập nhật";
            } else
                alert("Ngắt kết nối thất bại");
        }
    }
    function getDataFromMobile(){
         $.ajax({
            type: 'GET',
            url: '/staff/get_data_mobile/<?=$medical_id?>',
            async: false,
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                console.log(data);
                if(data.flag > 0){
                    document.getElementById('input_FVC').value = data.data.FVC;
                    document.getElementById('input_FEV1').value = data.data.FEV1;
                    document.getElementById('input_PEF').value = data.data.PEF;
                }else{
                    alert("không thể lấy dữ liệu từ thiết bị")
                }

            }
        });
    }
</script>
</script>
@stop