<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/panel">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME') }}</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item -->
    <li class="nav-item {{ Request::is('panel*') ? 'active' : '' }}">
        <a class="nav-link " href="/panel">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ Request::is('products*') ? 'active ' : '' }}">
        <a class="nav-link " href="/products">
            <i class="fa-solid fa-hands-holding"></i>
            <span>Layanan</span></a>
    </li>
    <li class="nav-item {{ Request::is('people*') ? 'active ' : '' }}">
        <a class="nav-link " href="/people">
            <i class="fa-solid fa-people-group"></i>
            <span>Karyawan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    {{-- <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

</ul>
