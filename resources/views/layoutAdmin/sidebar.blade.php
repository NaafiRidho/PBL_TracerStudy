<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
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
                                <a class="nav-link" href="{{ url('/admin/atasan-belum-mengisi') }}">
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

                <div class="sb-sidenav-menu-heading">Interface</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                    aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                    Layouts
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="#">Static Navigation</a>
                        <a class="nav-link" href="#">Light Sidenav</a>
                    </nav>
                </div>

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Authentication
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="{{ url('login') }}">Login</a>
                                <a class="nav-link" href="{{ url('register') }}">Register</a>
                                <a class="nav-link" href="{{ url('password/reset') }}">Forgot Password</a>
                            </nav>
                        </div>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link" href="#">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            Start Bootstrap
        </div>
    </nav>
</div>