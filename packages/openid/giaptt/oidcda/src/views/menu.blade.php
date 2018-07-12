
<!-- giáp: menu cho bác sĩ bệnh viện ngoài -->
<li {{{ (Request::is('doctor/external/index') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-ex-index') }}">
        <svg class="glyph stroked dashboard-dial">
            <use xlink:href="#stroked-dashboard-dial"></use>
        </svg>
        Chào mừng
    </a>
</li>

<li {{{ (Request::is('doctor/external/list-patient-share') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-list-patient-share') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách bệnh nhân</a>
</li>
<!-- giáp: hết -->

<!--
<li {{{ (Request::is('doctor/get-benh-nhan') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-search') }}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Tìm bệnh nhân</a>
</li> -->

<li role="presentation" class="divider"></li>
<li {{{ (Request::is('doctor/external/info') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-ex-info') }}"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Thông tin bác sĩ</a>
</li>
