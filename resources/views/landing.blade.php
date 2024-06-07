@extends('layout.source')
@section('content')
<title>beranda</title>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
        <p class="logo me-auto">
            <a href="/"><img src="assets/landing/img/hero-bg.jpg" >TK ISLAM HASANUDDIN</a></p>
        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="active" href="#">Beranda</a></li>
                <li><a href="about">Tentang</a></li>
                <li><a href="contact">Kontak</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        <a href="{{ route('login') }}" class="get-started-btn">{{Auth::check() ? 'Dashboard' : 'Masuk'}}</a>
    </div>
</header><!-- End Header -->

<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
        <h1>Selamat Datang di TK Islam Hasanudin</h1>
        <p> </p>
        <h2>Ayo Bermain dan Belajar</h2>
        <h2>"Pendidikan adalah senjata terkuat yang bisa kau gunakan untuk merubah dunia,<br> mendidik dengan akhlak dan ilmu."</h2>
        <a href="#about" class="cta-button">Pelajari Lebih Lanjut</a>
    </div>
</section><!-- End Hero -->


<main id="main">

    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                    <img src="assets/landing/img/hero-bg.jpg" class="" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                    <p class="fst-italic">
                        <h2>Metode Pembelajaran Islam</h2>
                        <ul>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Pendidikan yang mengedepankan nilai-nilai Islam</h4>
                            </li>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Pembelajaran Al-Quran dan Hadis</h4>
                            </li>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Pembinaan akhlak dan karakter islami</h4>
                            </li>
                        </ul>
                        
                        <h2>Fasilitas Lengkap</h2>
                        <ul>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Sarana prasarana yang mendukung kegiatan belajar mengajar</h4>
                            </li>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Perpustakaan dengan koleksi buku yang lengkap</h4>
                            </li>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Ruang kelas ber-AC</h4>
                            </li>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Area bermain yang aman dan nyaman</h4>
                            </li>
                        </ul>
                        
                        <h2>Guru Berpengalaman</h2>
                        <ul>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Tenaga pengajar yang profesional dan berkompeten</h4>
                            </li>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Guru dengan pengalaman mengajar lebih dari 10 tahun</h4>
                            </li>
                            <li>
                                <h4><i class="bi bi-check-circle"></i> Pelatihan dan pengembangan berkala untuk guru</h4>
                            </li>
                        </ul>
                        
                    </li>
                </ul>
                </div>
            </div>

        </div>
    </section><!-- End About Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

    <div class="footer-top">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-6 footer-contact">
                    <h3>Alamat</h3>
                    <p>
                        Jl. Brotojoyo Bar. II No.26 <br>
                        Panggung Kidul, Kec. Semarang Utara<br>
                        Kota Semarang, Jawa Tengah 50178 <br><br>
                        <strong>Phone:</strong> 0821 3486 3529<br>
                        <strong>Email:</strong> tk.islamhasanuddin@gmail.com <br>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container d-md-flex py-4">

        <div class="me-md-auto text-center text-md-start">
            <div class="copyright">
                &copy; Copyright <strong><span>TKIslamHasanuddin</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
            </div>
        </div>
    </div>
</footer><!-- End Footer -->

<div id="preloader"></div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

<script>
const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
</script>
@endsection