@extends('patient.layout')
@section('title')
Đăng ký xét nghiệm
@stop
@section('content')
@section('content')
<div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Thông tin phiếu <?= $type ?></h4>

            </div>
            <div class="modal-body">
                <div class="form-group form-model">
                    <label for="Tên khách hàng">Tên bệnh nhân</label>
                    <p id="infoShow"><?= Auth::user()->name ?></p></div>
                <div class="form-group form-model">
                    <label for="Tên khách hàng">Khoa</label>
                    <p id="infoShow"><?= $khoa ?></p></div>
                <div class="form-group form-model">
                    <label for="Tên khách hàng">Loại khám</label>
                    <p id="infoShow"><?= $loaikham ?></p></div>
                <div class="form-group form-model">
                    <label for="số điện thoại">Ngày khám</label>
                    <p id="infoShow"><?= $ngay_kham ?></p></div>
                <div class="form-group form-model">
                    <label for="số điện thoại">Ca khám</label>
                    <p id="infoShow"><?= $Shift ?></p></div>

            </div>
            <div class="modal-footer">

                <form  action="/patient/cancel-register" method="post">
                    <div class="form-group">

                        <input type="hidden" name="don_kham_id" value="<?php echo $don_kham_id; ?>">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">Hủy khám</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

@stop
@stop