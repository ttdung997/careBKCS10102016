@extends('patient.layout')
@section('title')
Bảng thông tin
@stop
@section('content')
@section('content')


<div id="HealthModel" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Khám sức khỏe</h4>
                <div id="khamsuckhoe"></div>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<div id="SpacialModel" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Khám chuyên khoa</h4>
            </div>
            <div class="modal-body">
                <div id="khamchuyenkhoa">

                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://care.dev/themes/assets/jquery.min.js"></script>
<script src="http://care.dev/themes/assets/bootstrap-table/src/bootstrap-table.js"></script>
<style>
    .fixed-table-loading{
        display: none;
    }
</style>

<div id="TestModel" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Danh sách xét nghiệm</h4>
            </div>

            <div class="modal-body">
                <table id="table" data-toggle="table" class="bootstrap-table">
                    <thead>
                    <th>Tên loại xét nghiệm</th>
                    <th>Còn phải đợi</th>
                    </thead>
                    <tbody id="xetnghiem">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function load() {
        $.ajax({
            type: 'GET',
            url: 'getPosition',
            data: '_token = <?php echo csrf_token() ?>',
            success: function (data) {
                if (data.khamsuckhoe !== "") {
                    document.getElementById('khamsuckhoe').innerHTML = data.khamsuckhoe;
                    document.getElementById('HealthModel').style.display = "block";
                }
                if (data.khamchuyenkhoa !== "") {
                    document.getElementById('khamchuyenkhoa').innerHTML = data.khamchuyenkhoa;
                    document.getElementById('SpacialModel').style.display = "block";
                }
                if (data.xetnghiem !== "") {
                    document.getElementById('xetnghiem').innerHTML = data.xetnghiem;
                    document.getElementById('TestModel').style.display = "block";
                }
            }
        });
    }
    load();
    window.setInterval(function () {
        load();
    }, 10000);
</script>
@stop
@stop