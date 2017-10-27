@extends('admin.layout.master')

@section('title')
    Danh sách bác sĩ của Role {{$id}}
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
<input type="hidden" id="IdOfRole" value="{{$id}}">
<input type="hidden" id="IdOfRolePatient" value="{{$IdRoleOfPatient}}">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control column_filter" placeholder="Tìm theo họ tên" id="input_userName" data-column="userName">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-inbox"></i></span>
                    <input type="text" class="form-control column_filter" placeholder="Tìm theo email" id="input_userEmail" data-column="userEmail">
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="col-lg-6 col-lg-offset-3" id="userAlert">

            </div>
        </div>

        <div class="col-lg-12">

        <table class="table table-striped table-bordered table-hover" id="userList">
            <thead>
            <tr>
                <th></th>
                <th></th>
                <th>Họ tên</th>
                <th>Địa chỉ email</th>
                <th>Thao tác</th>
            </tr>
            </thead>
        </table>
        </div>

        <!-- Modal -->
        <!-- View modal -->

        <div class="modal fade" id="userViewModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xem bác sĩ</h4>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <div class='row'>
                                <div class="col-lg-4" align="right"><strong>Họ tên</strong>   :</div>
                                <div id="user_name" class="col-lg-8" align="left"></div>
                            </div>
                            <div class='row'>
                                <div class="col-lg-4" align="right"><strong>Email</strong>   :</div>
                                <div id="user_email" class="col-lg-8" align="left"></div>
                            </div>
                            <div class='row'>
                                <div class="col-lg-4" align="right"><strong>Khoa</strong>   :</div>
                                <div id="user_khoa" class="col-lg-8" align="left"></div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>

            </div>
        </div>

        <!-- Delete modal -->
        <div class="modal fade" id="userDeleteModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Xóa bác sĩ</h4>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="text-center">
                                <p>Xác nhận xóa (các) bác sĩ này?</p>
                                <input type="hidden" id="user_id" name="user_id[]" value="">
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button class="btn btn-danger" id="btn-delete-user">Xóa</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thêm bác sĩ vào role -->
        <div class="modal fade" id="userCreateEditModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="userCreateEditModalTitle"></h4>
                    </div>

                    <form id="userCreateEditForm">
                         <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-hover" id="doctorRole">
                                <thead>
                                <tr>
                                    <th></th>
                                    <<th></th>
                                    <th>Họ tên</th>
                                    <th>Địa chỉ email</th>
                                </tr>
                                </thead>
                            </table>
                            </div>
                            {!! csrf_field() !!}
                    </form>

                    <div class="modal-footer">
                        <button id="btn-reset-user" class="btn btn-default">Xóa</button>
                        <button class="btn" id="btn-save-user"></button>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- End modal -->

    </div>
    <script>
    var siteGlobal = {
        token: '{{ csrf_token() }}'
    };
    </script>
@endsection

