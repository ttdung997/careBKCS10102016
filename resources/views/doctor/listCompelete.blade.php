@extends('doctor.layout')
@section('title')
Danh sách kết quả
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
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <table data-toggle="table" data-url="{{ route('compelete-list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>
                            <th data-field="usersname"  data-sortable="true">Họ tên</th>
                            <th data-field="name"  data-sortable="true">Khoa</th>
                            <th data-field="medical_date"  data-sortable="true">Ngày khám</th>
                            <th data-field="id" data-sortable="true" data-formatter="operateFormatter"
                                >Kết quả</th>
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
                <h4 class="modal-title">Kết quả khám</h4>
            </div>

            <form  action="/doctor/examination_end" method="post">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" id="patientId">
                    <h4>khám sơ bộ</h4>
                    <div id="so_bo" class="form-group"></div>
                    <h4>Kết quả xét nghiệm liên quan</h4>
                    <div id="xet_nghiem" class="form-group"></div>
                    <h4>Chuẩn đoán</h4>
                    <div id="chan_doan" class="form-group"></div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Quay lại</button>

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
            $("#so_bo").html(data.so_bo);
            $("#xet_nghiem").html(data.xet_nghiem);
            $("#chan_doan").html(data.chan_doan);
        }
    });
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


function getTestmedical(i) {
    // alert(i);
    $table.bootstrapTable('refresh', {
        url: '../../doctor/testDetailDoctor.json/' + i
    });
}
</script>

@stop