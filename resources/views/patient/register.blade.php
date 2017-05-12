@extends('patient.layout')
@section('title')
   Đăng ký khám bệnh
@stop
@section('content')

   <form class="form-horizontal" action="/patient/register" method="post">
      <div class="form-group">
         </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary">Đăng ký khám</button>
         </div>
            

         
   </form>
@stop