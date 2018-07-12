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

                <h4 class="modal-title">Thông tin phiếu khám</h4>

            </div>
            <div class="modal-body">
                <div class="form-group form-model">
                    <label for="Tên khách hàng">Tên bệnh nhân</label>
                    <p id="infoShow"><?= Auth::user()->name ?></p></div>
                <div class="form-group form-model">
                    <label for="số điện thoại">Ngày xét nghiệm</label>
                    <p id="infoShow"><?= $ngay_xet_nghiem ?></p></div>
                <div class="form-group form-model">
                    <div class="form-group form-model">
                    <label for="số điện thoại">Ca khám</label>
                    <p id="infoShow"><?=$Shift ?></p></div>
                    <label for="số điện thoại">Các loại xét nghiệm</label>
                    <?php foreach($don_xet_nghiem as $don_xet_nghiem){
                        $name = DB::table('medical_test_type')->where('id',$don_xet_nghiem->xetnghiem)->first()->name;
                        ?>
                    <p id="infoShow"><a><?=$name?></a></p>
                    <?php } ?>
                </div>

            </div>
            <div class="modal-footer">

                <form  action="/patient/cancel-testRegister" method="post">
                    <div class="form-group">

                        <input type="hidden" name="user_id" value="<?= Auth::user()->id?>">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">Hủy xét nghiệm</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@stop
@stop