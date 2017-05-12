@extends('staff.layout.master')

@section('title')
    Danh sách chờ khám
@stop

@section('css')

@endsection

@section('content')

 <script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<table data-toggle="table" data-url="{{ route('list-as-json-staff') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						       
						        <th data-field="id" data-sortable="true">Mã đơn khám</th>
						        <th data-field="name"  data-sortable="true">Họ tên</th>
						        <th data-field="date" data-sortable="true">Ngày đăng kí</th>
						        <th data-field="status" data-sortable="true">Trạng thái</th>
    
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div>
		</div>
 <script>
	var $table = $('#table-detail');

    function dateFormatter(value, row, index){
    	return[
    		value.substring(0,10)
    	]
    }
</script>

@endsection

@section('js')

@endsection