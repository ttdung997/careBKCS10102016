@extends('admin.layout.master')
@section('title')
Danh sách các Requests
@stop

@section('css')
    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Datatables extensions -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.3.2/css/colReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css">
    <style type="text/css">
        td.details-control {
            background: url('{{ asset('public/admin/plugins/datatables/images/details_open.png') }}') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{ asset('public/admin/plugins/datatables/images/details_close.png') }}') no-repeat center center;
        }
    </style>
@endsection

@section('content')
    <script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
            <div class="col-lg-12">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control column_filter" placeholder="Tìm theo Domain" id="input_requestDomain" data-column="requestDomain">
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="col-lg-6 col-lg-offset-3" id="userAlert">

                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading"></div>
                    <div class="panel-body" style="overflow:scroll">
                        <table data-toggle="table" data-url="{{ route('list-as-json-requests') }}" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" id="requestList">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Loại yêu cầu</th>
                                    <th>Domain</th>
                                    <th>Trạng thái</th>
                                    <th>Kết quả</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                        </table>

                        <!-- Accept/Denied modal -->
                        <div class="modal fade" id="handleRequestModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Từ chối yêu cầu</h4>
                                    </div>
                                    <form>
                                        <div class="modal-body">
                                            
                                            <div class="text-center">
                                                <p>Xác nhận từ chối yêu cầu này?</p>
                                                <input type="hidden" id="request_id" name="request_id" value="">
                                                <input type="hidden" id="type_btn_id" name="type_btn_id" value="">
                                            </div>
                                        </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" id="btn-handle-request">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Accept/Denied modal-->

                    </div>
                </div>
            </div>
        </div>
@stop

@section('js')        
    <script type="text/javascript">
    // Advanced searching
    function filterColumn ( i ) {
        $('#requestList').DataTable().column( i+':name' ).search(
                $('#input_'+i+'').val()
        ).draw();
    }

    $(document).ready( function () {
        var baseUrl = $('meta[name="base_url"]').attr('content');
        var requestList = $('#requestList').DataTable( {
            ajax: baseUrl+"/list.json-requests",
            columns: [
            { 
                "visible": false,
                "searchable": false,
                "orderable": false,
                "data": "id"
            },
            { 
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "request_type",
                "name": "requestType",
                "render": function (value){
                    if (value === null)
                    {
                        return "";
                    }else if(value == true)
                    {
                        return "Yêu cầu đi";
                    }
                    else
                        return "Yêu cầu đến";
                }
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "domain",
                "name": "requestDomain"
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "status",
                "name": "requestStatus",
                "render": function (value){
                    if (value === null) return "";
                    else if (value == true)
                    {
                        return "Đã được xử lý";
                    }
                    else
                        return "Chưa được xử lý";
                }
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "isAccept",
                "name": "requestResult",
                "render": function (value) {
                    if (value === null) return "";
                    else if (value == '1')
                    {
                        return "Đã được chấp nhận";
                    }
                    else if (value == '0')
                        return "Đã bị từ chối";
                    else
                        return "";
                }
            },
            {
                "visible": true,
                "searchable": false,
                "orderable": false,
                "data": null,
                "render": function (data, type, row) {
                    var req_typ = row.request_type;
                    var stt = row.status;
                    var valueReturn;
                    
                    /**
                    *   hàm render sẽ get data từ column request_type và status,
                    *   kiểm tra status == true && request_type = false, tức là các yêu cầu đến đã được xử lý.
                    *   thì disabled 2 button của yêu cầu này đi.
                    *   Nếu là yêu cầu đi thì không hiển thị button nào cả.
                    */
                    if (req_typ == false )
                    {
                        if (stt == true)
                        {
                            valueReturn = '<button class="btn btn-success open-delete-user-modal handleRequest" type="button" id="myBtnAccept" name="myBtnAccept" value="myBtnAccept" disabled="true" data-toggle="modal" data-target="#addRole">Accept</button> <button class="btn btn-danger open-edit-user-modal handleRequest" type="button" id="myBtnDenied" name="myBtnDenied" value="myBtnDenied" disabled="true">Denied</button>';
                        }
                        else
                            valueReturn = '<button class="btn btn-success open-delete-user-modal handleRequest" type="button" id="myBtnAccept" name="myBtnAccept" value="myBtnAccept" data-toggle="modal">Accept</button> <button class="btn btn-danger open-edit-user-modal handleRequest" type="button" id="myBtnDenied" name="myBtnDenied" value="myBtnDenied">Denied</button>';
                    }
                    else
                        valueReturn = "";
                    return valueReturn;
                }
                
            }
          ]
        } );

        // Advanced searching
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).attr('data-column') );
        } );

        var userUrl = baseUrl+"/list-requests";

        // xử lý sự kiện khi click vào button "Accept" hoặc "Denied"
        $('#requestList tbody').on('click', '.handleRequest', function () {
            // tùy vào "name" của button mà sẽ xử lý tương ứng
            var type_btn = $(this).val();
            var titleModal = "";    // title của modal.
            var detailModal = ""; // câu hỏi xác nhận hành động.
            if(type_btn == "myBtnAccept")
            {
                titleModal = "Chấp nhận yêu cầu";
                detailModal = "Bạn có chấp nhận yêu cầu không ?";
            }
            else if(type_btn == "myBtnDenied")
            {
                titleModal = "Từ chối yêu cầu";
                detailModal = "Bạn có chắc muốn từ chối yêu cầu này không ?";
            }
            var row = $(this).closest("tr");
            var request = requestList.row(row).data();
            var request_id = request.id;

            $('#handleRequestModal .modal-dialog .modal-content .modal-header h4').text(titleModal);
            $('#handleRequestModal .modal-dialog .modal-content form .modal-body .text-center p').text(detailModal);
            $('#handleRequestModal').modal('show');

            handleRequestByType(request_id, type_btn);
        } );

        // hàm xử lý request theo (id và loại hành động)
        function handleRequestByType(id, action) {
            $('#userAlert').empty();
            $('#request_id').val(id);
            $('#type_btn_id').val(action);
        }

        // hàm xử lý khi admin click vào nút "OK" của hộp thoại hỏi xác nhận.
        $('#btn-handle-request').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var request_ids = $('#request_id').val();
            var type_btn_ids = $('#type_btn_id').val();
            var method_type = "POST";
            var url_handle = "/handle";

            var formData = {
                req_ids: request_ids,
                typ_ids: type_btn_ids
            }

            $.ajax({
                type: method_type,
                url: userUrl + url_handle,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#handleRequestModal').modal('hide');
                    requestList.ajax.reload(null, false);
                    $('#userAlert').append('<div id="flash_message" class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

            $('#myBtnDenied').prop("disabled", true);
        }); // hết hàm xử lý khi click "OK"

        


    });
    
    </script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <!-- Datatables extensions -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="{{  url('public/specify/jszip.min.js') }}"></script>
    <script src="{{  url('public/specify/pdfmake.min.js') }}"></script>
    <script src="{{  url('public/specify/vfs_fonts.js') }}"></script>
    <script src="{{  url('public/specify/buttons.html5.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
@endsection