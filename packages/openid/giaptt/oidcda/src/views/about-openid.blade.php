@extends('layouts.app')
@section('title')
   Giới thiệu
@stop

@section('content')
	<style type="text/css">
		#list-group{
			position: fixed;
			top: 100px;
		}
	</style>
	<div class="row">
		<div class="col-md-3">
			<div class="list-group" id="list-group">
			  <a href="#thong-tin-benh-vien" class="list-group-item active">Thông tin bệnh viện</a>
			  <a href="#openid-la-gi" class="list-group-item">OpenID Connect là gì ?</a>
			  <a href="#hd-dk-openid" class="list-group-item">Hướng dẫn đăng ký OpenId Connect</a>
			  <a href="#" class="list-group-item">Porta ac consectetur ac</a>
			  <a href="#" class="list-group-item">Vestibulum at eros</a>
			</div>
		</div>
		<div class="col-md-6" style="border: 1px solid;">
			<h3 id="thong-tin-benh-vien"><b>Thông tin bệnh viện</b></h3>
			<p>
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			</p>

			<h3 id="openid-la-gi"><b>OpenID Connect là gì ?</b></h3>
			<p>
				<b>OpenId Connect</b> là công nghệ giúp đăng nhập (log in) vào một website (có tích hợp OpenId Connect) mà không cần phải tạo tài khoản trên chính website đó.
				<br>
				Cụ thể là <b>OpenId Connect</b> cho phép bạn có thể đăng nhập vào website của bệnh viện A mà không cần đăng ký tài khoản tại đây, bằng cách sử dụng tài khoản của bệnh viện B nào đó. Với giả định là bệnh viện A đã phải đăng ký sử dụng <b>OpenId Connect</b> với bệnh viện B. <br>
				<br>
				Những lợi ích khi sử dụng một website có tích hợp OpenId Connect là: <br>
				<ul>
					<li>Không phải tạo nhiều tài khoản</li>
					<li>Không phải nhớ nhiều username/password</li>
					<li>Tiết kiệm thời gian, không phải đăng nhập nhiều lần</li>
					<li>...</li>
				</ul>
				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			</p>
			<h3 id="hd-dk-openid"><b>Hướng dẫn đăng ký OpenId Connect (Admin only)</b></h3>
			<p>
				1. Để đăng ký sử dụng dịch vụ OpenID Connect của chúng tôi, bạn chỉ cần thực hiện theo hướng dẫn sau:
				<ul>
					<li>Step 1: <br>
						Copy đường link <a href="#">http://benhvien1.com/registration</a> vào ô <b>OpenId Provider</b> trong
						form đăng ký OpenId Connect ở website của bạn.<br>
						<br>
						<img src="{{ URL::asset('img/step1.jpg')}}" alt="profile Pic" height="100%" width="100%">
					</li>

					<li>Step 2: <br>
						Tiếp theo, điền tên Bệnh viện của bạn vào ô <b>Tên Bệnh viện</b>, 
						chọn <b>thời gian tối đa của 1 lần xác thực</b>.
					</li>

					<li>Step 3: <br>
						Điền địa chỉ email của bạn để tiện liên hệ trong trường hợp cần thiết.
					</li>

					<li>Step 4: <br>
						Cuối cùng <b>Submit</b> và đợi phía bệnh viện cung cấp dịch vụ OpenId Connect xác nhận.
					</li>
				</ul>
			</p>

			<p>
				2. Bạn có thể kiểm tra kết quả đăng ký OpenId Connect trong tab <b>List Request</b>, các bệnh viện mà bạn 
				đã đăng ký thành công OpenId Connect với họ trong tab <b>List Provider</b>, những bệnh viện đã đăng ký 
				với bệnh viện của bạn trong tab <b>List Client</b>.
			</p> <br>
			<div style="text-align:center; font-size:30px;"><a href='#' title="Back to top"><b>Trở về đâu trang</b></a></div>
		</div>

		<dir class="col-md-3"></dir>
	</div>
	<script src="{{ URL::asset('themes/js/jquery-1.11.1.min.js') }}"></script>
	<script type="text/javascript">
		$('.list-group a').click(function(e) {
			//e.preventDefault()
		  	$(".list-group a").removeClass("active");
   			$(e.target).addClass("active");
		});
	</script>
@stop