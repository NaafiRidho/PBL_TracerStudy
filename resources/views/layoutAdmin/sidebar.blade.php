<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-header d-flex flex-column align-items-center"
            style="padding-top: 0.3rem; padding-bottom: 0.3rem;">
            <img class="logo-animated" src="{{ asset('startbootstrap-sb-admin-gh-pages/assets/img/logoTC.png') }}"
                alt="Logo" style="height: 80px; margin-right: 5px;">
            <div class="text-white fw-semibold" style="font-size: 1.1rem;">Admin Panel</div>
            <div class="text-muted" style="font-size: 0.85rem;">Teknologi Informasi</div>
        </div>
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ url('/admin') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseRekapData"
                    aria-expanded="false" aria-controls="collapseRekapData">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Rekap Data
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>

                <div class="collapse" id="collapseRekapData" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="accordionRekap">

                        {{-- Belum Mengisi --}}
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseBelumMengisi" aria-expanded="false"
                            aria-controls="collapseBelumMengisi">
                            <i class="fas fa-clock me-2"></i> Belum Mengisi
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseBelumMengisi" data-bs-parent="#accordionRekap">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/admin/alumni-belum-mengisi') }}">
                                    <i class="fas fa-user-graduate me-2"></i> Rekap Alumni
                                </a>
                                <a class="nav-link" href="{{ url('/admin/atasan/belum-mengisi') }}">
                                    <i class="fas fa-user-tie me-2"></i> Rekap Atasan
                                </a>
                            </nav>
                        </div>

                        {{-- Sudah Mengisi --}}
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseSudahMengisi" aria-expanded="false"
                            aria-controls="collapseSudahMengisi">
                            <i class="fas fa-check-circle me-2"></i> Sudah Mengisi
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseSudahMengisi" data-bs-parent="#accordionRekap">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('/admin/alumni-sudah-mengisi') }}">
                                    <i class="fas fa-user-check me-2"></i> Survei Alumni
                                </a>
                                <a class="nav-link" href="{{ url('/admin/atasan-sudah-mengisi') }}">
                                    <i class="fas fa-clipboard-check me-2"></i> Survei Atasan
                                </a>
                            </nav>
                        </div>

                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Manajemen Data</div>

                <a class="nav-link" href="{{ url('admin/profesi') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                    Profesi
                </a>
                <a class="nav-link" href="{{ url('admin/alumni') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                    Manajemen Alumni
                </a>
                <a class="nav-link" href="{{ url('admin/pertanyaan') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                    Pertanyaan
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Tracer Study Admin
        </div>
    </nav>
</div>

<style>
    .sb-nav-fixed .sb-topnav {
        z-index: 1000;
        /* Lebih rendah dari sidebar */
        position: fixed;
        top: 0;
        width: 100%;
    }

    #layoutSidenav #layoutSidenav_nav {
        z-index: 1050;
        /* Lebih tinggi dari navbar */
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
    }

    /* Terapkan font ke seluruh sidebar */
    .sb-sidenav {
        font-family: 'Poppins', sans-serif;
    }

    .sb-sidenav-menu-heading {
        font-size: 0.75rem;
        font-weight: 600;
        color: #a0aec0;
        text-transform: uppercase;
        padding: 1rem 1.5rem 0.5rem;
    }

    .nav-link {
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        font-weight: 500;
        color: #cbd5e0;
        /* abu-abu terang */
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
        border-radius: 0.375rem;
        padding-left: 1.5rem;
        white-space: nowrap;
        /* Mencegah teks turun ke baris baru */
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nav-link:hover {
        background-color: #2d3748;
        /* abu gelap */
        color: #ffffff;
        border-left: 4px solid #3b82f6;
        /* biru */
    }

    .nav-link.active {
        background-color: #1e293b;
        color: #ffffff;
        font-weight: 600;
        border-left: 4px solid #3b82f6;
    }

    .sb-sidenav-footer {
        font-family: 'Poppins', sans-serif;
        font-size: 0.85rem;
        font-weight: 500;
        color: #cbd5e0;
        padding: 1rem 1.5rem;
    }
</style>