@section('js')
    <script type="text/javascript">
        // Advanced searching
        function filterColumn ( i ) {
            $('#userList').DataTable().column( i+':name' ).search(
                    $('#input_'+i+'').val()
            ).draw();
        }

        $(document).ready(function() {
            
            var baseUrl = $('meta[name="base_url"]').attr('content');
            console.log(baseUrl);
            var IdOfRole = $('#IdOfRole').val();

            var doctorList = $("#doctorRole").DataTable({
                ajax: baseUrl+"/listDoctor/",
                 columns: [
                    {
                        "visible": true,
                        "searchable": false,
                        "orderable": false,
                        "className": "select-checkbox center",
                        "defaultContent": " ",
                        "title": "<input type='checkbox' id='selectAllDoctor'>",
                        "width": "1%"
                    },
                    {
                        "visible": true,
                        "searchable": false,
                        "orderable": false,
                        "data": "id",
                        "className": "doctor-id",
                    },
                    {
                        "visible": true,
                        "searchable": true,
                        "orderable": true,
                        "data": "name",
                        "name": "doctorName"
                    },
                    {
                        "visible": true,
                        "searchable": true,
                        "orderable": true,
                        "data": "email",
                        "name": "doctorEmail"
                    },
                ],
                select: {
                    //style:    'os',
                    style:    'multi',
                    selector: 'td:first-child'
                },
            });

            $("#selectAllDoctor").change(function() {
                if(this.checked) {
                    doctorList.rows().select();
                } else {
                    doctorList.rows().deselect();
                }
            });

            $('#btn-save-user').on('click', function(event) {
                event.preventDefault();
                var data = doctorList.rows({selected: true}).data();
                var ids = [], element;
                for (keyElement in data) {
                    if (isNaN(keyElement) || isNaN(data[keyElement].id)) {
                        continue;
                    }
                    ids.push(data[keyElement].id);
                }

                var formData = {
                    doctor_ids: ids,
                    role_id: IdOfRole,
                    _token: siteGlobal.token
                }

                var type = "POST";
                var my_url = baseUrl + '/role/addDoctorforRole';

                $.ajax({
                    type: type,
                    url: my_url,
                    data: formData,
                    dataType: 'json',
                    success: function (data) {
                        $('#userCreateEditModal').modal('hide');
                        userList.ajax.reload(null, false);
                        $('#userAlert').append('<div class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
                    },

                    error: function (data) {
                        // console.log(user_id);

                        var errors = data.responseJSON;
                        // if (errors.name){
                        //     $('#errorUserName').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserName" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.name+'</div>');
                        // }
                        // if (errors.description){
                        //     $('#errorUserDescription').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserDescription" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+errors.description+'</div>');
                        // }
                    }
                });

                // $('#doctorRole tbody tr').each(function() {
                //     var selectedRows = doctorList.rows({selected: true}).count();
                    
                //     // if($(this).hasClass('selected')){
                //     //     console.log($(this).data("id"));
                //     // }
                // });

            });


            //Display modal form for deleting user
            // function deleteUser(id) {
            //     $('#userAlert').empty();
            //     $('#user_id').val(id);
            //     $('#userDeleteModal').modal('show');
            // }


            

            //l - length changing input control
            //f - filtering input
            //t - The table!
            //i - Table information summary
            //p - pagination control
            //r - processing display element
            var configTable = {
                ajax: baseUrl+"/listDoctorOfRole/"+IdOfRole,
                columns: [
                    {
                        "visible": true,
                        "searchable": false,
                        "orderable": false,
                        "className": "select-checkbox center",
                        "defaultContent": " ",
                        "title": "<input type='checkbox' id='selectAll'>",
                        "width": "1%"
                    },
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
                        "data": "name",
                        "name": "userName"
                    },
                    {
                        "visible": true,
                        "searchable": true,
                        "orderable": true,
                        "data": "email",
                        "name": "userEmail"
                    },
                    
                ],
                dom: 'Bfrtip',
                lengthMenu: [
                    [10, 20, 50, -1],
                    [ 'Mặc định', 'Hiện 20 bản ghi', 'Hiện 50 bản ghi', 'Hiện tất cả' ]
                ],
                select: {
                    //style:    'os',
                    style:    'multi',
                    selector: 'td:first-child'
                },
                //Disable automatic sorting on the first column
                sorting: [],
                //order: [[ 0, 'asc' ]],
                language: {
                    "emptyTable":     "Không có dữ liệu.",
                    "info":           "Tổng: _TOTAL_ bác sĩ.",
                    "infoEmpty":      "Tổng: 0 bác sĩ",
                    "infoThousands":  ".",
                    "lengthMenu":     "Hiện _MENU_ bác sĩ",
                    "loadingRecords": "Đang tải...",
                    "processing":     "Đang xử lý...",
                    "search":         "Tìm nhanh:",
                    "searchPlaceholder": "Điền từ khóa...",
                    "zeroRecords":    "Không tìm thấy bác sĩ nào thỏa mãn.",
                    "paginate": {
                        "sFirst":    "Đầu",
                        "sLast":     "Cuối",
                        "sNext":     "Sau",
                        "sPrevious": "Trước"
                    },
                    "infoFiltered":   "(Tìm kiếm từ _MAX_ bác sĩ)",
                    select: {
                        rows: "",
                        rows: "Đã chọn: %d bác sĩ."
                    }
                },
                buttons: [
                    {
                        extend: 'excel',
                        text: 'Excel',
                        titleAttr: 'Xuất tệp Excel',
                        title: 'Danh sách bác sĩ',
                        exportOptions: {
                            columns: ["userName:name", "userEmail:name"]
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'PDF',
                        titleAttr: 'Xuất tệp PDF',
                        title: 'Danh sách bác sĩ',
                        message: 'Tài liệu chỉ lưu hành nội bộ.',
                        exportOptions: {
                            columns: ["userName:name", "userEmail:name"]
                        }
                    },
                    {
                        extend: 'print',
                        text: 'In',
                        titleAttr: 'In danh sách',
                        title: 'Danh sách bác sĩ',
                        exportOptions: {
                            columns: ["userName:name", "userEmail:name"]
                        }
                    },
                    {
                        extend: 'pageLength',
                        text: 'Trên một trang',
                        titleAttr: 'Hiện số bác sĩ trên một trang'
                    },
                    {
                        extend: 'colvis',
                        text: 'Hiện',
                        titleAttr: 'Chọn các cột muốn hiển thị',
                        columns: ["userName:name", "userEmail:name"]
                    },
                    {
                        text: 'Khôi phục thứ tự',
                        titleAttr: 'Khôi phục thứ tự cột mặc định',
                        action: function (e) {
                            e.preventDefault();
                            userList.colReorder.reset();
                        }
                    },
                    {
                        text: 'Tải lại',
                        titleAttr: 'Tải lại danh sách',
                        action: function (e) {
                            userList.ajax.reload(null, false);
                        }
                    },
                    {
                        text: 'Bỏ chọn',
                        titleAttr: 'Bỏ chọn các hàng đã chọn',
                        action: function (e) {
                            userList.rows().deselect();
                        },
                        enabled: false,
                        name: 'deselectAll'
                    }
                    
                ],
                colReorder: {
                    //fixedColumnsLeft: 1,
                    fixedColumnsRight: 1
                }
            },
            buttonAdd = {
                text: 'Thêm người dùng',
                titleAttr: 'Thêm người dùng',
                className: 'btn-primary',
                id: 'addDoctor',
                action: function (e) {
                    e.preventDefault();
                    // userList.ajax.url(baseUrl+"/listDoctor/");
                    // userList.ajax.reload();
                    // $(e.target).addClass('btn-primary');
                    $('#userAlert').empty();
                    // $('#btn-save-user').val("add");
                    $('#btn-save-user').addClass('bg-purple');
                    $('#userCreateEditModalTitle').text("Thêm bác sĩ");
                    $('#btn-reset-user').text("Xóa trắng");
                    $('#btn-save-user').text("Thêm");
                    $('#email').removeAttr('disabled');
                    $('#btn-reset-user').click(function(){
                        $('#userCreateEditModal').find('form')[0].reset();
                        $('#closeErrorUserName').click();
                        $('#closeErrorUserEmail').click();
                        $('#closeErrorUserKhoa').click();
                        $('#closeErrorUserPassword').click();
                        $('#closeErrorUserPasswordConfirmation').click();
                    });
                    $('#userCreateEditModal').modal('show');

                }
            };

            buttonDeleteAll = {
                text: 'Xóa',
                titleAttr: 'Xóa (các) bản ghi đã chọn',
                action: function (e) {
                    ids = '';
                    //Gộp id các bản ghi đã chọn thành 1 chuỗi, mỗi id cách nhau bởi dấu cách
                    userList.rows({selected: true}).data().each(function (group, i) {
                        ids += ' ' + group.id;
                    });
                    deleteUser(ids);
                },
                enabled: false,
                name: 'destroyRecords'
            };
            buttonOnRowhaveDelete = {
                "visible": true,
                "searchable": false,
                "orderable": false,
                "data": null,
                "defaultContent": '<button class="btn btn-success open-view-user-modal"><span class="glyphicon glyphicon-eye-open"></span></button> <button class="btn btn-danger open-delete-user-modal"><span class="glyphicon glyphicon-trash"></span></button>'
            };
            buttonOnRow = {
                "visible": true,
                "searchable": false,
                "orderable": false,
                "data": null,
                "defaultContent": '<button class="btn btn-success open-view-user-modal"><span class="glyphicon glyphicon-eye-open"></span></button>'
            };

            if(IdOfRole != $('#IdOfRolePatient').val()){
                configTable.buttons.unshift(buttonAdd);
                configTable.buttons.push(buttonDeleteAll);
                configTable.columns.push(buttonOnRowhaveDelete);
            }else{
                configTable.columns.push(buttonOnRow);
            }
            var userList = $('#userList').DataTable(configTable);

            $("#selectAll").change(function() {
                if(this.checked) {
                    userList.rows().select();
                } else {
                    userList.rows().deselect();
                }
            });

            //Nếu không có bản ghi nào được chọn thì disable các nút không cần thiết
            function en_dis_button() {
                var selectedRows = userList.rows({selected: true}).count();
                if (selectedRows > 0) {
                    userList.button('deselectAll:name').enable();
                    userList.button('destroyRecords:name').enable();
                } else {
                    userList.button('deselectAll:name').disable();
                    userList.button('destroyRecords:name').disable();
                }
            }

            userList.on('select', function () {
                en_dis_button();
            })
                    .on('deselect', function () {
                        en_dis_button();
                    })
                    .on('processing.dt', function () {
                        en_dis_button();
                    });

            // Advanced searching
            $('input.column_filter').on( 'keyup click', function () {
                filterColumn( $(this).attr('data-column') );
            } );

            $('input.toggle-article').change(function() {
                var column = userList.column( $(this).attr('value') );
                column.visible( ! column.visible() );
            });

            $('#userCreateEditModal').on('hidden.bs.modal', function(){
                $(this).find('form')[0].reset();
                $('#closeErrorUserName').click();
                $('#closeErrorUserEmail').click();
                $('#closeErrorUserPassword').click();
                $('#closeErrorUserPasswordConfirmation').click();
            });

            var userUrl = baseUrl+"/role";

            //Display modal form for user viewing
            $('#userList tbody').on('click', '.open-view-user-modal', function () {
                $('#userAlert').empty();
                var row = $(this).closest("tr");
                var user = userList.row(row).data();
                var user_id = user.id;
                $.get(baseUrl + '/doctor/show/' + user_id, function (data) {
                    $('#user_name').html(data.name);
                    $('#user_email').html(data.email);
                    $('#user_khoa').html(data.khoa);

                    $('#userViewModal').modal('show');
                })
            } );

            $('#userList tbody').on('click', '.open-delete-user-modal', function () {
                var row = $(this).closest("tr");
                var user = userList.row(row).data();
                var user_id = user.id;
                deleteUser(user_id);
            } );

            //Display modal form for deleting user
            function deleteUser(id) {
                $('#userAlert').empty();
                $('#user_id').val(id);
                $('#userDeleteModal').modal('show');
            }

            //Delete user
            $('#btn-delete-user').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })

                var user_ids = $('#user_id').val();
                console.log(user_ids);
                var doctor_ids = user_ids.split(" ");
                var formData = {
                    doctor_ids: doctor_ids,
                    role_id: IdOfRole
                }
                console.log(doctor_ids);

                $.ajax({
                    type: "DELETE",
                    url: userUrl + '/deleteDoctor',
                    data: formData,
                    success: function (data) {
                        $('#userDeleteModal').modal('hide');
                        userList.ajax.reload(null, false);
                        $('#userAlert').append('<div id="flash_message" class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            });
        });
    </script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <!-- Datatables extensions -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
   <!--  <script src="{{  url('public/specify/jszip.min.js') }}"></script>
    <script src="{{  url('public/specify/pdfmake.min.js') }}"></script>
    <script src="{{  url('public/specify/vfs_fonts.js') }}"></script>
    <script src="{{  url('public/specify/buttons.html5.min.js') }}"></script> -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
@endsection