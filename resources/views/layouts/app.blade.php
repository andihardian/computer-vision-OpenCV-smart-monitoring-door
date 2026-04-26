<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Smart Door — {{ $title ?? 'Dashboard' }}</title>

    <!-- Custom fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">

    <!-- SB Admin 2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body { font-family: 'Nunito', sans-serif; }
        .sidebar { background: linear-gradient(180deg, #1B3A6B 10%, #153060 100%) !important; }
        .sidebar .nav-item .nav-link { color: rgba(255,255,255,0.7); }
        .sidebar .nav-item .nav-link:hover,
        .sidebar .nav-item.active .nav-link { color: #fff; }
        .sidebar-brand { background: rgba(0,0,0,0.1) !important; }
        .sidebar-brand-text { font-weight: 800; letter-spacing: 1px; }
        .sidebar-divider { border-top: 1px solid rgba(255,255,255,0.1); }
        .topbar { border-bottom: 1px solid #e3e6f0; }
        .badge-granted { background-color: #1cc88a; color: #fff; }
        .badge-denied  { background-color: #e74a3b; color: #fff; }
        .table td, .table th { vertical-align: middle; }
        .card-header { font-weight: 700; }
        .mono { font-family: 'Courier New', monospace; font-size: 0.8rem; color: #858796; }
    </style>
    @stack('styles')
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
            <div class="sidebar-brand-icon">
                <i class="fas fa-lock"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Smart Door</div>
        </a>

        <hr class="sidebar-divider my-0">

        <!-- Dashboard -->
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">
        <div class="sidebar-heading">Manajemen</div>

        <!-- Devices -->
        <li class="nav-item {{ request()->routeIs('devices.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('devices.index') }}">
                <i class="fas fa-fw fa-microchip"></i>
                <span>Devices</span>
            </a>
        </li>

        <!-- Access Logs -->
        <li class="nav-item {{ request()->routeIs('logs.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('logs.index') }}">
                <i class="fas fa-fw fa-clipboard-list"></i>
                <span>Access Logs</span>
            </a>
        </li>

        @if(auth()->user()->isAdmin())
        <hr class="sidebar-divider">
        <div class="sidebar-heading">Admin</div>

        <!-- Users -->
        <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Manajemen User</span>
            </a>
        </li>
        @endif

        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Title -->
                <span class="d-none d-sm-inline-block font-weight-bold text-gray-800">
                    {{ $title ?? 'Dashboard' }}
                </span>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- User Info -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                {{ auth()->user()->name }}
                                <span class="badge badge-pill {{ auth()->user()->isAdmin() ? 'badge-primary' : 'badge-secondary' }} ml-1">
                                    {{ ucfirst(auth()->user()->role) }}
                                </span>
                            </span>
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                style="width:32px;height:32px">
                                <span class="text-white font-weight-bold" style="font-size:12px">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </span>
                            </div>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profil Saya
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Keluar
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                {{ $slot }}

            </div>
            <!-- End of Page Content -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Smart Door &copy; {{ date('Y') }} — IoT Access Control System</span>
                </div>
            </div>
        </footer>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Keluar</h5>
                <button class="close" type="button" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">Yakin ingin keluar dari sistem?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.1.4/js/sb-admin-2.min.js"></script>
@stack('scripts')

</body>
</html>