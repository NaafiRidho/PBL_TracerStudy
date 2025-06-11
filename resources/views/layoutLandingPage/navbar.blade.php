<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1d4582;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="{{ asset('startbootstrap-sb-admin-gh-pages/assets/img/Logo-Polinema.png') }}" alt="Logo" width="50">
            <div class="d-flex flex-column">
                <span class="fw-bold text-white">Tracer Study</span>
                <small class="fw-normal text-white" style="font-size: 1rem;">Jurusan Teknologi Informasi</small>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#about-tracer">About</a></li>
                <li class="nav-item"><a class="nav-link" href="#kuesioner">Kuesioner</a></li>
                <li class="nav-item"><a class="nav-link" href="#tentangkami">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
                <li class="nav-item"><a class="btn btn-outline-light rounded-pill ms-2" href="#">Form Alumni</a></li>
                <li class="nav-item"><a class="btn btn-light rounded-pill ms-2" href="{{ url('/') }}">Login</a></li>
            </ul>
        </div>
    </div>
</nav>