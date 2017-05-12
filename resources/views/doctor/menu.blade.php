

<li {{{ (Request::is('doctor/index') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-index') }}">
        <svg class="glyph stroked dashboard-dial">
            <use xlink:href="#stroked-dashboard-dial"></use>
        </svg>
        Chào mừng
    </a>
</li>
<li {{{ (Request::is('doctor/info') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-info') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Thông tin cá nhân</a>
</li>
<li {{{ (Request::is('doctor/list') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-list') }}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Danh sách chờ khám</a>
</li>
<li {{{ (Request::is('doctor/search') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-search') }}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Tìm bệnh nhân</a>
</li>
<li role="presentation" class="divider"></li>
<li {{{ (Request::is('doctor/about') ? 'class=active' : '') }}}>
    <a href="{{ route('doctor-about') }}"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Giới thiệu</a>
</li>
