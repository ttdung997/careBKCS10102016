@extends('doctor.layout')
@section('title')
    Thông tin cá nhân
@stop
@section('content')
   <form class="form-horizontal" action="/doctor/info" enctype="multipart/form-data" method="post">
      <div class="col-md-12">

        <div class="form-group">
          <label>Ảnh hồ sơ <br/>
          <img class="img-responsive" width="200px" src="{{ URL::asset($avatar) }}
          ">
          </label>
          
          <input name="avatar" type="file">
        </div>
        

        <div class="form-group">
          <label>Họ và tên</label>
          <input name="fullname" class="form-control" placeholder="Họ tên của bạn" value="{{$fullname}}">
        </div>
        <div class="form-group">
          <label>Giới tính</label>
          <div class="radio">
            <label>
              <input name="gender" id="maleOptionRadio" value="Nam" type="radio" {{$is_male}}>Nam
            </label>
          </div>
          <div class="radio">
            <label>
              <input name="gender" id="femaleOptionRadio" value="Nữ"  type="radio" {{$is_female}}>Nữ
            </label>
          </div>
        </div>
         
          <div class="form-group">
          <label>Ngày sinh</label>
          <input name="birthday" type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="{{$birthday}}" >
        </div>
       
        <div class="form-group">
          <label>Số CMND hoặc hộ chiếu</label>
          <input name="id_number" class="form-control" placeholder="{{$id_number}}" value="{{$id_number}}" >
        </div>
        <div class="form-group">
          <label>Ngày cấp</label>
          <input name="id_date" type="text" class="form-control" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="{{$id_date}}" >
        </div>
        <div class="form-group">
          <label>Nơi cấp</label>
          <input name="id_address" class="form-control" placeholder="{{$id_address}}" value="{{$id_address}}" >
        </div>
        <div class="form-group">
          <label>Hộ khẩu thường trú</label>
          <input name="permanent_residence" class="form-control" placeholder="{{$permanent_residence}}" value="{{$permanent_residence}}" >
        </div>                      
        <!-- <div class="form-group">
          <label>Khoa vien</label>
          <input name="khoa" accept="" class="form-control" placeholder="{{$khoa}}" value="{{$khoa}}" disabled="">
        </div> -->
        <div class="form-group">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
      </div>
    </form>
@stop
