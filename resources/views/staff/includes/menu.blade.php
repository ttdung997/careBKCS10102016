
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

<li {{ (Request::is('staff/index') ? 'class=active' : '') }}>
    <a href="/staff/index">
        <svg class="glyph stroked dashboard-dial">
        <use xlink:href="#stroked-dashboard-dial"></use>
        </svg>
        Chào mừng
    </a>
</li>
<?php
$chucvu = DB::table('staffs')->where('staff_id', Auth::user()->id)->first()->chucvu;
//kiểm tra xem có phải kĩ sư y tế
if ($chucvu == 7) {
    ?>
    <!--    <li {{ (Request::is('staff/listFutureTestPatient') ? 'class=active' : '') }}>
            <a href="listFutureTestPatient"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Danh sách đăng kí xét nghiệm</a>
        </li>-->
    <li {{ (Request::is('staff/listTestPatient') ? 'class=active' : '') }}>
        <a  data-notifications="10"  href="/staff/listTestPatient"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Danh sách chờ xét nghiệm</a>
        <div id="WaitTest" class="notification"></div>
    </li>
    <li {{ (Request::is('staff/listWaitingTestPatient') ? 'class=active' : '') }}>
        <a  data-notifications="10"  href="/staff/listWaitingTestPatient"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Danh sách chờ kết quả</a>
        <div  id="Waiting" class="notification"></div>
    </li>
    <li {{ (Request::is('staff/listCompeleteTestPatient') ? 'class=active' : '') }}>
        <a href="/staff/listCompeleteTestPatient"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Danh sách kết quả</a>
    </li>
    <script>
        function load() {
            $.ajax({
                type: 'GET',
                url: '/staff/getListNotice',
                data: '_token = <?php echo csrf_token() ?>',
                success: function (data) {
                    //alert(data.Waiting);
                    if (data.WaitTest !== 0) {
                        document.getElementById('WaitTest').innerHTML = "  " + data.WaitTest + "  ";
                        document.getElementById('WaitTest').style.display = "block";
                    } else
                        document.getElementById('WaitTest').style.display = "none";
                    if (data.Waiting !== 0) {
                        document.getElementById('Waiting').innerHTML = "  " + data.Waiting + "  ";
                        document.getElementById('Waiting').style.display = "block";
                    } else
                         document.getElementById('Waiting').style.display = "none";

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
//kiểm tra xem có phải lễ tân
if ($chucvu == 11) {
    ?>
    <li {{ (Request::is('staff/department') ? 'class=active' : '') }}>
        <a href="patient"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Quản lý bệnh nhân</a>
    </li>
    <li  class="dropdown">
        <a><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>khám sức khỏe</a>
        <ul>
            <li {{ (Request::is('staff/listWaitingHealthPatientForTeller') ? 'class=active' : '') }}>
                <a href="listWaitingHealthPatientForTeller"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Danh sách đăng kí</a>
            </li>
            <li {{ (Request::is('staff/listCompeleteHealthPatientForTeller') ? 'class=active' : '') }}>
                <a href="listCompeleteHealthPatientForTeller"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Kết quả</a>
            </li>

        </ul>
    </li>
    <li  class="dropdown">
        <a><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>khám chuyên khoa</a>
        <ul>
            <li {{ (Request::is('staff/listWaitingSpecialistPatientForTeller') ? 'class=active' : '') }}>
                <a href="listWaitingSpecialistPatientForTeller"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Danh sách đăng kí</a>
            </li>
            <li {{ (Request::is('staff/listCompeleteSpecialistPatientForTeller') ? 'class=active' : '') }}>
                <a href="listCompeleteSpecialistPatientForTeller"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>  Kết quả </a>
            </li>

        </ul>
    </li>
    <li  class="dropdown">
        <a><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Xét nghiệm</a>
        <ul>
            <li {{ (Request::is('staff/listWaitingTestPatientForTeller') ? 'class=active' : '') }}>
                <a href="listWaitingTestPatientForTeller"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>  Danh sách đăng kí</a>
            </li>
            <li {{ (Request::is('staff/listCompeleteTestPatientForTeller') ? 'class=active' : '') }}>
                <a href="listCompeleteTestPatientForTeller"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>  Kết quả</a>
            </li>

        </ul>
    </li>
<?php } ?>
