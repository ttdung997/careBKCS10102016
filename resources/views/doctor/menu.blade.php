<style>
    .dropdown>ul{display: none;}
    .dropdown:hover ul{
        display: block;
    }
    .notification {
        position:absolute;
        top: 12px;
        font-size:.7em;
        background:red;
        color:white;
        width:18px;height:18px;
        text-align:center;
        line-height:18px;
        border-radius:50%;
        box-shadow:0 0 1px #333;
        display: none;
    }
</style>

<li {{{ (Request::is('doctor/index') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-index') }}">
        <svg class="glyph stroked dashboard-dial">
            <use xlink:href="#stroked-dashboard-dial"></use>
        </svg>
        Chào mừng
    </a>
</li>
<?php 
$Islocal = DB::table('users')->where('id', Auth::user()->id)->first()->is_local;
if($Islocal){
?>
<li {{{ (Request::is('doctor/info') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-info') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Thông tin cá nhân</a>
</li>
<li {{{ (Request::is('doctor/list') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-list') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách chờ khám</a>
     <div id="Wait1" class="notification"></div>
</li>
<li {{{ (Request::is('doctor/waitForTestList') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-for-test-list') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách chờ kết quả xét nghiệm</a>
</li>
<li {{{ (Request::is('doctor/diagnodeList') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-diagnode-list') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách chẩn đoán</a>
    <div id="Wait2" class="notification"></div>
</li>
<li {{{ (Request::is('doctor/compeleteList') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-compelete-list') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách kết quả</a>
</li>
<li {{{ (Request::is('doctor/search') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-search') }}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Tìm bệnh nhân</a>
</li>

    
<script>
        function load() {
            $.ajax({
                type: 'GET',
                url: '/doctor/getListNotice',
                data: '_token = <?php echo csrf_token() ?>',
                success: function (data) {
                    if (data.Wait1 !== 0) {
                        document.getElementById('Wait1').innerHTML = "  " + data.Wait1 + "  ";
                        document.getElementById('Wait1').style.display = "block";
                    } else
                        document.getElementById('Wait1').style.display = "none";
                    if (data.Wait2 !== 0) {
                        document.getElementById('Wait2').innerHTML = "  " + data.Wait2 + "  ";
                        document.getElementById('Wait2').style.display = "block";
                    } else
                         document.getElementById('Wait2').style.display = "none";

                }
            });
        }
        load();
        window.setInterval(function () {
            load();
        }, 10000);
    </script>
<?php
}
?>

<li class="dropdown">
    <a ><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Khám sức khỏe</a>
    <ul>
        <li {{{ (Request::is('doctor/medical_list') ? 'class=active' : '') }}}>
            <a href="{{ route('doctor-medical-list') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách khám sức khỏe</a>
        </li>
        <li {{{ (Request::is('doctor/medical_list_complete') ? 'class=active' : '') }}}>
            <a href="{{ route('doctor-medical-list-complete') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách kết quả  khám sức khỏe</a>
        </li>
    </ul>
<li>
<li role="presentation" class="divider"></li>
<li {{{ (Request::is('doctor/about') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-about') }}"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Giới thiệu</a>
</li>
