@extends('doctor.layout')
@section('title')
Danh sách chờ khám
@stop
@section('content')
    <script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<table data-toggle="table" data-url="{{ route('wait-for-test-list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						       
						        <th data-field="usersname"  data-sortable="true">Họ tên</th>
						        <th data-field="usersname"  data-sortable="true">loại xét nghiệm</th>
						       
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
            '<a class="like" href="../doctor/medical_exam/',
            value,
            '" title="Khám" target="_blank">',
            '<button class="btn btn-primary">Khám</button>',
            '</a>  ',
            '</div>'
        ].join('');
    }
    function dateFormatter(value, row, index){
    	return[
    		value.substring(0,10)
    	]
    }
</script>
@stop