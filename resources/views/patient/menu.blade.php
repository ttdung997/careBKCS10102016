
<style>
    .dropdown>ul{display: none;}
    .dropdown:hover ul{
        display: block;
    }
</style>

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
<li class="dropdown">
    <a ><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Đăng kí khám</a>
    <ul>
        <li {{{ (Request::is('patient/register') ? 'class=active' : '') }}}>
            <a href="register"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Đăng ký khám sức khỏe</a>
        </li>
        <li {{{ (Request::is('patient/registerS') ? 'class=active' : '') }}}>
            <a href="registerS"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Đăng ký khám chuyên khoa</a>
        </li>
        <li {{{ (Request::is('patient/testRegister') ? 'class=active' : '') }}}>
            <a href="testRegister"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Đăng ký xét nghiệm</a>
        </li>
    </ul>
<li>
<li class="dropdown">
    <a ><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Sổ khám bệnh</a>
    <ul>
        <li {{{ (Request::is('patient/history') ? 'class=active' : '') }}}>
            <a href="history"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Hồ sơ chưa hoàn thiện</a>
        </li>
        <li {{{ (Request::is('patient/health_history') ? 'class=active' : '') }}}>
            <a href="health_history"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Khám sức khỏe</a>
        </li>
        <li {{{ (Request::is('patient/specialist_history') ? 'class=active' : '') }}}>
            <a href="specialist_history"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Khám chuyên khoa</a>
        </li>
        <li {{{ (Request::is('patient/test_history') ? 'class=active' : '') }}}>
            <a href="test_history"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg>Xét nghiệm</a>
        </li>
    </ul>
</li>

<li role="presentation" class="divider"></li>

<li {{{ (Request::is('patient/about') ? 'class=active' : '') }}}>
    <a href="about"><svg class="glyph stroked star"><use xlink:href="#stroked-star"></use></svg> Giới thiệu</a>
</li>
