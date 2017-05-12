@extends('doctor.layout')
@section('title')
Tìm kiếm thông tin bệnh nhân
@stop
@section('content')
	 <script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"></div>
					<div class="panel-body">
						<table data-toggle="table" data-url="{{ route('search-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						       
						        <th data-field="id" data-sortable="true">Mã bệnh nhân</th>
						        <th data-field="name"  data-sortable="true">Họ tên</th>
                                <th data-field="birthday"  data-sortable="true">Ngày sinh</th>
                                <th data-field="personal_history"  data-sortable="true">Tiền sử bệnh tật</th>
                                <th data-field="family_history"  data-sortable="true">Tiền sử bệnh tật gia đình</th>

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
 
@stop