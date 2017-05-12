@extends('doctor.layout')
@section('title')
    Chia sẻ
@stop

@section('content')

    <script src="{{ URL::asset('themes/assets/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('themes/assets/bootstrap-table/src/bootstrap-table.js') }}"></script>
<div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Danh sách chia sẻ quyền
          </div>
          <div class="panel-body">
            <table data-toggle="table" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                <thead>
                <tr>
                   
                    <th data-field="id" data-sortable="true">Số thứ tự</th>
                    <th data-field="name"  data-sortable="true">Role</th>
                    <th data-field="id" data-sortable="true">Ủy quyền</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($data_role as $role)
                    <tr>
                      <td></td>
                      <td>{!!$role["role_name"]!!}</td>
                      <td>
                        @foreach($data_user_permission as $permission)
                          {!!permission["name"]!!}
                        @endforeach
                      </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
</div>

<div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Danh sách quyền được chia sẻ
          </div>
          <div class="panel-body">
            <table data-toggle="table" data-url="{{ route('list-as-json') }}"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                <thead>
                <tr>
                   
                    <th data-field="id" data-sortable="true">Số thứ tự</th>
                    <th data-field="name"  data-sortable="true">Role</th>
                    <th data-field="id" data-sortable="true">Ủy quyền</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
</div>

<!-- <script>
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
</script> -->
    
@endsection
