<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <style>
        /* Default width for all screens */
        #logo-app {
            width: 30%;
        }

        /* Small screens (mobile) */
        @media (max-width: 767px) {
            #logo-app {
                width: 60%;
            }
        }

        /* Extra-large screens */
        @media (min-width: 1200px) {
            #logo-app {
                width: 30%;
            }
        }
    </style>
    <!-- Sidebar - Brand -->
    <div class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('dashboard/img/logo.png') }}" alt="" id="logo-app">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
            <div class="sidebar-brand-text">{{ env('APP_NAME') }}</div>
        </div>
    </div>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item -->
    @if (Auth::user()->role !== 3)
        <li class="nav-item {{ Request::is('panel*') ? 'active' : '' }}">
            <a class="nav-link " href="/panel">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endif
    <li class="nav-item {{ Request::is('products*') ? 'active ' : '' }}">
        <a class="nav-link " href="/products">
            <i class="fa-solid fa-hands-holding"></i>
            <span>Layanan</span></a>
    </li>
    @can('superadmin')
        <li class="nav-item {{ Request::is('people*') ? 'active ' : '' }}">
            <a class="nav-link " href="/people">
                <i class="fa-solid fa-people-group"></i>
                <span>Karyawan</span></a>
        </li>
        <li class="nav-item {{ Request::is('users*') ? 'active ' : '' }}">
            <a class="nav-link " href="/users">
                <i class="fa-solid fa-users"></i>
                <span>Pengguna</span></a>
        </li>
    @endcan
    @can('admin')
        <li class="nav-item {{ Request::is('users*') ? 'active ' : '' }}">
            <a class="nav-link " href="/users">
                <i class="fa-solid fa-users"></i>
                <span>Pengguna</span></a>
        </li>
    @endcan
    <li class="nav-item {{ Request::is('orders*') ? 'active ' : '' }}">
        <a class="nav-link " href="/orders">
            <i class="fa-solid fa-people-carry-box"></i>
            <span>Pesanan</span></a>
    </li>
    @can('superadmin')
        <li class="nav-item {{ Request::is('report*') ? 'active ' : '' }}">
            <a class="nav-link " href="/report">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Laporan</span></a>
        </li>
    @endcan





    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
