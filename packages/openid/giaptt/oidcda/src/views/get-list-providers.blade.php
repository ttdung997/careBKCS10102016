@extends('admin.layout.master')
@section('title')
Danh sách các Providers
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
                    <div class="input-group">   <!-- input search by domain -->
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" class="form-control column_filter" placeholder="Tìm theo Domain" id="input_requestDomain" data-column="requestDomain">
                    </div>
                </div>

                <div class="col-lg-12"> <!-- hiển thị thông báo -->
                    <div class="col-lg-6 col-lg-offset-3" id="userAlert">

                    </div>
                </div>

				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body" style="overflow:scroll">
						<table data-toggle="table" data-url="{{ route('list-as-json-providers') }}" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" id="providerList">
						    <thead>
                                <tr>
                                    <th></th>   <!-- id -->
                                    <th>Provider name</th> <!-- tên của Provider -->
                                    <th>Domain</th>     <!-- domain -->
                                    <th>Provider ID</th>
                                    <th>Client ID</th>
                                    <th>Key Secret</th>
                                    <th>Authenticate Endpoint</th>
                                    <th>Token Endpoint</th>
                                    <th>Registration Endpoint</th>
                                    <th>Hành động</th> <!-- hiện thị các button cần thiết, vd: 'Xóa' -->
                                </tr>
						    </thead>
						</table>

                        <!-- giáp: Delete Provider modal -->
                        <div class="modal fade" id="handleRequestModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                                        <!-- có thể change dùng jQuery-->
                                        <h4 class="modal-title">Title của Modal</h4> 
                                    </div>
                                    <form>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                <!-- có thể change dùng jQuery-->
                                                <p>Xác nhận hành động thực hiện yêu cầu này?</p>
                                                <input type="hidden" id="provider_id" name="provider_id" value="">
                                                <input type="hidden" id="type_btn_id" name="type_btn_id" value="">
                                            </div>
                                        </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button class="btn btn-danger" id="btn-accept-action">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- giáp: Hết Delete Provider modal-->

                        <!-- Kim anh: Modal thêm Role -->
                        <div id="addRole" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Modal Header</h4>
                                  </div>
                                  <div class="modal-body">
                                    <!-- Multiple Radios (inline) -->
                                    @foreach($list_role as $role)
                                        <div class="radio">
                                          <label><input type="radio" name="role" value="{{$role->id}}">{{$role->name}}</label>
                                        </div>
                                    @endforeach
                                  </div>
                                  <input type="hidden" name="" id="provider_id_role" value="">
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-success" id="btn-handle-add-role">Lưu</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                                <input type="hidden" name="" value="{{URL::route('AdminController.addrole.provider')}}" id="addRoleURL">

                            </div>
                        </div> <!-- Kim anh: hết Modal thêm Role -->

					</div>
				</div>
			</div>
</div> <!-- end div class 'row' -->
@stop

