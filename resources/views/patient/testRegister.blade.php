@extends('patient.layout')
@section('title')
Đăng ký khám bệnh
@stop
@section('content')


<div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Chọn các loại xét nghiệm</h4>

            </div>

            <form  action="/patient/testRegister" method="post">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="type" value="3">

                    <?php
                    $MedicalTestType = DB::table('medical_test_type')->get();
                    foreach ($MedicalTestType as $MedicalTestType) {
                        ?>
                        <div class="form-group medical_test_type">

                            <input type="checkbox" name="Medical[]" value="<?= $MedicalTestType->id ?>" />
                            <label for="cheese"><?= $MedicalTestType->name ?></label>
                        </div>

                        <br />
                        <?php
                    }
                    ?>
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
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="submitCheck()"  data-toggle="modal" data-target="#ConfirmModel" class="btn btn-warning">Đăng ký xét nghiệm</button>
                </div>
                <div class="modal fade" id="ConfirmModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4>Thông tin đăng kí khám xét nghiệm</h4>
                            </div>
                            <div class="modal-body">
                                <div class="form-group form-model">
                                    <label for="Tên khách hàng">Tên bệnh nhân</label>
                                    <p><?= Auth::user()->name ?></p></div>
                                <div class="form-group form-model">
                                    <label for="số điện thoại">Các loại xét nghiệm</label>
                                    <p id="medical_test_type_check"></p></div>
                                <div class="form-group form-model">
                                    <label for="số điện thoại">Ngày khám</label>
                                    <p id="medical_date_check"></p></div>
                                <div class="form-group form-model">
                                    <label for="số điện thoại">Ca khám</label>
                                    <p id="Shift_check"></p></div>
                                <div class="modal-footer">
                                    <button id="SubmitButton" type="submit" class="btn btn-warning">Xác nhận xét nghiệm</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
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
    function  submitCheck() {

        var medical_test_type = document.getElementsByClassName("medical_test_type");
        var Shift = document.getElementById("Shift");
        var selected = $(Shift).find('option:selected');
        var Shift = selected.text();
        document.getElementById("Shift_check").textContent = Shift;
        var i;
        var txt = "";
        for (i = 0; i < medical_test_type.length; i++) {
            if (medical_test_type[i].childNodes[1].checked == true)
                txt = txt + "<span style='color:blue'>" + medical_test_type[i].childNodes[3].textContent + "</span><br>";
        }
        if (txt == "") {
            txt = "<span style='color:red'>BẠN CHƯA CHỌN XÉT NGHIỆM</span>"
            document.getElementById("SubmitButton").disabled = true;

        } else {
            document.getElementById("SubmitButton").disabled = false;
        }
        document.getElementById('medical_test_type_check').innerHTML = txt;

        var todaysDate = new Date();
        todaysDate = formatDate(todaysDate);
        var date = document.getElementsByName("medical_date")[0].value;
        if (date >= todaysDate) {
            document.getElementById("medical_date_check").textContent = date;
            document.getElementById("SubmitButton").disabled = false;
        } else {
            document.getElementById("medical_date_check").innerHTML = "<span style='color:red'>NGÀY KHÁM PHẢI TRONG TƯƠNG LAI</span>";
            document.getElementById("SubmitButton").disabled = true;
        }

    }
</script>
@stop