<!-- Layout cho bs vien ngoai -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title')
    </title>


    <link href="{{ URL::asset('themes/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('themes/css/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('themes/css/styles.css') }}" rel="stylesheet">

    <!--Icons-->
    <script src="{{ URL::asset('themes/js/lumino.glyphs.js') }}"></script>

    <!--[if lt IE 9]>
    <script src="{{ URL::asset('themes/js/html5shiv.js') }}"></script>
    <script src="{{ URL::asset('themes/js/respond.min.js') }}"></script>
    <![endif]-->

</head>

<body>
    <!-- giáp: thêm iframe để kiểm tra trạng thái của user tại OP  -->
    <input type="hidden" id="client_id" value="{{ $client_id }}">
    <input type="hidden" id="ss_endpoint" value="{{ $ss_endpoint }}">
    <iframe src="{{ $ss_endpoint }}" id="iframeOP" frameborder="0" width="0" height="0">
        <p>Your browser is not support iframe.</p>
    </iframe> <br> <!-- giáp: hết -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>Hệ thống</span> ĐĂNG KÍ KHÁM BỆNH</a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                        {{ Authen::getCurrentUser() }} 

                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/doctor/info') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Thông tin cá nhân</a></li>
                        <li>
                            <a href="{{ url('/logout-ex') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                 <svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg>
                                Đăng xuất
                            </a>

                            <form id="logout-form" action="{{ url('/logout-ex') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

    <ul class="nav menu">
        @include('oidcda::menu')
    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        
    </div><!--/.row-->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">@yield('title')</h1>
        </div>
    </div><!--/.row-->
    <div class="row">
        <div class="col-lg-12">
            @yield('content')
        </div>
    </div>

</div>	<!--/.main-->

<script src="{{ URL::asset('themes/js/jquery-1.11.1.min.js') }}"></script>
<script src="{{ URL::asset('themes/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('themes/js/chart.min.js') }}"></script>
<script src="{{ URL::asset('themes/js/chart-data.js') }}"></script>
<script src="{{ URL::asset('themes/js/easypiechart.js') }}"></script>
<script src="{{ URL::asset('themes/js/easypiechart-data.js') }}"></script>
<script src="{{ URL::asset('themes/js/bootstrap-datepicker.js') }}"></script>
<script>
    $('#calendar').datepicker({
    });

    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

    $(window).on('resize', function () {
        if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
    })
    $(window).on('resize', function () {
        if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
    })
</script>
<!-- giáp: phần xử lý kiểm tra user đã logout khỏi OP hay chưa -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/sha256.js"></script>
<script type="text/javascript">
    window.onload = function()
    {
        var stat = "unchanged";
        // client_id phải lấy từ server (php)
        // server sẽ gửi vào 1 trường ẩn, rồi dùng JS get ra.
        var client_id = $('#client_id').val();
        var ss_endpoint = $('#ss_endpoint').val();
        //$('#iframeOP').attr('src', ss_endpoint);
        var origin = "<?php echo config('OpenidConnect.url_origin'); ?>";
        var opss = getSttFromCookie('sess_stt');
        console.log('url iframe: ' + document.getElementById("iframeOP").src );
        //var mes = client_id + origin + opss + salt + "." + salt
        var targetOP = document.getElementById("iframeOP").src;
        var salt = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
        var mes = CryptoJS.SHA256(client_id + origin + opss + salt) + "." + salt;
        
        console.log('mes: ' + mes);

        function check_status()
        {
            var win = document.getElementById('iframeOP').contentWindow;
            win.postMessage(mes, targetOP);
        }

        var myVar = setInterval(check_status, 3*1000);
        window.addEventListener("message", receivedMessage, false);

        function receivedMessage(e)
        {
            var targetOrigin = "http://localhost:8080";
            //console.log('e.origin = ' + e.origin);
            //console.log('e.data = ' + e.data);
            // if (e.origin !== targetOrigin)
            // {
            //     return;
            // }
            stat = e.data;
            // dosomething with stat
            noticeToParentWindow(stat);
            
        }

        // hàm thực hiện kiểm tra message phản hồi từ OP
        function noticeToParentWindow(stat)
        {
            if(stat == "changed")
            {
                // user đã logout khỏi OP
                // thực hiện force logout user khỏi RP.
                document.write("Bạn đã Logout khỏi OP, sẽ bị logout sau 5 seconds ...");
                setTimeout(function(){
                    var url_redirect = "<?php echo config('OpenidConnect.url_force_logout'); ?>";
                    console.log("url: " + url_redirect);
                    window.location = url_redirect;
                }, 5000);
                clearInterval(myVar);
            }
            else if(stat == "error")
            {
                console.log("message is syntax incorrect !");
            }
        }

        // get the window displayed in the iframe
        //var receiver = document.getElementById('receiver').contentWindow;
        function getSttFromCookie(name)
        {
            var allCookie = document.cookie;
            var cookieArray = allCookie.split('; ');

            // now take key-value pair of this array
            for (var i = 0; i < cookieArray.length; i++) 
            {
                var key = cookieArray[i].split('=')[0];
                if (key == name)
                {
                    return cookieArray[i].split('=')[1];
                    break;
                }
            }
            return null;
        }
        console.log("load!");
    }
</script>  <!--giáp: hết -->  
</body>

</html>
