@extends('layoutLandingPage.app')

@section('content')
<!-- Hero Section with Solid Color -->
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
                    <a href="#" class="btn btn-light rounded-pill px-4 py-3 fw-bold shadow-sm hover-scale" style="color: #004aad;">
                        <i class="fas fa-user-graduate me-2"></i> Isi Tracer Alumni
                    </a>
                    <a href="/kuesioner" class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold hover-scale border-2">
                        <i class="fas fa-building me-2"></i> Tracer Stakeholder
                    </a>
                </div>
            </div>
            <div class="col-lg-6 position-relative">
                <img src="{{ asset('startbootstrap-sb-admin-gh-pages/assets/img/ilustrasi.png') }}" alt="Ilustrasi Tracer Study" 
                    class="img-fluid animate__animated animate__fadeInRight animate__delay-1s"
            </div>
        </div>
    </div>
</section>

<!-- About and Benefits Section -->
@include('layoutLandingPage.about')
@include('layoutLandingPage.manfaat')

<style>
    /* Custom Styles */
    .hero-section {
        position: relative;
        overflow: hidden;
    }
    
    .wave-shape {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%23ffffff' fill-opacity='1' d='M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E") no-repeat center bottom;
        background-size: cover;
    }
    
    .floating-animation {
        animation: floating 3s ease-in-out infinite;
    }
    
    @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-15px); }
        100% { transform: translateY(0px); }
    }
    
    .hover-scale {
        transition: all 0.3s ease;
    }
    
    .hover-scale:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    @media (max-width: 991.98px) {
    .hero-section {
        min-height: unset;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
</style>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>

<script>
    // Animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const animateElements = document.querySelectorAll('.animate__animated');
        
        const animateOnScroll = function() {
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
        animateOnScroll(); // Trigger on load for elements already in view
    });
</script>
@endsection