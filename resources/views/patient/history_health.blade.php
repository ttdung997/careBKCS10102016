@extends('patient.layout')
@section('title')
Sổ khám sức khỏe
@stop
@section('content')

<script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
<script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>

<div class="form-group pull-right" >
    <button class="btn btn-default " data-toggle="modal" data-target="#myShare">Chia sẻ</button>
</div>

<div class="col-lg-12  ">
    @if(Session::has('flash_message'))
    <div class="alert alert-danger {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
    </div>
    @elseif(Session::has('flash_message_success'))
    <div class="alert alert-success {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message_success') !!}
    </div>
    @endif
</div>

<div id="myShare" class="modal fade" role="dialog">
    <div class="modal-dialog" style="z-index:10241;width: 800px" >

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chia sẻ với</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="{{ route('patient-share') }}" method="POST">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
                    @foreach($role_data as $item)
                    @if(in_array($item['id'], $roles))
                    <div class="form-group">
                        <label>
                            <input name="role[]" type="checkbox" value="{{ $item['id'] }}" checked="">{{$item['name']}}
                        </label>
                    </div>   
                    @else
                    <div class="form-group">
                        <label>
                            <input name="role[]" type="checkbox" value="{{ $item['id'] }}">{{$item['name']}}
                        </label>
                    </div>
                    @endif
                    @endforeach
                    <input type="hidden" name="resource_id" value="" />

                    <div>
                        <button class="btn btn-default" type="submit">Lưu thay đổi</button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table id="table" data-toggle="table"
               data-url="{{ route('history-json') }}">
            <thead>
                <tr>

                    <th data-field="name"
                        data-formatter="nameFormatter">Tên loại khám</th>
                    <th data-field="medical_date"
                        data-formatter="dateFormatter">Ngày khám</th>
                    <th data-field="status" data-formatter="statusFormatter">Trạng thái</th>
                    <th data-field="id"
                        data-formatter="operateFormatter"
                        data-events="operateEvents">Xem chi tiết</th>
                </tr>
            </thead>
        </table>
    </div>



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
        var $table = $('#table-detail');
        var $testTable = $('#table-test-detail');

        window.operateEvents = {
            'click .like': function (e, value, row) {
                //alert('Trying to refresh new url ' + value);
                $table.bootstrapTable('refresh', {
                    url: '../../patient/detail.json/' + value
                });
            },
            'click .like2': function (e, value, row) {

                //alert('Trying to refresh new url ' + value);
                $testTable.bootstrapTable('refresh', {
                    url: '../../patient/testDetail.json/' + value
                });
            },
            'click .remove': function (e, value, row) {
                document.getElementById('medical_id').setAttribute("value", value)
            }
        };
        function nameFormatter(value, row, index) {
            return [
                '<span>Khám sức khỏe</span>',
            ].join('');
        }
        function operateFormatter(value, row, index) {
            return [
                // '<div class="pull-left">',
                // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
                // '</div>',
                '<div class="">',
                '<a class="like" href="javascript:void(0)" title="Like">',
                '<button class="btn btn-primary" data-toggle="modal" data-target="#modalTable">Xem</button>',
                '</a>  ',
                '<a class="remove" href="javascript:void(0)" title="Xóa">',
                '<button class="btn btn-danger" data-toggle="modal" data-target="#removeMedicalApp">Xóa</button>',
                '</a>',
                '</div>'
            ].join('');
        }
        function statusFormatter(value, row, index) {
            if (value == 0) {
                return [
                    '<span style="color:red">đã hoàn thành</span>'
                ].join('');
            }
            if (value == 1) {
                return [
                    '<span style="color:blue">đang đợi khám</span>'
                ].join('');
            }
            if (value == 2) {
                return [
                    'đang chờ kết quả'
                ].join('');
            }
        }
        function operateFormatter2(value, row, index) {
            return [
                // '<div class="pull-left">',
                // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
                // '</div>',
                '<div class="">',
                '<a class="like2" href="javascript:void(0)" title="Like2">',
                '<button class="btn btn-primary" data-toggle="modal" data-target="#modalTestTable">Xem</button>',
                '</a>  ',
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