@section('js')        
    <script type="text/javascript">
    // Advanced searching
    function filterColumn ( i ) {
        $('#providerList').DataTable().column( i+':name' ).search(
                $('#input_'+i+'').val()
        ).draw();
    }

    $(document).ready( function () {
        var baseUrl = $('meta[name="base_url"]').attr('content');
        var providerList = $('#providerList').DataTable( {
            ajax: baseUrl+"/list.json-providers",
            "scrollX": true,
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
                "data": "name_provider",
                "name": "providerName",
                "width": "200px"
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "domain",
                "name": "providerDomain"
            },
            {
                "visible": true,
                "searchable": false,
                "orderable": false,
                "data": "id_provider",
                "name": "providerId"
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "client_id",
                "name": "clientId"
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "key_secret",
                "name": "keySecret"
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "authen_endpoint",
                "name": "authEndpoint"
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "id_token_endpoint",
                "name": "tokenEndpoint"
            },
            {
                "visible": true,
                "searchable": true,
                "orderable": true,
                "data": "registration_endpoint",
                "name": "registerEndpoint"
            },
            {   // column 'Hành Động'
                "visible": true,
                "searchable": false,
                "orderable": false,
                "data": null,
                "width": "200px",
                "defaultContent": '<button class="btn btn-danger open-delete-user-modal handleDel" type="button" id="myBtnDel" name="myBtnDel" value="myBtnDel">&nbsp&nbspXóa&nbsp&nbsp&nbsp</button><button class="btn btn-info addRole" type="button" id="myBtnAddRole" name="myBtnAddRole" value="myBtnAddRole" data-toggle="modal" data-target="#addRole">&nbsp&nbspCấp Role&nbsp&nbsp&nbsp</button>' //&nbsp = 1 space
            },
            { 
                "visible": false,
                "searchable": false,
                "orderable": false,
                "data": "role_id"
            }
          ]
        } );

        // Advanced searching
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).attr('data-column') );
        } );

        var userUrl = baseUrl+"/list-providers";

        // xử lý sự kiện khi click vào button "Xóa" để xóa Provider.
        $('#providerList tbody').on('click', '.handleDel', function () {
            // tùy vào "name" của button mà sẽ xử lý tương ứng
            // get button bị click
            var type_btn = $(this).val(); //myBtnDel
            var titleModal = "Xóa OpenId Provider";    // title của modal.
            var detailModal = "Bạn có chắc chắn muốn xóa Provider này không ?"; // câu hỏi xác nhận hành động.
            
            var row = $(this).closest("tr");
            var provider = providerList.row(row).data();
            var provider_id = provider.id;

            // set title và nội dung cho box hỏi sự xác nhận, rồi hiển thị lên.
            $('#handleRequestModal .modal-dialog .modal-content .modal-header h4').text(titleModal);
            $('#handleRequestModal .modal-dialog .modal-content form .modal-body .text-center p').text(detailModal);
            $('#handleRequestModal').modal('show');

            deleteProviderById(provider_id);
        } );

        /// kim anh:  hàm xủ lý thêm role cho provider
        /// hàm xử lý khi admin click vào nút "OK" của hộp thoại hỏi xác nhận.
        $('#btn-handle-add-role').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            var provider_id = $('#provider_id_role').val();
            var role_id = $('input[name=role]:checked').val();

            var method_type = "POST";
            var url_handleAddRole = $('#addRoleURL').val();

            var roleData = {
                provider_id: provider_id,
                role_id: role_id
            }
            console.log(roleData);
            $.ajax({
                type: method_type,
                url: url_handleAddRole,
                data: roleData,
                dataType: 'json',
                success: function (data) {
                    $('#addRole').modal('hide');
                    providerList.ajax.reload(null, false);

                    $('#userAlert').append('<div id="flash_message" class="text-center alert alert-'+data.message_level+'"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-'+data.message_icon+'"></i>'+' '+data.flash_message+'</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }); // hết hàm xử lý khi click "Thêm"

        $('#providerList tbody').on('click', '.addRole', function () {
          
            var row = $(this).closest("tr");
            var provider = providerList.row(row).data();
            var provider_id = provider.id;
            var old_role_id = provider.role_id;
            $('#provider_id_role').val(provider_id);

            //$('input[name=role]:checked').val(old_role_id);
            $('input:radio[name=role]').val([old_role_id]);
            // var list_role = document.getElementsByName("role");
            // for(var i = 1; i <= list_role.length; i++){
            //     if(document.getElementsByName("role")[i].val() == old_role_id){
            //         document.getElementsByName("role")[i].attr('checked',true);
            //     }
                
            // }

            // var role_id = $('input[name=role]:checked').val();

        } );

        // hàm xử lý request theo (id và loại hành động)
        function deleteProviderById(id) {
            $('#userAlert').empty();
            // set gia trì vào form hỏi xác nhận.
            // nếu cần thêm hành động thì thêm thẻ input vào form.
            $('#provider_id').val(id); 
        
        }

        // hàm xử lý khi admin click vào nút "OK" của hộp thoại hỏi xác nhận.
        $('#btn-accept-action').click(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            // get từ các thẻ input ẩn của form
            var provider_ids = $('#provider_id').val();
            var type_btn_ids = $('#type_btn_id').val();
            var method_type = "POST";
            var url_handle = "/delete";
            // gửi id của provider đến controller để xử lý
            var formData = {
                op_ids: provider_ids,
                domain_rp: "",
                typ_ids: type_btn_ids
            }

            $.ajax({
                type: method_type,
                url: userUrl + url_handle,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#handleRequestModal').modal('hide');
                    providerList.ajax.reload(null, false);
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
