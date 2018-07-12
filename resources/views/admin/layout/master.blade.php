<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base_url" content="{{ URL::to('admin') }}">
    <meta name="_token" content="{!! csrf_token() !!}" />
    <title>
        @yield('title')
    </title>

    <link href="{{ URL::asset('themes/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('themes/css/styles.css') }}" rel="stylesheet">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!--Icons-->
    <script src="{{ URL::asset('themes/js/lumino.glyphs.js') }}"></script>

    <!--[if lt IE 9]>
    <script src="{{ URL::asset('themes/js/html5shiv.js') }}"></script>
    <script src="{{ URL::asset('themes/js/respond.min.js') }}"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>

    @yield('css')
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
            <a class="navbar-brand" href="#"><span>Hệ thống</span> ĐĂNG KÍ KHÁM BỆNH</a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
                        {{ Authen::getEmailAdmin() }}  

                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Thông tin cá nhân</a></li>
                        <!-- <li><a href="{{ url('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Đăng xuất</a>
                        </li> -->
                        <li>
                            <a href="{{ url('/backend/logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ url('/backend/logout') }}" method="POST" style="display: none;">
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
        @include('admin.includes.menu')
    </ul>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        @include('admin.includes.breadcrumb')
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

<script src="{{ URL::asset('themes/js/bootstrap.min.js') }}"></script>
@yield('js')
</body>

</html>
