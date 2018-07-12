<li {{ (Request::is('admin/index') ? 'class=active' : '') }}>
    <a href="index">
        <svg class="glyph stroked dashboard-dial">
            <use xlink:href="#stroked-dashboard-dial"></use>
        </svg>
        Chào mừng
    </a>
</li>
<li {{ (Request::is('admin/department') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.department')!!}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Quản lý khoa</a>
</li>
<li {{ (Request::is('admin/degree') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.degree')!!}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Quản lý học vị</a>
</li>
<li {{ (Request::is('admin/office') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.office')!!}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Quản lý chức vụ</a>
</li>
<li {{ (Request::is('admin/room') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.room')!!}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Quản lý phòng</a>
</li>
<li {{ (Request::is('admin/MedicalTestType') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.MedicalTestType')!!}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Quản lý loại xét nghiệm</a>
</li>
<li {{ (Request::is('admin/doctor') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.doctor')!!}"><svg class="glyph stroked pencil"><use xlink:href="#stroked-pencil"></use></svg> Quản lý bác sỹ</a>
</li>
<li {{ (Request::is('admin/staff') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.staff')!!}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Quản lý nhân viên</a>
</li>
<li {{ (Request::is('admin/role') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.role')!!}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Quản lý Role</a>
</li>
<!-- <li {{ (Request::is('admin/hospital') ? 'class=active' : '') }}>
    <a href="{!!URL::route('AdminController.index.hospital')!!}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Quản lý danh sách các bệnh viện đối tác</a>
</li> -->
<li {{ (Request::is('') ? 'class=active' : '') }}>
    <a href="#"><svg class="glyph stroked table"><use xlink:href="#stroked-table"></use></svg> Quản lý thông tin bệnh viện</a>
</li>
<!-- giáp: thêm item đăng ký Openid Connect -->
<li {{ (Request::is('admin/register-openid') ? 'class=active' : '') }}>
    <a href="{{ route('admin-register-openid') }}"><i class="fa fa-openid" aria-hidden="true"></i> &nbsp&nbsp OpenId Connect</a>
</li>

<li {{ (Request::is('admin/list-providers') ? 'class=active' : '') }}>
    <a href="{{ route('admin-list-providers') }}"><i class="fa fa-openid" aria-hidden="true"></i> &nbsp&nbsp List Providers</a>
</li>

<li {{ (Request::is('admin/list-clients') ? 'class=active' : '') }}>
    <a href="{{ route('admin-list-clients') }}"><i class="fa fa-openid" aria-hidden="true"></i> &nbsp&nbsp List Clients</a>
</li>

<li {{ (Request::is('admin/list-requests') ? 'class=active' : '') }}>
    <a href="{{ route('admin-list-requests') }}"><i class="fa fa-openid" aria-hidden="true"></i> &nbsp&nbsp List Requests</a>
</li>
<!-- giáp: hết -->
