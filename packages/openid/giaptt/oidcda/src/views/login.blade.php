@extends('oidcda::app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div >
                    @if(isset($err))
                        {{ $err }}
                    @endif
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}" name="myForm" onsubmit="return hashPassword()">
                        {{ csrf_field() }}
                        <input type="hidden" name="_hashPass" value="">
                        <input type="hidden" name="_sess_id" value="{{ $sess_id }}">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <div class="row">
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            Login
                                        </button>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <select id="mySelect" onchange="myFunction()" class="form-control">
                                                <option value="" selected="true">Choose an OpenId Server </option>
                                                @foreach ($list_op as $key => $value)
                                                    <option value ="{{ $value['authen_endpoint'] }}">{{ $value['name_provider'] }}</option>
                                                @endforeach
                                                <script>
                                                    function myFunction() {
                                                        
                                                        var txt = document.getElementById("mySelect").value;
                                                        // window.location = url_send_request + "?option=" + value_of_option;
                                                        var url_send_request = "<?php echo config('OpenidConnect.url_rp_idp'); ?>";
                                                        window.location = url_send_request + "?option=" + txt;
                                                        
                                                    }
                                                </script>
                                            </select> 
                                        </div>
                                    </div>

                                    <div class="">
                                        <a class="btn btn-link" href="#">Forgot Your Password?</a>
                                    </div>
                                </div>                   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>

  <script type="text/javascript" >
    function hashPassword(){
      // get pass ng dùng nhập vào
      // var inPass = document.forms['myForm']['password'].value;
      var inPass = document.getElementById('password').value;
      // get session_id from server
      var sess_id = document.forms['myForm']['_sess_id'].value;
      // băm pass, session_id
      var hashPass = CryptoJS.SHA256(inPass);
      // nối chuỗi hashPass với hashSess, và tiến hành băm
      var hPwdSess = CryptoJS.SHA256(hashPass + sess_id);

      // set lại url, rồi gửi đến server
      document.forms['myForm']['_hashPass'].value = hPwdSess;
      
      return true;

      
    }

  </script>