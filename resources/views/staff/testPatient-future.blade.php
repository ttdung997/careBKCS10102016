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
                <table data-toggle="table" data-url="{{ route('staff-future-list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>

                        
                            <th data-field="usersname"  data-sortable="true">Họ tên</th>
                            <th data-field="name"  data-sortable="true">loại xét nghiệm</th>
                            <th data-field="medical_date"  data-sortable="true">Ngày đăng kí</th>
                            <th data-field="id"
                                data-formatter="operateFormatter"
                                data-events="operateEvents"
                                ></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTestTable" tabindex="-1" role="dialog" aria-labelledby="myTestLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chi tiết</h4>
            </div>
            <div class="modal-body">
                <table id="table-test-detail" 
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
<script>
    var $table = $('#table-test-detail');
    window.operateEvents = {
        'click .like': function (e, value, row) {

            //alert('Trying to refresh new url ' + value);
            $table.bootstrapTable('refresh', {
                url: '../../staff/testDetail.json/' + value
            });
        },
        'click .remove': function (e, value, row) {
            document.getElementById('medical_id').setAttribute("value", value)
        }
    };

//hàm khi click Kham
    function operateFormatter(value, row, index) {
        return [
            '<a class="remove" href="javascript:void(0)" title="Xóa">',
            '<button class="btn btn-danger" data-toggle="modal" data-target="#removeMedicalApp">Xóa</button>',
            '</a>',
            '</div>'
        ].join('');
    }
    function dateFormatter(value, row, index) {
        return[
            value.substring(0, 10)
        ]
    }
</script>
@stop