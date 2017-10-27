@extends('staff.layout.master')
@section('title')
Xin chào {{ Auth::user()->name }}
@stop

@section('css')

@endsection

@section('content')
<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$chucvu = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->chucvu;
//kiểm tra xem có phải lễ tân
if ($chucvu == 11) {
    ?>
    <div>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Thiết lập hệ thống</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <h4>Đây là chức năng giúp thiết lập một số thao tác về sử lý hồ sơ,cụ thể như sai</h4>
                        <h4>1>: <span>Xóa các hồ sơ thừa trong hệ thống</span> </h4>
                        <h4>2>: <span>Chuyển ca và ngày cho các hồ sơ chưa hoàn thiện</span></h4>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center">
                    <button style="width: 50%" id="settingButton" class="btn btn-primary" onclick="settingMedical()" >Thiết lập</button>
                </div>
            </div>
        </div>
    </div>
    <a href="settingMedical"></a>
   
    <script>
        function settingMedical() {
            $.ajax({
                type: 'GET',
                url: 'settingMedical',
                data: '_token = <?php echo csrf_token() ?>',
                success: function (data) {
                    console.log('đã gửi ajax');
                }
            });
        }
        document.getElementById('settingButton').click();
    </script>
<?php } ?>
@stop