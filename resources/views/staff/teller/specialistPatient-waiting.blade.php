@extends('staff.layout.master')

@section('title')
Quản lý bệnh nhân
@stop

@section('content')
<script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
<script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <table data-toggle="table" data-url="{{ route('teller-waiting-specialist-list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>

                            <th data-field="id" data-sortable="true">Mã xét nghiệm</th>
                            <th data-field="usersname"  data-sortable="true">Họ tên</th>
                            <th data-field="name"  data-sortable="true">Tên khoa</th>
                            <th data-field="status"  data-formatter="statusFormatter">Trạng thái</th>
                            <th data-field="medical_date"  data-formatter="dateFormatter">Ngày khám</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
var $table = $('#table-detail');


//hàm khi click Kham
function operateFormatter(value, row, index) {
    return [
        // '<div class="pull-left">',
        // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
        // '</div>',
        '</div>'
    ].join('');
}
function dateFormatter(value, row, index) {
    return[
        value.substring(0, 10)
    ]
}
function statusFormatter(value, row, index) {
    if (value == 0) {
        return [
            '<span style="color:red">đã hoàn thành</span>'
        ].join('');
    }
    if (value == 1) {
        return [
            '<span style="color:blue">đang đợi khám sơ bộ</span>'
        ].join('');
    }
    if (value == 2) {
        return [
            '<span style="color:green">đang tiến hành xét nghiệm liên quan</span>'
        ].join('');
    }
     if (value == 3) {
        return [
             '<span style="color:red">đang chờ chẩn đoán</span>'
        ].join('');
    }
}
</script>
@stop