<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Pengguna Lulusan</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
    <link href="{{ asset('/startbootstrap-sb-admin-gh-pages/css/styles.css') }}" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">

    @include('layoutPenggunaLulusan.navbar') <!-- Navbar -->
    <div id="layoutSidenav">
        @include('layoutPenggunaLulusan.sidebar') <!-- Sidebar -->

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @include('layoutPenggunaLulusan.footer') <!-- Footer -->

    <!-- JavaScript Dependencies (Order matters) -->
    <!-- jQuery (wajib sebelum plugin lain) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Simple DataTables (optional untuk datatables bawaan SB Admin) -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>

    <!-- Chart.js & Demo -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('/startbootstrap-sb-admin-gh-pages/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/startbootstrap-sb-admin-gh-pages/assets/demo/chart-bar-demo.js') }}"></script>

    <!-- Template Script -->
    <script src="{{ asset('/startbootstrap-sb-admin-gh-pages/js/scripts.js') }}"></script>
    <script src="{{ asset('/startbootstrap-sb-admin-gh-pages/js/datatables-simple-demo.js') }}"></script>

    <!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    @yield('scripts') <!-- Tambahan script per halaman -->
</body>
</html>
