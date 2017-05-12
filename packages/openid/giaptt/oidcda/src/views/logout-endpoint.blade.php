@extends('oidcda::app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    Bạn có muốn Đăng xuất khỏi {{ config('app.name') }} không ?<br>
                    <h4><a href="{{ url('logout') }}">Có</a></h4> <h4><a href="{{ url('home') }}">Không</a></h4>
                </div>
            </div>
    
        </div>
    </div>
</div>
@stop
