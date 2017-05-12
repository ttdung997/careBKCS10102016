@extends('admin.layout.master')
@section('title')
Đăng ký OpenID Connect
@stop
@section('content')
	<script type="text/javascript"></script>
	<form class="form-horizontal" action="{{ url('admin/register-openid') }}" method="POST">
	<fieldset>

	<!-- Form Name -->
	<legend>Đăng ký OpenId Connect </legend>
	<!-- Phần này mô tả về OpenID Connect là gì và làm gì -->
	@if($response == "request_already_exist")
		<div class="alert alert-warning">
	    	<strong>Warning!</strong> Bạn đã gửi yêu cầu đăng ký đến OP này rồi. Hãy chờ phản hồi.
	  	</div>
	@elseif($response == "request_already_processed")
		<div class="alert alert-warning">
    		<strong>Warning!</strong> Bạn đã đăng ký OpenId Connect với Provider này rồi. Không thể đăng ký thêm!
  		</div>
  	@elseif($response != "")
  		<div class="alert alert-info">
		  <strong>Info!</strong> {{ $response }} <br> Bạn có thể check trong tab "List Requests".
		</div>
	@endif
	<!-- Select OpenId Provider muốn đăng ký -->
	<div class="form-group">
		<label class="col-md-4 control-label" for="fn">OpenId Provider</label> 
		<div class="col-md-4">	
		  <input id="provider" name="provider" type="text" placeholder="eg: provider.com/registration" class="form-control input-md" required="">
		    
		</div> 
	</div>
	<!-- Text input-->
	<!--
	<div class="form-group">
	  <label class="col-md-4 control-label" for="fn">Domain</label>  
	  <div class="col-md-4">
	  <input id="domain" name="domain" type="text" placeholder="eg: domain.com" class="form-control input-md" required="">
	    
	  </div>
	</div> -->

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="cmpny">Tên công ty</label>  
	  <div class="col-md-4">
	  <input id="cmpny" name="cmpny" type="text" placeholder="eg: Bạch Mai Hospital" class="form-control input-md" required="">
	    
	  </div>
	</div>

	<!-- Text input-->
	<!--
	<div class="form-group">
	  <label class="col-md-4 control-label" for="email">Callback URL</label>  
	  <div class="col-md-4">
	  <input id="redirect_url" name="redirect_url" type="text" placeholder="eg: http://domain.com/callback" class="form-control input-md" required="">
	    
	  </div>
	</div> -->

	<!-- Select Basic -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="select_algorithm">Thời gian tối đa của 1 lần xác thực</label>
	  <div class="col-md-4">
	    <select id="select_max_age" name="select_max_age" class="form-control input-md">
	      <option value="2h">Hai giờ (2 hours)</option>
	      <option value="4h">Bốn giờ (4 hours)</option> 
	      <option value="8h">Tám giờ (8 hours)</option>
	      <option value="1d">Một ngày (1 day)</option>
	    </select>
	  </div>
	</div>

	<!-- Text input-->
	<!--
	<div class="form-group">
	  <label class="col-md-4 control-label" for="max_age">Maximum Authentication Age</label>  
	  <div class="col-md-4">
	  <input id="max_age" name="max_age" type="text" placeholder="eg: 3600 second" class="form-control input-md" required=""> 
	  </div>  
	  <label class="control-label">number of seconds</label>
	</div> -->


	
	<!-- Multiple Radios (inline) -->
	<!--
	<div class="form-group">
	  <label class="col-md-4 control-label" for="Networking_Reception">Would you like to attend our Technical Product Update Session on September 4, 2015?</label>
	  <div class="col-md-4"> 
	    <label class="radio-inline" for="Networking_Reception-0">
	      <input type="radio" name="Networking_Reception" id="Networking_Reception-0" value="meet_yes" checked="checked">
	      Yes
	    </label> 
	    <label class="radio-inline" for="Networking_Reception-1">
	      <input type="radio" name="Networking_Reception" id="Networking_Reception-1" value="meet_no">
	      No
	    </label>
	  </div>
	</div>  -->

	<!-- Select Basic -->
	<!--
	<div class="form-group">
	  <label class="col-md-4 control-label" for="select_algorithm">Crypto Algorithm</label>
	  <div class="col-md-4">
	    <select id="select_algorithm" name="select_algorithm" class="form-control input-md">
	      <option value="HS256">HMAC using SHA-256 hash algorithm</option>
	      <option value="HS384">HMAC using SHA-384 hash algorithm</option>
	      <option value="HS512">HMAC using SHA-512 hash algorithm</option>
	    </select>
	  </div>
	</div>  -->

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="email">Địa chỉ E-mail</label>  
	  <div class="col-md-4">
	  <input id="contacts" name="contacts" type="text" placeholder="eg: admin@domain.com" class="form-control input-md" required="">
	    
	  </div>
	</div>

	<!-- Button -->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="submit"></label>
	  <div class="col-md-4">
	    <button id="submit" name="submit" class="btn btn-primary">SUBMIT</button>
	  </div>
	</div>

	</fieldset>
	</form>
@stop

