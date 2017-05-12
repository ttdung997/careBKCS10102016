@extends('oidcda::layout')
@section('title')
   
@stop
@section('content')
<form class="form-horizontal" action="{{ route('update-medical-info') }}" enctype="multipart/form-data" method="post">
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
        		</div>
        	</div>
        </div>

     <h3><a data-toggle="collapse" href="#noikhoa"> 2. Khám nội khoa</a></h3>
        <div id="noikhoa" class="<?php if($noi_khoa_disabled) echo "collapse"; ?>">
            <div class="form-group">
        		<label for="tuan_hoan" class="col-md-2 control-label">Tuần hoàn :</label>
        		<div class="col-md-6">
          			<input type="text" name="tuan_hoan" class="form-control" id="tuan_hoan" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$tuan_hoan}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_phan_loai_tuan_hoan" class="col-md-2 control-label">Phân loại tuần hoàn :</label>
        		<div class="col-md-6">
          			<input type="text" name="input_phan_loai_tuan_hoan" class="form-control" id="input_phan_loai_tuan_hoan" <?php if($noi_khoa_disabled) echo "disabled"; ?>  value="{{$phan_loai_tuan_hoan}}">
        		</div>
        	</div>
            <div class="form-group">
        		<label for="ho_hap" class="col-md-2 control-label">Hô hấp :</label>
        		<div class="col-md-6">
          			<input type="text" name="ho_hap" class="form-control" id="ho_hap" <?php if($noi_khoa_disabled) echo "disabled"; ?>  value="{{$ho_hap}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_phan_loai_ho_hap" class="col-md-2 control-label">Phân loại hô hấp :</label>
        		<div class="col-md-6">
          			<input type="text" name="input_phan_loai_ho_hap" class="form-control" id="input_phan_loai_ho_hap" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$phan_loai_ho_hap}}">
        		</div>
        	</div>
           <div class="form-group">
        		<label for="tieu_hoa" class="col-md-2 control-label">Tiêu hóa :</label>
        		<div class="col-md-6">
          			<input type="text" name="tieu_hoa" class="form-control" id="tieu_hoa" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$tieu_hoa}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_phan_loai_tieu_hoa" class="col-md-2 control-label">Phân loại tiêu hóa :</label>
        		<div class="col-md-6">
          			<input type="text" name="input_phan_loai_tieu_hoa" class="form-control" id="input_phan_loai_tieu_hoa" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$phan_loai_tieu_hoa}}">
        		</div>
        	</div>
             <div class="form-group">
                <label for="than_tiet_nieu" class="col-md-2 control-label">Thận tiết niệu :</label>
                <div class="col-md-6">
                    <input type="text" name="than_tiet_nieu" class="form-control" id="than_tiet_nieu" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$than_tiet_nieu}}">
                </div>
            </div>
            <div class="form-group">
                <label for="input_phan_than_tiet_nieu" class="col-md-2 control-label">Phân loại thận tiết niệu :</label>
                <div class="col-md-6">
                    <input type="text" name="input_phan_than_tiet_nieu" class="form-control" id="input_phan_loai_than_tiet_nieu" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$phan_loai_than_tiet_nieu}}">
                </div>
            </div>
            <div class="form-group">
        		<label for="noi_tiet" class="col-md-2 control-label">Nội tiết :</label>
        		<div class="col-md-6">
          			<input type="text" name="noi_tiet" class="form-control" id="noi_tiet" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$noi_tiet}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_phan_loai_noi_tiet" class="col-md-2 control-label">Phân loại Nội tiết :</label>
        		<div class="col-md-6">
          			<input type="text" name="input_phan_loai_noi_tiet" class="form-control" id="input_phan_loai_noi_tiet" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$phan_loai_noi_tiet}}">
        		</div>
        	</div>
            <div class="form-group">
        		<label for="co_xuong_khop"  class="col-md-2 control-label">Cơ xương khớp :</label>
        		<div class="col-md-6">
          			<input type="text" name="co_xuong_khop" class="form-control" id="co_xuong_khop" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$co_xuong_khop}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_phan_loai_co_xuong_khop" class="col-md-2 control-label">Phân loại cơ xương khớp :</label>
        		<div class="col-md-6">
          			<input type="text" name="input_phan_loai_co_xuong_khop" class="form-control" id="input_phan_loai_co_xuong_khop" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$phan_loai_co_xuong_khop}}">
        		</div>
        	</div>
            <div class="form-group">
        		<label for="than_kinh" name="than_kinh" class="col-md-2 control-label">Thần kinh :</label>
        		<div class="col-md-6">
          			<input type="text" class="form-control" id="than_kinh" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$than_kinh}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_phan_loai_than_kinh" class="col-md-2 control-label">Phân loại thần kinh :</label>
        		<div class="col-md-6">
          			<input type="text" name="phan_loai_than_kinh" class="form-control" id="input_phan_loai_than_kinh" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$phan_loai_than_kinh}}">
        		</div>
        	</div>
            <div class="form-group">
        		<label for="tam_than" class="col-md-2 control-label">Tâm thần :</label>
        		<div class="col-md-6">
          			<input type="text" name="tam_than" class="form-control" id="tam_than" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$tam_than}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="input_phan_loai_tam_than" class="col-md-2 control-label">Phân loại tâm thần :</label>
        		<div class="col-md-6">
          			<input type="text" name="phan_loai_tam_than" class="form-control" id="input_phan_loai_tam_than" <?php if($noi_khoa_disabled) echo "disabled"; ?> value="{{$phan_loai_tam_than}}">
        		</div>
        	</div>

        </div>

        <h3><a data-toggle="collapse" href="#mat"> 3. Khám mắt</a></h3>
        <div id ="mat" class="<?php if($mat_disabled) echo "collapse"; ?>">
            <div class="form-group">
        		<label for="mat_trai" class="col-md-2 control-label">Mắt trái   :</label>
        		<div class="col-md-6">
          			<input type="text" name="mat_trai" class="form-control" id="mat_trai" <?php if($mat_disabled) echo "disabled"; ?> value="{{$mat_trai}}">
        		</div>
        	</div>
        	   <div class="form-group">
        		<label for="mat_phai" class="col-md-2 control-label">Mắt phải   :</label>
        		<div class="col-md-6">
          			<input type="text" name="mat_phai" class="form-control" id="mat_phai" <?php if($mat_disabled) echo "disabled"; ?>  value="{{$mat_phai}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="benh_ve_mat" class="col-md-2 control-label">Bệnh về mắt   :</label>
        		<div class="col-md-6">
          			<input type="text" name="benh_ve_mat" class="form-control" id="benh_ve_mat" <?php if($mat_disabled) echo "disabled"; ?> value="{{$benh_ve_mat}}">
        		</div>
        	</div>
        	   <div class="form-group">
        		<label for="phan_loai_mat" class="col-md-2 control-label">Phân loại mắt   :</label>
        		<div class="col-md-6">
          			<input type="text" name="phan_loai_mat" class="form-control" id="phan_loai_mat" <?php if($mat_disabled) echo "disabled"; ?> value="{{$phan_loai_mat}}">
        		</div>
        	</div>
        </div>

		<h3><a data-toggle="collapse" href="#taimuihong">4. Khám tai mũi họng </a></h3>
        <div id=taimuihong class="<?php if($tai_mui_hong_disabled) echo "collapse"; ?>">
            <div class="form-group">
        		<label for="tai_trai" class="col-md-2 control-label">Tai trái   :</label>
        		<div class="col-md-6">
          			<input type="text" name="tai_trai" class="form-control" id="tai_trai" <?php if($tai_mui_hong_disabled) echo "disabled"; ?> value="{{$tai_trai}}">
        		</div>
        	</div>
        	   <div class="form-group">
        		<label for="tai_phai" class="col-md-2 control-label">Tai phải   :</label>
        		<div class="col-md-6">
          			<input type="text" name="tai_phai" class="form-control" id="tai_phai" <?php if($tai_mui_hong_disabled) echo "disabled"; ?> value="{{$tai_phai}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="benh_ve_tai_mui_hong" class="col-md-2 control-label">Bệnh nếu có   :</label>
        		<div class="col-md-6">
          			<input type="text" name="benh_ve_tai_mui_hong" class="form-control" id="benh_ve_tai_mui_hong" <?php if($tai_mui_hong_disabled) echo "disabled"; ?> value="{{$benh_ve_tai_mui_hong}}">
        		</div>
        	</div>
        	   <div class="form-group">
        		<label for="phan_loai_tai_mui_hong" class="col-md-2 control-label">Phân loại tai mui hong   :</label>
        		<div class="col-md-6">
          			<input type="text" name="phan_loai_tai_mui_hong" class="form-control" id="phan_loai_tai_mui_hong" <?php if($tai_mui_hong_disabled) echo "disabled"; ?> value="{{$phan_loai_tai_mui_hong}}">
        		</div>
        	</div>
        </div>

    	<h3><a data-toggle="collapse" href="#ranghammat">5. Khám răng hàm mặt</a></h3>
        <div id ="ranghammat" class="<?php if($rang_ham_mat_disabled) echo "collapse"; ?>">
            <div class="form-group">
        		<label for="ham_tren" class="col-md-2 control-label">Hàm trên   :</label>
        		<div class="col-md-6">
          			<input type="text" name="ham_tren" class="form-control" id="ham_tren" <?php if($rang_ham_mat_disabled) echo "disabled"; ?> value="{{$ham_tren}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="ham_duoi" class="col-md-2 control-label">Hàm dưới   :</label>
        		<div class="col-md-6">
          			<input type="text" name="ham_duoi" class="form-control" id="ham_duoi" <?php if($rang_ham_mat_disabled) echo "disabled"; ?> value="{{$ham_duoi}}">
        		</div>
        	</div>
        	   <div class="form-group">
        		<label for="phan_loai_rang_ham_mat" class="col-md-2 control-label">Phân loại răng hàm mặt   :</label>
        		<div class="col-md-6">
          			<input type="text" name="phan_loai_rang_ham_mat" class="form-control" id="phan_loai_rang_ham_mat" <?php if($rang_ham_mat_disabled) echo "disabled"; ?> value="{{$phan_loai_rang_ham_mat}}">
        		</div>
        	</div>
            <div class="form-group">
                <label for="nkl" class="col-md-2 control-label">NGười kết luận   :</label>
                <div class="col-md-6">
                    <input type="text" name="ham_duoi" class="form-control" id="nkl" disabled value="{{ Auth::user()->name }}">
                </div>
            </div>
        </div>

        <h3><a data-toggle="collapse" href="#dalieu">6. Khám da liễu</a></h3>
        <div id="dalieu" class="<?php if($da_lieu_disabled) echo "collapse"; ?>">
    	   <div class="form-group">
        		<label for="phan_loai_da_lieu" class="col-md-2 control-label">Phân loại da liễu   :</label>
        		<div class="col-md-6">
          			<input type="text" name="phan_loai_da_lieu" class="form-control" id="phan_loai_da_lieu" <?php if($da_lieu_disabled) echo "disabled"; ?> value="{{$phan_loai_da_lieu}}">
        		</div>
    	   </div>
        </div>

       <h3><a data-toggle="collapse" href="#cls"> 7. Khám cận lâm sàng </a></h3>
       <div id="cls" class="<?php if($can_lam_sang_disabled) echo "collapse"; ?>">
           <div class="form-group">
        		<label for="ket_qua" class="col-md-2 control-label">Kết quả   :</label>
        		<div class="col-md-6">
          			<input type="text" name="ket_qua" class="form-control" id="ket_qua" <?php if($can_lam_sang_disabled) echo "disabled"; ?> value="{{$ket_qua}}">
        		</div>
        	</div>
        	   <div class="form-group">
        		<label for="danh_gia" class="col-md-2 control-label">Đánh giá   :</label>
        		<div class="col-md-6">
          			<textarea name="danh_gia" rows="5" cols="86" id="danh_gia" <?php if($can_lam_sang_disabled) echo "disabled"; ?> value="{{$danh_gia}}"></textarea>
        		</div>
        	</div>
        </div>


       <h3><a data-toggle="collapse" href="#ketluan">8. Kết luận</a></h3>
        <div id="ketluan" class="<?php if($tong_quan_disabled) echo "collapse"; ?>">
           <div class="form-group">
        		<label for="phan_loai" class="col-md-2 control-label">Phân loại sức khỏe   :</label>
        		<div class="col-md-6">
          			<input type="text" name="phan_loai" class="form-control" id="phan_loai" <?php if($tong_quan_disabled) echo "disabled"; ?> value="{{$phan_loai}}">
        		</div>
        	</div>
        	<div class="form-group">
        		<label for="benh_neu_co" class="col-md-2 control-label">Bệnh nếu có   :</label>
        		<div class="col-md-6">
          			<input type="text" name="benh_neu_co" class="form-control" id="benh_neu_co" <?php if($tong_quan_disabled) echo "disabled"; ?> value="{{$benh_neu_co}}">
        		</div>
        	</div>
        </div>

        <!-- <div class="form-group">
        <input type="hidden" name="medicalID" value="<?php echo($medical_id); ?>">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<div class="col-md-offset-4">
        		<button type="submit" class="btn btn-primary btn-lg">Lưu kết quả </button>
        	</div>
        </div> -->
      
    </form>

@stop