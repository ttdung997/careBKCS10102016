@extends('staff.layout.master')

@section('title')
Quản lý bệnh nhân
@stop

@section('content')
<style>
    .disableLink{
        pointer-events: none;
        cursor: default;
    } 
</style>
<script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
<script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                <table data-toggle="table" data-url="{{ route('staff-list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                    <thead>
                        <tr>

                            <th data-field="id" >Mã xét nghiệm</th>
                            <th data-field="usersname" >Họ tên</th>
                            <th data-field="name">loại xét nghiệm</th>
                            <th data-field="id" data-sortable="true" data-formatter="operateFormatter"
                                >Xét nghiệm</th>
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
    if (index == 0) {
        return [
            '<div class="">',
            '<a class="like" href="../staff/medical_test/',
            value,
            '" title="Xét nghiệm" target="_blank">',
            '<button class="btn btn-primary ">Xét nghiệm</button>',
            '</a>  ',
            '<a id="next'+index+'" onclick="next('+index+')"',
            ,
                    ' title="Xét nghiệm" target="_blank">',
            '<button id="button'+index+'" class="btn btn-danger ">bỏ qua</button>',
            '</a>  ',
            '</div>'
        ].join('');
    } else {
        return [
            '<div class="">',
            '<a class="like disableLink" id="dong'+index+'" href="../staff/medical_test/',
            value,
            '" title="Xét nghiệm" target="_blank">',
            '<button class="btn btn-primary disabled " id="nut'+index+'" >Xét nghiệm</button>',
            '</a>  ',
            '<a id="next'+index+'" class="hidden" onclick="next('+index+')"',
            ,
                    ' title="Xét nghiệm" target="_blank">',
            '<button id="button'+index+'" class="btn btn-danger ">bỏ qua</button>',
            '</a>  ',
            '</div>'

        ].join('');
    }
}
function dateFormatter(value, row, index) {
    return[
        value.substring(0, 10)
    ]
}
function next(index){
   var number=index+1;
   document.getElementById("dong"+number).classList.remove("disableLink");
   document.getElementById("nut"+number).classList.remove("disabled");
   document.getElementById("next"+number).classList.remove("hidden");
   document.getElementById("button"+index).classList.remove("btn-danger");
   document.getElementById("button"+index).classList.add("btn-success");
   document.getElementById("button"+index).innerHTML="Đang đợi";
}
</script>
@stop