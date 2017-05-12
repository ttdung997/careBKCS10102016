<li {{ (Request::is('staff/index') ? 'class=active' : '') }}>
    <a href="index">
        <svg class="glyph stroked dashboard-dial">
            <use xlink:href="#stroked-dashboard-dial"></use>
        </svg>
        Chào mừng
    </a>
</li>
<li {{ (Request::is('staff/department') ? 'class=active' : '') }}>
    <a href="patient"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Quản lý bệnh nhân</a>
</li>
<li {{ (Request::is('admin/medicalApplication') ? 'class=active' : '') }}>
    <a href="medicalApplication"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Danh sách chờ khám</a>
</li>