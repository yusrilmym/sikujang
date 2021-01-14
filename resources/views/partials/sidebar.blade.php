<aside id="sidebar-wrapper">
<div class="sidebar-brand shadow">
    <a > <img src='{{ asset('img/logo-rsud.png') }}' style="height: 35px !important" alt="RSUD Logo"> {{ env('APP_NAME') }}</a>
    {{-- <a href="">{{ env('APP_NAME') }}</a> --}}
</div>
<div class="sidebar-brand sidebar-brand-sm shadow">
    <img src='{{ asset('img/logo-rsud.png') }}' style="height: 40px !important" alt="RSUD Logo">
    {{-- <a href="#">{{ strtoupper(substr(env('APP_NAME'), 0, 2)) }}</a> --}}
</div>

<ul class="sidebar-menu mt-2">
    <li class="menu-header">Menu</li>
    {{-- <li class="{{ request()->is('/') ? 'active' : '' }}"><a class="nav-link" href="{{ url('/') }}"><i class="fas fa-columns"></i> <span>Welcome</span></a></li> --}}
    <li>
    <router-link to="/home" class="nav-link">
        <i class="fas fa-tachometer-alt"></i>
        <span>Dashboard</span>
    </router-link>
    </li>
    {{-- Pegawai --}}
    {{-- @can('isSys')
    <li>
    <router-link to="/users" class="nav-link">
        <i class="fas fa-user-tie"></i>
        <span>Pegawai</span>
    </router-link>
    </li>
    @endcan --}}
    @can('isSuperAdminAndPlus')
    <li>
        <router-link to="/users" class="nav-link">
            <i class="fas fa-user-tie"></i>
            <span>Pegawai</span>
        </router-link>
    </li>
    @endcan
    {{-- Jadwal Shift --}}
    <li>
    <router-link to="/jadwalshift" class="nav-link">
        <i class="far fa-calendar-check"></i>
        <span>Jadwal Shift</span>
    </router-link>
    </li>
</ul>

<ul class="sidebar-menu">
    @can('isSys')
    <li class="menu-header">Setting</li>
    @endcan
    @can('isSuperAdmin')
    <li class="menu-header">Setting</li>
    @endcan
    {{-- <li>
        <router-link to="/cek" class="nav-link">
        <i class="fas fa-cog"></i>
        <span>cek</span>
        </router-link>
    </li> --}}
    @can('isSys')
    <li>
        <router-link to="/passport" class="nav-link">
            <i class="fas fa-cog"></i>
            <span>Laravel Passport</span>
        </router-link>
    </li>
    @endcan
</ul>
@can('isSys')
<ul class="sidebar-menu">
    <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-server"></i> <span>Master Data</span></a>
    <ul class="dropdown-menu">
        <li>
            <router-link to="/unit" class="nav-link ddmenu">
                <i class="fas fa-building"></i>
                <span>Unit Kerja</span>
            </router-link>
        </li>
        <li>
            <router-link to="/position" class="nav-link ddmenu">
                <i class="fas fa-briefcase"></i>
                <span>Jabatan</span>
            </router-link>
        </li>
        <li>
            <router-link to="/shift" class="nav-link ddmenu">
                <i class="fas fa-clock"></i>
                <span>Waktu Shift</span>
            </router-link>
        </li>
    </ul>
    </li>
</ul>
@endcan
@can('isSuperAdmin')
<ul class="sidebar-menu">
    <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-server"></i> <span>Master Data</span></a>
    <ul class="dropdown-menu">
        <li>
            <router-link to="/unit" class="nav-link ddmenu">
                <i class="fas fa-building"></i>
                <span>Unit Kerja</span>
            </router-link>
        </li>
        <li>
            <router-link to="/position" class="nav-link ddmenu">
                <i class="fas fa-briefcase"></i>
                <span>Jabatan</span>
            </router-link>
        </li>
        <li>
            <router-link to="/shift" class="nav-link ddmenu">
                <i class="fas fa-clock"></i>
                <span>Waktu Shift</span>
            </router-link>
        </li>
    </ul>
    </li>
</ul>
@endcan
{{-- <ul class="sidebar-menu">
    <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Bootstrap</span></a>
    <ul class="dropdown-menu">
        <li><a class="nav-link" href="bootstrap-alert.html">Alert</a></li>
        <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li>
        <li><a class="nav-link" href="bootstrap-breadcrumb.html">Breadcrumb</a></li>
        <li><a class="nav-link" href="bootstrap-buttons.html">Buttons</a></li>
        <li><a class="nav-link" href="bootstrap-card.html">Card</a></li>
        <li><a class="nav-link" href="bootstrap-carousel.html">Carousel</a></li>
        <li><a class="nav-link" href="bootstrap-collapse.html">Collapse</a></li>
        <li><a class="nav-link" href="bootstrap-dropdown.html">Dropdown</a></li>
        <li><a class="nav-link" href="bootstrap-form.html">Form</a></li>
        <li><a class="nav-link" href="bootstrap-list-group.html">List Group</a></li>
        <li><a class="nav-link" href="bootstrap-media-object.html">Media Object</a></li>
        <li><a class="nav-link" href="bootstrap-modal.html">Modal</a></li>
        <li><a class="nav-link" href="bootstrap-nav.html">Nav</a></li>
        <li><a class="nav-link" href="bootstrap-navbar.html">Navbar</a></li>
        <li><a class="nav-link" href="bootstrap-pagination.html">Pagination</a></li>
        <li><a class="nav-link" href="bootstrap-popover.html">Popover</a></li>
        <li><a class="nav-link" href="bootstrap-progress.html">Progress</a></li>
        <li><a class="nav-link" href="bootstrap-table.html">Table</a></li>
        <li><a class="nav-link" href="bootstrap-tooltip.html">Tooltip</a></li>
        <li><a class="nav-link" href="bootstrap-typography.html">Typography</a></li>
    </ul>
    </li>
</ul> --}}
</aside>
