@extends('doctor.layout')
@section('title')
Danh sách chẩn đoán
@stop
@section('content')
<style>
    .showButton{
        margin: 10px;
    }
</style>
<script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
<script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default ">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <table data-toggle="table" data-url="{{ route('diagnode-list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>
                            <th data-field="usersname"  data-sortable="true">Họ tên</th>
                            <th data-field="name"  data-sortable="true">Khoa</th>
                            <th data-field="id" data-sortable="true" data-formatter="operateFormatter"
                                >Chẩn đoán</th>
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
                <h4 class="modal-title">Chuẩn đoán</h4>
            </div>

            <form  action="/doctor/examination_end" method="post">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="patientId">
                    <h4>khám sơ bộ</h4>
                    <div id="so_bo" class="form-group"></div>
                    <div id="chan_doan" class="form-group" style="display: none"> </div>
                    <h4>Kết quả xét nghiệm liên quan</h4>
                    <div id="xet_nghiem" class="form-group"></div>
                    <div class="form-group">
                        <h4>Chọn bệnh :</h4>
                        <button id="sickButton" type="button" class="btn btn-success" onclick="openSickModel()">Chẩn đoán bệnh</button>
                    </div>
                    <h4>Ghi chú</h4>
                    <div class="form-group">
                        <textarea class="form-control" name="chan_doan" id="chan_doan" rows="7"></textarea>
                    </div>

                    <input type="hidden" name="sick_name" id="sick_name">
                    <input type="hidden" name="so_bo_submit" id="so_bo_submit">
                    <input type="hidden" name="sick_id" id="sick_id">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="openTestInsertModel()">Điều chỉnh xét nghiệm</button>
                    <button id="SubmitButton" type="submit" class="btn btn-warning">Xác nhận chẩn đoán</button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>

                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="SickModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chọn loại bệnh</h4>
            </div>
            <div class="modal-body">
                <table id="table-sick-detail" 
                       data-toggle="table"
                       data-url=""
                       data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">  
                    <thead>
                        <tr>
<!--                            <th data-field="chapter_name"  data-sortable="true">Tên chương</th>
                            <th data-field="type_name"  data-sortable="true">Tên loại bệnh</th>-->
                            <th data-field="id"  data-sortable="true">Mã bệnh</th>
                            <th data-field="name"  data-sortable="true">Lọại bệnh</th>
                            <th data-field="id"  data-sortable="true" data-formatter="selectFormatter">Chi tiết</th>

                        </tr>
                    </thead>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="TestInsertModel" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Điều chỉnh xét nghiệm</h4>
            </div>
            <form  action="/doctor/test_insert" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="patientId2">
                    <input name = "_token" type = "hidden" value = "<?= csrf_token() ?>">
                    <input type="checkbox" name="Medical[]" checked value="0" class="hidden" />
                    <div id="xet_nghiem_form">

                    </div>
                </div>

                <div class="modal-footer">         
                    <button id="SubmitButton" type="submit" class="btn btn-warning">Thêm xét nghiệm</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="modalTable" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chi tiết</h4>
            </div>
            <div class="modal-body">
                <table id="table-detail" 
                       data-toggle="table"
                       data-url="">
                    <thead>
                        <tr>
                            <th data-field="thong_tin">
                                Xét nghiệm
                            </th>
                            <th data-field="chi_so">
                                Kết quả
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>

    var $table = $('#table-detail');
//hàm khi click Kham
    function operateFormatter(value, row, index) {
        return [
            // '<div class="pull-left">',
            // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
            // '</div>',
            '<div class="">',
            '<button class="btn btn-primary" onclick="openModel(&#39;' + value + '&#39;)">Khám</button>',
            '</div>'
        ].join('');
    }
    function dateFormatter(value, row, index) {
        return[
            value.substring(0, 10)
        ]
    }
    function openModel(i) {
        document.getElementById('patientId').value = i;
        $('#TestModel').modal('show');
        //alert('????');
        $.ajax({
            type: 'GET',
            url: 'getInfoPatient/' + i,
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                document.getElementById('patientId2').value = i;
                $("#so_bo").html(data.so_bo);
                  document.getElementById("so_bo_submit").value=data.so_bo;
                if(data.xet_nghiem == ""){
        				$("#xet_nghiem").html("<span style='color:red'>Không xét nghiệm</span>");
            	}else   $("#xet_nghiem").html(data.xet_nghiem);
                $("#chan_doan").html(data.chan_doan);
                $("#xet_nghiem_form").html(data.xet_nghiem_form);
            }
        });
    }
    function openTestInsertModel() {
        $('#TestInsertModel').modal('show');
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

        var medical_test_type = document.getElementsByClassName("medical_test_type");
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


    function getTestmedical(i) {
        // alert(i);
        $table.bootstrapTable('refresh', {
            url: '../../doctor/testDetailDoctor.json/' + i
        });
    }
    var $sickTable = $('#table-sick-detail');
    function loadSick() {
        console.log('1234');
        $sickTable.bootstrapTable('refresh', {
            url: '/test.json'
        });
    }

    function openSickModel() {
        $('#SickModel').modal('show');
        loadSick();
    }
    function selectFormatter(value, row, index) {
        return [
            // '<div class="pull-left">',
            // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
            // '</div>',
            '<div class="">',
            '<a id="button' + index + '" class="like" onclick="selectSick(&#39;',
            value + '&#39;,',
            '&#39;' + row.name + '&#39;,' + index + ')"',
            '" title="Khám" target="_blank">',
            '<button class="btn btn-primary">Chọn bệnh</button>',
            '</a>  ',
            '</div>',
        ].join('');
    }
    function selectSick(value, name, index) {
        document.getElementById('sick_name').value = name;
        document.getElementById('sick_id').value = value;
        $('#SickModel').modal('hide');
        //console.log(name);
        document.getElementById("sickButton").innerHTML=name;
        document.getElementById("sickButton").style.color='red';
    }
</script>

@stop