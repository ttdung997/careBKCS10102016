@extends('staff.layout.master')

@section('title')
    Quản lý bệnh nhân
@stop

@section('content')

@if(1)
<div class="form-group pull-right" >
  <button class="btn btn-default " data-toggle="modal" data-target="#myShare">Chia sẻ</button>
</div>
@endif

<div id="myShare" class="modal fade" role="dialog">
      <div class="modal-dialog" style="z-index:10241;width: 800px" >

        <!-- Modal content-->
        @if(1)
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Chia sẻ với</h4>
          </div>
          <div class="modal-body">
            <form role="form" action="{{ route('doctor-share') }}" method="POST">
              <input type="hidden" name="_token" value="{!! csrf_token() !!}" />
              @foreach($role_data as $item)
                    @if(in_array($item['id'], $roles))
                        <div class="form-group">
                            <label>
                                <input name="role[]" type="checkbox" value="{{ $item['id'] }}" checked="">{{$item['name']}}
                            </label>
                        </div>   
                    @else
                        <div class="form-group">
                            <label>
                                <input name="role[]" type="checkbox" value="{{ $item['id'] }}">{{$item['name']}}
                            </label>
                        </div>
                    @endif
              @endforeach
              <input type="hidden" name="resource_id" value="{!!$medical_id!!}" />

            <div>
                <button class="btn btn-default" type="submit">Lưu thay đổi</button>
            </div>
            
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
        @endif

      </div>
</div>

<div class="col-lg-12  ">
    @if(Session::has('flash_message'))
    <div class="alert alert-danger {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message') !!}
    </div>
    @elseif(Session::has('flash_message_success'))
    <div class="alert alert-success {!! Session::get('flash_level') !!}">
        {!! Session::get('flash_message_success') !!}
    </div>
    @endif
</div>

<form class="form-horizontal" action="{{ route('update-test-medical-info') }}" enctype="multipart/form-data" method="post">
<h2 class="col-md-offset-3"> Thông tin bệnh nhân</h2>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Họ tên  :</label>
        <div class="col-md-10">
             <p class="form-control-static" style="font-size: 16px"><?php echo($ten_benh_nhan); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Ngày sinh  :</label>
        <div class="col-md-10">
             <p class="form-control-static" style="font-size: 16px"><?php echo($ngay_sinh); ?></p>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label" style="font-size: 16px"> Hộ khẩu thường trú  :</label>
        <div class="col-md-10">
             <p class="form-control-static" style="font-size: 16px"><?php echo($ho_khau); ?></p>
        </div>
    </div>
    
    <h2 class="col-md-offset-3">Kết quả khám bệnh</h2>
    <h3><a data-toggle="collapse" href="#theluc" > 1. Khám thể lực</a></h3>
        <div id = "theluc" class="<?php if($kham_the_luc_disabled) echo "collapse"; ?>">
            <div class="form-group">
        		<label for="input_chieucao" class="col-md-2 control-label">Chiều cao :</label>
        		<div class="col-md-6">
          			<input type="text" name="chieu_cao" class="form-control" id="input_chieucao" <?php if($kham_the_luc_disabled) echo "disabled"; ?> value="{{$chieu_cao}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_cannang" class="col-md-2 control-label">Cân nặng :</label>
        		<div class="col-md-6">
          			<input type="text" name="can_nang" class="form-control" id="input_cannang" <?php if($kham_the_luc_disabled) echo "disabled"; ?>  value="{{$can_nang}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_huyetap" class="col-md-2 control-label">Huyết áp :</label>
        		<div class="col-md-6">
          			<input type="text" name="huyet_ap" class="form-control" id="input_huyetap" <?php if($kham_the_luc_disabled) echo "disabled"; ?> value="{{$huyet_ap}}">
                                <?php 
                                    $room=DB::table('staffs')->where('staff_id',Auth::user()->id)->first()->phongban;
                                ?>
                                <input type="hidden" name="room" value="<?=$room?>" >
        		</div>
        	</div>
        </div>

     

        <div class="form-group">
        <input type="hidden" name="medicalID" value="<?php echo($medical_id); ?>">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<div class="col-md-offset-4">
                    <label>Hoàn thiện</label><input type="checkbox" value="1" name="checkSubmit" id="checkSubmit">
        		<button type="submit" class="btn btn-primary btn-lg">Lưu kết quả </button>
                       
                      
        	</div>
        </div>
      
    </form>

@stop