

<li {{{ (Request::is('patient/index') ? 'class=active' : '') }}}>
    <a href="index">
        <svg class="glyph stroked dashboard-dial">
            <use xlink:href="#stroked-dashboard-dial"></use>
        </svg>
        Chào mừng
    </a>
</li>
<li {{{ (Request::is('patient/info') ? 'class=active' : '') }}}>
    <a href="info"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Thông tin cá nhân</a>
</li>
<li {{{ (Request::is('patient/register') ? 'class=active' : '') }}}>
    <a href="register"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Đăng ký khám</a>
</li>
<li {{{ (Request::is('patient/history') ? 'class=active' : '') }}}>
    <a href="history"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Sổ khám bệnh</a>
</li>

<li role="presentation" class="divider"></li>

<li {{{ (Request::is('patient/about') ? 'class=active' : '') }}}>
    <a href="about"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Giới thiệu</a>
</li>
