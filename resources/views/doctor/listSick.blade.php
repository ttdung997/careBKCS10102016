@extends('doctor.layout')
@section('title')
Danh sách các loại  bệnh
@stop
@section('content')
<script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
<script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">

                <button class="btn btn-primary" onclick="loadSick()">Load Danh sách</button>
            </div>
            <div class="panel-body">
                <table id="table-detail" 
                       data-toggle="table"
                       data-url=""
                       data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">  
                    <thead>
                        <tr>
<!--                            <th data-field="chapter_name"  data-sortable="true">Tên chương</th>
                            <th data-field="type_name"  data-sortable="true">Tên loại bệnh</th>-->
                            <th data-field="id"  data-sortable="true">Mã bệnh</th>
                            <th data-field="name"  data-sortable="true">Lọại bệnh</th>
                            <th data-field="id"  data-sortable="true" data-formatter="operateFormatter">Chi tiết</th>

                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    var $table = $('#table-detail');
    function loadSick() {
        console.log('1234');
        $table.bootstrapTable('refresh', {
            url: '/test.json'
        });
    }


//hàm khi click Kham
    function operateFormatter(value, row, index) {
        return [
            // '<div class="pull-left">',
            // '<a href="/details/' + value + '" target="_blank">' + 'Xem' + '</a>',
            // '</div>',
            '<div class="">',
            '<a id="button'+index+'" class="like" onclick="selectSick(&#39;',
            value + '&#39;,'+index+')"',
            '" title="Khám" target="_blank">',
            '<button class="btn btn-primary">Chọn bệnh</button>',
            '</a>  ',
            '</div>'
        ].join('');
    }
    function dateFormatter(value, row, index) {
        return[
            value.substring(0, 10)
        ]
    }
    function selectSick(value,index) {
        console.log(value+" vs "+ index);
    }
</script>
@stop