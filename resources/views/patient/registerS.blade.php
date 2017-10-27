@extends('patient.layout')
@section('title')
Đăng ký khám
@stop
@section('content')
<style>
    .form-group button{
        width: 70%;
    }
</style>
<div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Đăng kí khám chuyên khoa</h4>
            </div>
            <div class="modal-body">
                <?php
                $query = DB::table("medical_specialist_applications")->where("patient_id", Auth::user()->id)->where('status', '<>', 0)->first();
                ?>
                <div class="text-center">
                    <?php if (!$query) { ?>
                        <div class="form-group">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#Mymodel">Bước 1: Đăng kí khám</button>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <button class="btn btn-warning" data-toggle="modal" data-target="#infoModel">Xem thông tin khám</button>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <button class="btn btn-primary <?php if ($query) if ($query->status !== 1) echo "disabled";if (!$query) echo "disabled"; ?>"
                                data-toggle="modal" data-target="#HintModel">Bước 2: Khám sơ bộ</button>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary <?php if ($query) if ($query->status !== 2) echo "disabled";if (!$query) echo "disabled"; ?>"
                                data-toggle="modal" data-target="#HintModel">Bước 3: Làm xét Nghiệm</button>
                    </div>  
                    <div class="form-group">
                        <button class="btn btn-primary <?php if ($query) if ($query->status !== 3) echo "disabled";if (!$query) echo "disabled"; ?>"
                                data-toggle="modal" data-target="#HintModel">Bước 4: Chuẩn Đoán</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="Mymodel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>Đăng kí khám chuyên khoa</h4>
            </div>
            <form action="/patient/registerS" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="chọn sách">Chọn khoa</label>
                        <select class="form-control" name="khoa">
                            <?php
                            $department = DB::table('departments')->get();
                            foreach ($department as $department) {
                                ?>
                                <option value="<?= $department->id ?>"><?= $department->name ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="chọn sách">Chọn loại hình khám</label>
                        <select class="form-control" name="medical_type">
                            <?php
                            //lấy các chức danh bác sĩ có position_id=2
                            $medical_type = DB::table('medical_specialist_type')->get();
                            foreach ($medical_type as $medical_type) {
                                ?>
                                <option value="<?= $medical_type->id ?>"><?= $medical_type->name ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="chọn sách">Chọn Ngày khám</label>
                        <input name="medical_date" type="date" value="<?= \Carbon\Carbon::now()->toDateString() ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="chọn sách">Chọn ca khám</label>
                        <select class="form-control" name="Shift" id="Shift">
                            <option value="1">Buổi sáng</option>
                            <option value="2">Buổi Chiều</option>
                        </select>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="type" value="2">


                </div>
                <div class="modal-footer">
                    <button onclick="SpecialistCheck2()" type="button" class="btn btn-warning" data-dismiss="modal"  data-toggle="modal" data-target="#SpecialistConfirmModel">Đăng ký khám</button>

                    <button type="submit" hidden id="SpecialistButton2"></button>
                </div>
            </form>

        </div>
    </div>
</div>
<div class="modal fade" id="SpecialistConfirmModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>Thông tin đăng kí khám chuyên khoa</h4>
            </div>
            <div class="modal-body">
                <div class="form-group form-model">
                    <label for="Tên khách hàng">Tên bệnh nhân</label>
                    <p><?= Auth::user()->name ?></p></div>
                <div class="form-group form-model">
                    <label for="Tên khách hàng">Chuyên khoa</label>
                    <p id="S_medical_khoa_check"></p></div>
                <div class="form-group form-model">
                    <label for="số điện thoại">Loại Khám</label>
                    <p id="S_medical_type_check"> Khám chuyên khoa</p></div>
                <div class="form-group form-model">
                    <label for="số điện thoại">Ngày Khám</label>
                    <p id="S_medical_date_check"></p></div>
                <div class="form-group form-model">
                    <label for="số điện thoại">Ca khám</label>
                    <p id="S_shift_check"></p></div>

            </div>
            <div class="modal-footer">
                <button id="S_checkButton" class="btn btn-warning" onclick="SpecialistSubmit()">Xác nhận khám</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>

            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="infoModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

                <form  action="/patient/cancel-registerS" method="post">
                    <div>

                        <input type="hidden" name="don_kham_id" value="<?php echo $don_kham_id; ?>">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">Hủy khám</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="removeMedicalApp" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Xóa đơn khám?</h4>
            </div>
            <div class="modal-body">
                <p>Bạn chắc chắn muốn xóa đơn khám này chứ?</p>
            </div>
            <div class="modal-footer">

                <a
                    onclick="event.preventDefault();
                            document.getElementById('remove-medical-form').submit();">

                    <button class="btn btn-danger" id="btn-delete-user">Xóa</button>
                </a>

                <form id="remove-medical-form" action="{{ url('/remove-medical-application') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                    <input type="hidden" id="medical_id" name="medical_id" value="">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="HintModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>Hướng dẫn</h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php
                    if ($query) {
                        if ($query->status == 1)
                            echo "Đến phòng khám " . $phong;
                        if ($query->status == 2)
                            echo "Đến phòng xét nghiệm (<a href='/patient/index'>Chi tiết</a>)";
                        if ($query->status == 3)
                            echo "Quay trở lại phòng khám " . $phong;
                    }
                    ?>
                </p>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<script>

    function formatDate(date) {
        var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

        if (month.length < 2)
            month = '0' + month;
        if (day.length < 2)
            day = '0' + day;

        return [year, month, day].join('-');
    }
    function SpecialistCheck2() {
        var Shift = document.getElementById("Shift");
        var selected = $(Shift).find('option:selected');
        var Shift = selected.text();
        document.getElementById("S_shift_check").textContent = Shift;
        var date = document.getElementsByName('medical_date')[0].value;
        var todaysDate = new Date();
        todaysDate = formatDate(todaysDate);
        if (date >= todaysDate) {
            document.getElementById("S_medical_date_check").textContent = date;
            document.getElementById("S_checkButton").disabled = false;
        } else {
            document.getElementById("S_medical_date_check").innerHTML = "<span style='color:red'>NGÀY KHÁM PHẢI TRONG TƯƠNG LAI</span>";
            document.getElementById("S_checkButton").disabled = true;
        }
        var medical_type = document.getElementsByName('medical_type')[0];
        var medical_type_selected = $(medical_type).find('option:selected');
        var medical_type_name = medical_type_selected.text();
        var khoa = document.getElementsByName("khoa")[0];
        var selected = $(khoa).find('option:selected');
        var khoaname = selected.text();
        document.getElementById("S_medical_khoa_check").textContent = khoaname;
        document.getElementById("S_medical_type_check").textContent = medical_type_name;
    }
    function SpecialistSubmit()
    {

        document.getElementById("SpecialistButton2").click();
    }
</script>
@stop