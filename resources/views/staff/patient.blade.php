@extends('staff.layout.master')

@section('title')
Quản lý bệnh nhân
@stop

@section('css')
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
<!-- Datatables extensions -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/colreorder/1.3.2/css/colReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/3.2.2/css/fixedColumns.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.0/css/select.dataTables.min.css">
<style>
    .form-group button{
        width: 60%;
    }
</style>
@endsection

@section('content')
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

    <table class="table table-striped table-bordered table-hover" id="userList">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th>Họ tên</th>
                <th>Ngày sinh</th>
                <th>Giới tính</th>
                <th>Thao tác</th>
            </tr>
        </thead>
    </table>

    <!-- Modal -->
    <!-- View modal -->
    <div class="modal fade" id="userViewModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Xem bệnh nhân</h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <!--                        <div class='row'>
                                                    <div class="col-lg-4" align="right"><strong>ID bệnh nhân</strong>   :</div>
                                                    <div id="user_id" class="col-lg-8" align="left"></div>
                                                </div>-->
                        <div class='row'>
                            <div class="col-lg-4" align="right"><strong>Họ tên</strong>   :</div>
                            <div id="user_name" class="col-lg-8" align="left"></div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-4" align="right"><strong>Email</strong>   :</div>
                            <div id="user_email" class="col-lg-8" align="left"></div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-4" align="right"><strong>Ngày sinh</strong>   :</div>
                            <div id="user_birthday" class="col-lg-8" align="left"></div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-4" align="right"><strong>Giới tính</strong>   :</div>
                            <div id="user_gender" class="col-lg-8" align="left"></div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-4" align="right"><strong>Tiền sử bệnh tật gia đình</strong>:</div>
                            <div id="user_family_history" class="col-lg-8" align="left"></div>
                        </div>
                        <div class='row'>
                            <div class="col-lg-4" align="right"><strong>Tiền sử bệnh tật</strong>   :</div>
                            <div id="user_personal_history" class="col-lg-8" align="left"></div>
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
                    <h4 class="modal-title">Xóa bệnh nhân</h4>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="text-center">
                            <p>Xác nhận xóa (các) bệnh nhân này?</p>
                            <input type="hidden" id="user_id" name="user_id" value="">
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="btn-delete-user">Xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create and edit modal -->
    <div class="modal fade" id="userCreateEditModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="userCreateEditModalTitle"></h4>
                </div>

                <!-- giáp: Thêm thẻ input name="" id="sendPwd" -->
                <form id="userCreateEditForm">
                    <input type="hidden" name="" value="" id="sendPwd">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Họ tên</label>:
                            <input type="text" value="{{ old('name') }}" name="name" class="form-control" placeholder="" id="name">
                            <div id="errorUserName">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>:
                            <input type="text" value="{{ old('email') }}" name="email" class="form-control" placeholder="" id="email">
                            <div id="errorUserEmail">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>:
                            <input type="password" value="" name="password" class="form-control" placeholder="" id="password">
                            <div id="errorUserPassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Xác nhận mật khẩu</label>:
                            <input type="password" value="" name="password_confirmation" class="form-control" placeholder="" id="password_confirmation">

                        </div>
                        <div class="form-group">
                            <label for="birthday">Ngày sinh</label>:
                            <input type="date" value="" name="birthday" class="form-control" placeholder="" id="birthday">

                        </div>
                        <div class="form-group">
                            <label for="gender">Giới tính</label>:
                            <select class="form-control" name="gender"  id="gender">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                        <div class="form-group">
                             <label for="history">Tiểu sử gia đình</label>:
                             <textarea class="form-control" rows="3" name="family_history" id="family_history"></textarea>
                        </div>
                         <div class="form-group">
                             <label for="history">Tiểu sử cá nhân</label>:
                             <textarea class="form-control" rows="3" name="personal_history" id="personal_history"></textarea>
                        </div>
                        
                    </div>
            
            </form>

            <div class="modal-footer">
                <button id="btn-reset-user" class="btn btn-default">Xóa</button>
                <button class="btn" id="btn-save-user"></button>
                <input type="hidden" id="user_id" name="user_id" value="">
            </div>
        </div>
    </div>
</div>
<!-- End modal -->

