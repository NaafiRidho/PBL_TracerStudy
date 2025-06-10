<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Core CSS --}}
    <link href="{{ asset('/startbootstrap-sb-admin-gh-pages/css/styles.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css">

    {{-- Font Awesome --}}
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    {{-- Libraries CSS --}}
    {{-- Menggunakan Bootstrap 5 DataTables styling --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.css" rel="stylesheet">

    {{-- Custom CSS dari view anak --}}
    @stack('css')
</head>

<body class="sb-nav-fixed">

    @include('layoutAdmin.navbar')
    <div id="layoutSidenav">
        @include('layoutAdmin.sidebar')

        <div id="layoutSidenav_content">
            <main>
                @yield('content')
            </main>
        </div>
    </div>

    @include('layoutAdmin.footer')

    {{-- Core JavaScript Libraries (Urutan PENTING!) --}}

    {{-- 1. jQuery (harus paling awal karena banyak lib lain bergantung padanya) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- 2. Bootstrap Bundle (termasuk Popper.js untuk komponen seperti modal dan dropdown) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    {{-- 3. SB Admin Core Scripts --}}
    <script src="{{ asset('/startbootstrap-sb-admin-gh-pages/js/scripts.js') }}"></script>

    {{-- 4. Chart.js (jika digunakan untuk grafik) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('/startbootstrap-sb-admin-gh-pages/assets/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('/startbootstrap-sb-admin-gh-pages/assets/demo/chart-bar-demo.js') }}"></script>

    {{-- 5. jQuery DataTables (pastikan ini yang Anda gunakan, bukan Simple-DataTables) --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> {{-- Integrasi DataTables dengan Bootstrap 5 --}}

    {{-- 6. jQuery Validation Plugin --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    {{-- 7. SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.24/dist/sweetalert2.min.js"></script>

    {{-- Global AJAX Setup untuk CSRF Token --}}
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    </script>

    {{-- Fungsi untuk Memuat Modal Secara Dinamis --}}
    <script>
        function modalAction(url) {
            // Hapus modal sebelumnya yang mungkin ada di DOM
            $('.modal').remove();

            // Buat div modal placeholder yang baru. Ini penting karena
            // konten modal akan di-load ke dalamnya.
            $('body').append('<div id="myModal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true"></div>');

            // Load konten HTML modal dari URL yang diberikan
            $('#myModal').load(url, function() {
                // Setelah konten modal berhasil dimuat ke dalam #myModal, tampilkan modalnya
                $('#myModal').modal('show');

                // Trigger event kustom. Ini berguna agar script di dalam form modal
                // (misalnya inisialisasi jQuery Validate) dapat dieksekusi setelah modal dimuat.
                // Anda perlu menambahkan listener untuk event ini di file modal form Anda.
                $(document).trigger('modalLoaded');
            });
        }
    </script>

    {{-- Stack untuk script spesifik halaman, taruh di paling bawah --}}
    @stack('js')

</body>

</html>