@extends('doctor.layout')
@section('title')
Danh sách chờ khám
@stop
@section('content')
<script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
<script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<style>
    .buttonSelete button{
        margin-left: 4px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <table data-toggle="table" data-url="{{ route('list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>
                            <th data-field="usersname"  data-sortable="true">Họ tên</th>
                            <th data-field="name"  data-sortable="true">Khoa</th>
                            <th data-field="id" data-sortable="true" data-formatter="operateFormatter"
                                >Khám bệnh</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="TestModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Khám sơ bộ</h4>
            </div>

            <form  action="/doctor/examination_begin" method="post">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="patientId">
                    <h4>khám sơ bộ</h4>
                    <div class="form-group">
                        <textarea class="form-control" name="so_bo" id="so_bo" rows="7"></textarea>
                    </div>
                    
                    <h4>Các loại xét nghiệm cần làm</h4>  
                    <div class="hidden">
                        <input type="checkbox" checked name="Medical[]" value="0"  id="noTest" />
                        <span style="color: red">không xét nghiệm</span>
                    </div>
                    <?php
                    $MedicalTestType = DB::table('medical_test_type')->get();
                    foreach ($MedicalTestType as $MedicalTestType) {
                        ?>
                        <div class="form-group medical_test_type">

                            <input type="checkbox" name="Medical[]" value="<?= $MedicalTestType->id ?>" class="testAble" />
                            <label for="cheese"><?= $MedicalTestType->name ?></label>
                        </div>
                        <br />
                        <?php
                    }
                    ?>
                    <input name="medical_date" type="date" style="display: none" value="<?= \Carbon\Carbon::now()->toDateString() ?>" class="form-control">

                </div>

                <div class="modal-footer">
                    <button type="button" onclick="submitCheck()"   data-toggle="modal" data-target="#ConfirmModel" class="btn btn-warning">Đăng ký xét nghiệm</button>
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
                                    <label for="Tên khách hàng">Khám sơ bộ</label>
                                    <p><span id="S_so_bo"></span></p></div>
                                <div class="form-group form-model">
                                    <label for="số điện thoại">Các loại xét nghiệm</label>
                                    <p id="medical_test_type_check"></p></div>
                                <div class="form-group form-model">
                                    <label for="số điện thoại">Ngày khám</label>
                                    <p id="medical_date_check"></p></div>
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
//hàm khi click Kham
    function operateFormatter(value, row, index) {
        if (index == 0) {
            return [
                '<div class="buttonSelete">',
                '<button class="btn btn-primary" onclick="openModel(&#39;' + value + '&#39;)">Khám</button>',
                '<button id="button' + index + '" class="btn btn-danger "  onclick="next(' + index + ')">bỏ qua</button>',
                '</a>  ',
                '</div>'
            ].join('');
        } else {
            return [
                '<div class="buttonSelete">',
                '<button class="btn btn-primary disabled" id="nut' + index + '" onclick="openModel(&#39;' + value + '&#39;)">Khám</button>',
                '<button id="button' + index + '" class="btn btn-danger hidden"  onclick="next(' + index + ')">bỏ qua</button>',
                '</a>  ',
                '</div>'
            ].join('');
        }
    }
    function dateFormatter(value, row, index) {
        return[
            value.substring(0, 10)
        ]
    }
    function openModel(i) {
        document.getElementById('patientId').value = i;
        $('#TestModel').modal('show');
    }
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
        var text = document.getElementById("so_bo").value;
        document.getElementById('S_so_bo').innerHTML = text;
        var flag = 0;
        var medical_test_type = document.getElementsByClassName("medical_test_type");
        var i;
        var txt = "";
        for (i = 0; i < medical_test_type.length; i++) {
            if (medical_test_type[i].childNodes[1].checked == true)
                txt = txt + "<span style='color:blue'>" + medical_test_type[i].childNodes[3].textContent + "</span><br>";
        }

        if (txt == "") {
            txt = "<span style='color:red'>Không xét nghiệm</span>"
        }
        document.getElementById('medical_test_type_check').innerHTML = txt;

        var todaysDate = new Date();
        todaysDate = formatDate(todaysDate);
        var date = document.getElementsByName("medical_date")[0].value;
        if (date >= todaysDate) {
            document.getElementById("medical_date_check").textContent = date;
        } else {
            document.getElementById("medical_date_check").innerHTML = "<span style='color:red'>NGÀY KHÁM PHẢI TRONG TƯƠNG LAI</span>";
            flag = 1;

        }

        if (flag === 1)
            document.getElementById("SubmitButton").disabled = true;
        else
            document.getElementById("SubmitButton").disabled = false;
    }
    function next(index) {
        var number = index + 1;
        document.getElementById("nut" + number).classList.remove("disabled");
        document.getElementById("button" + number).classList.remove("hidden");
        document.getElementById("button" + index).classList.remove("btn-danger");
        document.getElementById("button" + index).classList.add("btn-success");
        document.getElementById("button" + index).innerHTML = "Đang đợi";
    }
</script>

@stop