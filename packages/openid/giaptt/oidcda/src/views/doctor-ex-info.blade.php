@extends('oidcda::layout')
@section('title')
    Thông tin cá nhân
@stop
@section('content')

        <div class="form-group">
          <label>Họ và tên</label>
          <input name="fullname" class="form-control" placeholder="" value="{{ $fullname}}" disabled="true">
        </div>

        <div class="form-group">
          <label>Giới tính</label>
          <input name="fullname" class="form-control" placeholder="" value="{{ $gender }}" disabled="true">
        </div>

        <div class="form-group">
          <label>Ngày sinh</label>
          <input name="birthday" type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" 
          	value="{{ $birthday }}" disabled="true">
        </div>
       
	    <div class="form-group">
	      <label>Nơi công các</label>
	      <input name="fullname" class="form-control" placeholder="" value="{{ $hospital }}" disabled="true">
        </div>
            
        <div class="form-group">
	      <label>Địa chỉ Email</label>
	      <input name="fullname" class="form-control" placeholder="" value="{{ $email }}" disabled="true">
        </div>

        <div class="form-group">
          <label>Khoa viện</label>
          <input name="khoa" accept="" class="form-control" placeholder="" value="{{ $khoa }}" disabled="true">
        </div> 
        
@stop
