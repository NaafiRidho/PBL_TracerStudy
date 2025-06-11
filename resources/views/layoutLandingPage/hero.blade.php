@extends('layoutLandingPage.app')

@section('content')
<section class="hero-section position-relative overflow-hidden" style="background-color: #1d4582;">
    <div class="container fluid py-5">
        <div class="row align-items-center min-vh-75 py-5">
            <div class="col-lg-6 mb-5 mb-lg-0 text-white position-relative z-index-1">
                <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInDown">
                    Selamat Datang di <span class="text-warning">Tracer Study</span><br>
                    Politeknik Negeri Malang
                </h1>
                <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s" style="color: #ffffff;">
                    Mari bersama-sama meningkatkan kualitas pendidikan melalui partisipasi Anda dalam tracer study kami.
                </p>
                <div class="d-flex flex-wrap gap-3 animate__animated animate__fadeInUp animate__delay-1s">
                    <a href="{{url('/login/email')}}" class="btn btn-light rounded-pill px-4 py-3 fw-bold shadow-sm hover-scale" style="color: #004aad;">
                        <i class="fas fa-user-graduate me-2"></i> Isi Tracer Alumni
                    </a>
                    <a href="{{url('/login/email')}}" class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold hover-scale border-2">
                        <i class="fas fa-building me-2"></i> Tracer Stakeholder
                    </a>
                </div>
            </div>
            <div class="col-lg-6 position-relative">
                <img src="{{ asset('startbootstrap-sb-admin-gh-pages/assets/img/ilustrasi.png') }}" 
                     alt="Ilustrasi Tracer Study" 
                     class="img-fluid animate__animated animate__fadeInRight animate__delay-1s" />
            </div>
        </div>
    </div>
</section>

@include('layoutLandingPage.about')
@include('layoutLandingPage.manfaat')
@endsection

@push('styles')
<style>
    /* Tambahkan CSS khusus di sini */
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const animateElements = document.querySelectorAll('.animate__animated');
        const animateOnScroll = function () {
            animateElements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                if (elementPosition < windowHeight - 100) {
                    const animationClass = element.classList.item(1);
                    element.classList.add(animationClass);
                }
            });
        };
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll();
    });
</script>
@endpush
