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
                <table data-toggle="table" data-url="{{ route('teller-waiting-test-list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>

                            <th data-field="id" data-sortable="true">Mã xét nghiệm</th>
                            <th data-field="usersname"  data-sortable="true">Họ tên</th>
                            <th data-field="name"  data-sortable="true">loại xét nghiệm</th>
                            <th data-field="register_by"  data-sortable="true" data-formatter="typeFormatter">Kiểu xét nghiệm</th>
                            <th data-field="status" data-sortable="true"  data-formatter="statusFormatter">Trạng thái</th>
                            <th data-field="medical_date" data-sortable="true"  data-formatter="dateFormatter">Ngày khám</th>
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
        '<div class="">',
        '<a class="like" href="../staff/medical_test/',
        value,
        '" title="Xét nghiệm" target="_blank">',
        '<button class="btn btn-primary">Ghi kết quả</button>',
        '</a>  ',
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
            '<span style="color:blue">đang đợi xét nghiệm</span>'
        ].join('');
    }
    if (value == 2) {
        return [
            'đang chờ kết quả'
        ].join('');
    }
}
function typeFormatter(value, row, index) {
    if (value == 2) {
        return [
            '<span style="color:green">Chỉ định</span>'
        ].join('');
    }
    if (value == 1) {
        return [
             '<span style="color:red">Tự nguyện</span>'
        ].join('');
    }
}
</script>
@stop