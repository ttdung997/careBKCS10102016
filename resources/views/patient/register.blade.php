@extends('patient.layout')
@section('title')
Đăng ký khám
@stop
@section('content')
<form  action="/patient/register" method="post">
    <div class="form-model">
        <label>Đăng kí khám sức khỏe:</label>

        <label>chọn ngày khám</label>
        <input name="medical_date" type="date" value="<?= \Carbon\Carbon::now()->toDateString() ?>" 
               class="form-control" id="medical_date">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="type" value="1">
         <label>chọn ca khám</label>
         <select class="form-control" name="Shift" id="Shift">
             <option value="1">Buổi sáng</option>
             <option value="2">Buổi Chiều</option>
         </select>
        <button onclick="HealthCheck()" class="form-control mb-2 mr-sm-2 mb-sm-0 btn btn-primary" id="inlineFormInput" type="button"
                data-toggle="modal" data-target="#HealthConfirmModel">Đăng kí</button>
    </div>
    <div class="modal fade" id="HealthConfirmModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4>Thông tin đăng kí khám sức khỏe</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group form-model">
                        <label for="Tên khách hàng">Tên bệnh nhân</label>
                        <p><?= Auth::user()->name ?></p></div>
                    <div class="form-group form-model">
                        <label for="số điện thoại">Ngày khám</label>
                        <p id="medical_date_check"></p></div>
                    <div class="form-group form-model">
                        <label for="số điện thoại">Ca khám</label>
                        <p id="Shift_check"></p></div>
                    <div class="modal-footer">
                        <button id="HealthSubmit" type="submit" class="btn btn-warning">Xác nhận khám</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</form>
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
    function HealthCheck() {
        var date = document.getElementById("medical_date").value;
        var Shift = document.getElementById("Shift");
        var selected = $(Shift).find('option:selected');
        var Shift = selected.text();
        document.getElementById("Shift_check").textContent = Shift;
        var todaysDate = new Date();
        todaysDate = formatDate(todaysDate);
        if (date >= todaysDate) {
            document.getElementById("medical_date_check").textContent = date;
            document.getElementById("HealthSubmit").disabled = false;
        } else {
            document.getElementById("medical_date_check").innerHTML = "<span style='color:red'>NGÀY KHÁM PHẢI TRONG TƯƠNG LAI</span>";
            document.getElementById("HealthSubmit").disabled = true;
        }

    }
    
</script>
@stop