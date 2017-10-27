@extends('patient.layout')
@section('title')
   Đăng ký khám bệnh
@stop
@section('content')
@section('content')
	
		<p>Bạn đã đăng ký khám vào ngày <?php echo $ngay_kham; ?></p>
		<p>Bạn có muốn hủy khám không? </p>
	
   <form class="form-horizontal" action="/patient/cancel-register" method="post">
      <div class="form-group">
         </div>
         	<input type="hidden" name="don_kham_id" value="<?php echo $don_kham_id; ?>">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
             <button type="submit" class="btn btn-danger">Hủy khám</button>

         </div>
           
         
   </form>
@stop
@stop