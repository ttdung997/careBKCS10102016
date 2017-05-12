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

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>Hệ thống</span> Đăng ký khám bệnh</a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                        {{ Auth::user()->name }}

                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/patient/info') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Thông tin cá nhân</a></li>
                        <li>
                            <a href="{{ url('/logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                <svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg>                     
                                Đăng xuất
                            </a>

                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
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
        @include('patient.menu')
    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        @include('patient.breadcrumb')
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
<!-- <script src="{{ URL::asset('themes/js/bootstrap-table.js') }}"></script> -->
<script src="{{ URL::asset('themes/js/ga.js') }}"></script>
<script>
    $('#calendar').datepicker({
        format: 'dd/mm/yyyy'
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
</body>

</html>