<div class="modal fade" id="medicalSubmitModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Đăng ký khám</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="form-group">
                            <button class="btn btn-primary" id="btn-medical-examination" data-dismiss="modal" >Khám sức khỏe</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-warning"  id="btn-medical-specialist" data-dismiss="modal" >Khám chuyên khoa</button>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" id="btn-medical-test" data-dismiss="modal" >Xét nghiệm</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal" >Thoát</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="medicalExaminationModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Đăng ký khám</h4>
            </div>
            <form>
                <div class="modal-body">
                    <div class="text-center">
                        <p>Xác nhận đăng ký khám cho bệnh nhân này?</p>
                        <input type="hidden" id="user_id" name="user_id" value="">
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-danger" id="btn-medical-examination">Đăng ký</button>
            </div>
        </div>
    </div>
</div>
<div  class="modal fade" id="medicalSpecialistModal" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                <h4>Đăng kí khám chuyên khoa</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="chọn sách">Chọn khoa</label>
                    <select class="form-control" name="khoa">
                        <?php
                        $department = DB::table('departments')->get();
                        foreach ($department as $department) {
                            ?>
                            <option value="<?= $department->id ?>"><?= $department->name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="chọn sách">Chọn loại hình khám</label>
                    <select class="form-control" name="medical_type">
                        <?php
                        $medical_type = DB::table('medical_specialist_type')->get();
                        foreach ($medical_type as $medical_type) {
                            ?>
                            <option value="<?= $medical_type->id ?>"><?= $medical_type->name ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="chọn sách">Chọn Ngày khám</label>
                    <input name="medical_date" type="date" value="<?= \Carbon\Carbon::now()->toDateString() ?>" class="form-control">
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="type" value="2">


            </div>
            <div class="modal-footer">
                <button id="SpecialistSubmit" type="button" class="btn btn-warning" data-dismiss="modal">Đăng ký khám</button>

            </div>

        </div>
    </div>
</div>
<div  class="modal fade" id="medicalTestModal" tabindex="-1" role="dialog" aria-labelledby="removeMedicalAppLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Đóng"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Chọn các loại xét nghiệm</h4>

            </div>
            <form id="TestForm">
                <div class="modal-body">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="type" value="3">

                    <?php
                    $MedicalTestType = DB::table('medical_test_type')->get();
                    foreach ($MedicalTestType as $MedicalTestType) {
                        ?>
                        <div class="form-group medical_test_type">

                            <input type="checkbox" class="Medical" name="Medical[]" value="<?= $MedicalTestType->id ?>" />
                            <label for="cheese"><?= $MedicalTestType->name ?></label>
                        </div>
                        <br>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <label for="chọn sách">Chọn Ngày xét nghiệm</label>
                        <input name="medical_date" type="date" value="<?= \Carbon\Carbon::now()->toDateString() ?>" class="form-control">
                    </div>
                    <input hidden name="userId">
                </div>

                <div class="modal-footer">
                    <button type="button" id="TestSubmit" class="btn btn-warning">Đăng ký xét nghiệm</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@endsection

@section('js')
<script type="text/javascript">
    // Advanced searching
    function filterColumn(i) {
        $('#userList').DataTable().column(i + ':name').search(
                $('#input_' + i + '').val()
                ).draw();
    }

    $(document).ready(function () {
        var baseUrl = $('meta[name="base_url"]').attr('content');

        //l - length changing input control
        //f - filtering input
        //t - The table!
        //i - Table information summary
        //p - pagination control
        //r - processing display element
        var userList = $('#userList').DataTable({
            ajax: baseUrl + "/listPatient",
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
                    "data": "patient_id"
                },
                {
                    "visible": true,
                    "searchable": true,
                    "orderable": true,
                    "data": "fullname",
                    "name": "userName"
                },
                {
                    "visible": true,
                    "searchable": true,
                    "orderable": true,
                    "data": "birthday",
                    "name": "birthday"
                },
                {
                    "visible": true,
                    "searchable": true,
                    "orderable": true,
                    "data": "gender",
                    "name": "gender"
                },
                {
                    "visible": true,
                    "searchable": false,
                    "orderable": false,
                    "data": null,
                    "defaultContent": '<button class="btn btn-primary open-medical-submit-modal"><span class="glyphicon glyphicon-plus"></span></button> <button class="btn btn-success open-view-user-modal"><span class="glyphicon glyphicon-eye-open"></span></button> <button class="btn btn-warning open-edit-user-modal"><span class="glyphicon glyphicon-pencil"></span></button> <button class="btn btn-danger open-delete-user-modal"><span class="glyphicon glyphicon-trash"></span></button>'
                            //"defaultContent": '<button class="btn btn-primary open-medical-examination-modal"><span class="glyphicon glyphicon-plus"></span></button> <button class="btn btn-success open-view-user-modal"><span class="glyphicon glyphicon-eye-open"></span></button> <button class="btn btn-warning open-edit-user-modal"><span class="glyphicon glyphicon-pencil"></span></button> <button class="btn btn-danger open-delete-user-modal"><span class="glyphicon glyphicon-trash"></span></button>'
                }
            ],
            dom: 'Bfrtip',
            lengthMenu: [
                [10, 20, 50, -1],
                ['Mặc định', 'Hiện 20 bản ghi', 'Hiện 50 bản ghi', 'Hiện tất cả']
            ],
            select: {
                //style:    'os',
                style: 'multi',
                selector: 'td:first-child'
            },
            //Disable automatic sorting on the first column
            sorting: [],
            //order: [[ 0, 'asc' ]],
            language: {
                "emptyTable": "Không có dữ liệu.",
                "info": "Tổng: _TOTAL_ bệnh nhân.",
                "infoEmpty": "Tổng: 0 bệnh nhân",
                "infoThousands": ".",
                "lengthMenu": "Hiện _MENU_ bệnh nhân",
                "loadingRecords": "Đang tải...",
                "processing": "Đang xử lý...",
                "search": "Tìm nhanh:",
                "searchPlaceholder": "Điền từ khóa...",
                "zeroRecords": "Không tìm thấy bệnh nhân nào thỏa mãn.",
                "paginate": {
                    "sFirst": "Đầu",
                    "sLast": "Cuối",
                    "sNext": "Sau",
                    "sPrevious": "Trước"
                },
                "infoFiltered": "(Tìm kiếm từ _MAX_ bệnh nhân)",
                select: {
                    rows: "",
                    rows: "Đã chọn: %d bệnh nhân."
                }
            },
            buttons: [
                {
                    text: 'Thêm',
                    titleAttr: 'Thêm bệnh nhân',
                    action: function (e) {
                        e.preventDefault();
                        $('#userAlert').empty();
                        $('#btn-save-user').val("add");
                        $('#btn-save-user').addClass('bg-purple');
                        $('#userCreateEditModalTitle').text("Thêm bệnh nhân");
                        $('#btn-reset-user').text("Xóa trắng");
                        $('#btn-save-user').text("Thêm");
                        $('#email').removeAttr('disabled');
                        $('#btn-reset-user').click(function () {
                            $('#userCreateEditModal').find('form')[0].reset();
                            $('#closeErrorUserName').click();
                            $('#closeErrorUserEmail').click();
                            $('#closeErrorUserPassword').click();
                            $('#closeErrorUserPasswordConfirmation').click();
                        });
                        $('#userCreateEditModal').modal('show');
                    }
                },
                {
                    extend: 'excel',
                    text: 'Excel',
                    titleAttr: 'Xuất tệp Excel',
                    title: 'Danh sách bệnh nhân',
                    exportOptions: {
                        columns: ["userName:name", "userEmail:name"]
                    }
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    titleAttr: 'Xuất tệp PDF',
                    title: 'Danh sách bệnh nhân',
                    message: 'Tài liệu chỉ lưu hành nội bộ.',
                    exportOptions: {
                        columns: ["userName:name", "userEmail:name"]
                    }
                },
                {
                    extend: 'print',
                    text: 'In',
                    titleAttr: 'In danh sách',
                    title: 'Danh sách bệnh nhân',
                    exportOptions: {
                        columns: ["userName:name", "userEmail:name"]
                    }
                },
                {
                    extend: 'pageLength',
                    text: 'Trên một trang',
                    titleAttr: 'Hiện số bệnh nhân trên một trang'
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
                },
                {
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
                }
            ],
            colReorder: {
                //fixedColumnsLeft: 1,
                fixedColumnsRight: 1
            }
        });

        $("#selectAll").change(function () {
            if (this.checked) {
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
        $('input.column_filter').on('keyup click', function () {
            filterColumn($(this).attr('data-column'));
        });

        $('input.toggle-article').change(function () {
            var column = userList.column($(this).attr('value'));
            column.visible(!column.visible());
        });

        $('#userCreateEditModal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $('#closeErrorUserName').click();
            $('#closeErrorUserEmail').click();
            $('#closeErrorUserPassword').click();
            $('#closeErrorUserPasswordConfirmation').click();
        });

        var userUrl = baseUrl + "/patient";

        //Display modal form for user viewing
        $('#userList tbody').on('click', '.open-view-user-modal', function () {
            $('#userAlert').empty();
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.patient_id;
            $.get(userUrl + '/show/' + user_id, function (data) {
                $('#user_name').html(data.patient.name);
                $('#user_email').html(data.patient.email);
                $('#user_id').html(data.patient.id)
                $('#user_birthday').html(data.patientInfo.birthday)
                $('#user_gender').html(data.patientInfo.gender)
                $('#user_family_history').html(data.patientInfo.family_history)
                $('#user_personal_history').html(data.patientInfo.personal_history)

                $('#userViewModal').modal('show');
            })
        });

        //Display modal form for user editing
        $('#userList tbody').on('click', '.open-edit-user-modal', function () {
            $('#userAlert').empty();
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.patient_id;
            $.get(userUrl + '/edit/' + user_id, function (data) {
                $('#user_id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#email').prop('disabled', true);

                $('#btn-save-user').val("update");
                $('#btn-save-user').addClass('btn-warning');
                $('#userCreateEditModalTitle').text("Sửa bệnh nhân");
                $('#btn-reset-user').text("Hoàn tác");
                $('#btn-save-user').text("Lưu");
                $('#btn-reset-user').click(function () {
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#password').val('');
                    $('#password_confirmation').val('');
                    $('#closeErrorUserName').click();
                    $('#closeErrorUserEmail').click();
                    $('#closeErrorUserPassword').click();
                    $('#closeErrorUserPasswordConfirmation').click();
                });
                $('#userCreateEditModal').modal('show');
            })
        });

        //Create new user/update existing user
        $("#btn-save-user").click(function (e) {
            $('#closeErrorUserName').click();
            $('#closeErrorUserEmail').click();
            $('#closeErrorUserPassword').click();
            $('#closeErrorUserPasswordConfirmation').click();

            // giáp: thêm xử lý hash pass
            var inPass = $("#password").val();
            var hashPass = CryptoJS.SHA256(inPass);
            $("#sendPwd").val(hashPass);
            // -- Hêt phần xử lý hash

            formmodified = 0;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            e.preventDefault();

            var formData = {
                name: $('#name').val(),
                email: $('#email').val(),
                birthday: $('#birthday').val(),
                gender: $('#gender').val(),
                family_history: $('#family_history').val(),
                personal_history: $('#personal_history').val()
            }

            // giáp: set pass gửi đi là bản hash
            if ($('#sendPwd').val()) {
                formData.hashPass = $('#sendPwd').val();
            }
            // -- Hết phần set pass gửi đi

            if ($('#password').val()) {
                formData.password = $('#password').val();
                formData.password_confirmation = $('#password_confirmation').val();
            }

            //Used to determine the http verb to use [add=POST], [update=PATCH]
            var state = $('#btn-save-user').val();

            var user_id = $('#user_id').val();

            var type = "POST";
            var my_url = userUrl + '/add';

            if (state == "update") {
                type = "PATCH";
                my_url = userUrl + '/edit/' + user_id;
            }

            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $('#userCreateEditModal').modal('hide');
                    userList.ajax.reload(null, false);
                    $('#userAlert').append('<div class="text-center alert alert-' + data.message_level + '"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-' + data.message_icon + '"></i>' + ' ' + data.flash_message + '</h4></div>');
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    if (errors.name) {
                        $('#errorUserName').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserName" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errors.name + '</div>');
                    }
                    if (errors.email) {
                        $('#errorUserEmail').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserEmail" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errors.email + '</div>');
                    }
                    if (errors.password) {
                        $('#errorUserPassword').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserPassword" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errors.password + '</div>');
                    }
                    if (errors.password_confirmation) {
                        $('#errorUserPasswordConfirmation').append('<div class="alert alert-warning alert-dismissable"><button id="closeErrorUserPasswordConfirmation" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errors.password_confirmation + '</div>');
                    }
                }
            });
        });

        $('#userList tbody').on('click', '.open-delete-user-modal', function () {
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.patient_id;
            deleteUser(user_id);
        });

        //Display modal form for deleting user
        function deleteUser(id) {
            $('#userAlert').empty();
            $('#user_id').val(id);
            $('#userDeleteModal').modal('show');
        }

        //Delete user
        $('#btn-delete-user').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var user_ids = $('#user_id').val();

            var formData = {
                ids: user_ids
            }

            $.ajax({
                type: "DELETE",
                url: userUrl + '/destroy',
                data: formData,
                success: function (data) {
                    $('#userDeleteModal').modal('hide');
                    userList.ajax.reload(null, false);
                    $('#userAlert').append('<div id="flash_message" class="text-center alert alert-' + data.message_level + '"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-' + data.message_icon + '"></i>' + ' ' + data.flash_message + '</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });

        $('#userList tbody').on('click', '.open-medical-examination-modal', function () {
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.patient_id;
            medicalExaminate(user_id);
        });

        function medicalExaminate(id) {
            $('#userAlert').empty();
            $('#user_id').val(id);
            $('#medicalExaminationModal').modal('show');
        }
        $('#userList tbody').on('click', '.open-medical-submit-modal', function () {
            var row = $(this).closest("tr");
            var user = userList.row(row).data();
            var user_id = user.patient_id;
            medicalChoice(user_id);
        });
        $('#btn-medical-specialist').on("click", function () {
            $('#medicalSpecialistModal').modal('show');
        });
        $('#btn-medical-test').on("click", function () {
            $('#medicalTestModal').modal('show');
        });

        function medicalChoice(id) {
            $('#userAlert').empty();
            $('#user_id').val(id);
            $('#medicalSubmitModal').modal('show');
        }

        $('#btn-medical-examination').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var user_id = $('#user_id').val();

            $.ajax({
                type: "POST",
                url: baseUrl + '/medicalApplication/add',
                data: {
                    userId: user_id
                },
                success: function (data) {
                    $('#medicalExaminationModal').modal('hide');
                    $('#userAlert').append('<div class="text-center alert alert-' + data.message_level + '"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-' + data.message_icon + '"></i>' + ' ' + data.flash_message + '</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $('#SpecialistSubmit').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            var user_id = $('#user_id').val();
            var khoa = document.getElementsByName('khoa')[0].value;
            var medical_type = document.getElementsByName('medical_type')[0].value;
            var medical_date = document.getElementsByName('medical_date')[0].value;
            $.ajax({
                type: "Get",
                url: baseUrl + '/medicalSpecialistApplication/add',
                data: {
                    userId: user_id,
                    khoa: khoa,
                    medical_type: medical_type,
                    medical_date: medical_date
                },
                success: function (data) {
                    $('#medicalSpecialistModal').modal('hide');
                    $('#userAlert').append('<div class="text-center alert alert-' + data.message_level + '"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-' + data.message_icon + '"></i>' + ' ' + data.flash_message + '</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
        $('#TestSubmit').click(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            var user_id = $('#user_id').val();
            document.getElementsByName('userId')[0].value = user_id;
            $.ajax({
                type: "Get",
                url: baseUrl + '/medicalTestApplication/add',
                data: $('#TestForm').serialize(),
                success: function (data) {
                    $('#medicalTestModal').modal('hide');
                    $('#userAlert').append('<div class="text-center alert alert-' + data.message_level + '"><button id="closeUserAlert" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4> <i class="icon fa fa-' + data.message_icon + '"></i>' + ' ' + data.flash_message + '</h4></div>');
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });
</script>
<!-- giáp: add thư viện xử lý hash pass trước khi submit form đăng ký -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/md5.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="//cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<!-- Datatables extensions -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
<!-- <script src="{{  url('public/specify/jszip.min.js') }}"></script>
<script src="{{  url('public/specify/pdfmake.min.js') }}"></script>
<script src="{{  url('public/specify/vfs_fonts.js') }}"></script> -->
<!-- <script src="{{  url('public/specify/buttons.html5.min.js') }}"></script> -->
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.3.2/js/dataTables.colReorder.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.2/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
@endsection