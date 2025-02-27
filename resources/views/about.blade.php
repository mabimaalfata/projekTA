@extends('layout.source')
@section('content')
<title>about</title>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="/"><img src="assets/landing/img/hero-bg.jpg" >TK ISLAM HASANUDDIN</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a class="active" href="/about">Tentang</a></li>
                <li><a href="contact">Kontak</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        <a href="{{ route('login') }}" class="get-started-btn">{{Auth::check() ? 'Dashboard' : 'Masuk'}}</a>    </div>
</header><!-- End Header -->
<main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs" data-aos="fade-in">
        <div class="container">
            <h2>Tentang Kami</h2>
            <p>"Menyiapkan peserta didik untuk jenjang lebih tinggi dengan pengembangan potensi optimal dan nilai-nilai Islami yang kuat." </p>
        </div>
    </div><!-- End Breadcrumbs -->

    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                    <img src="assets/landing/img/hero-bg.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                    <h3>VISI & MISI.</h3>
                    <p class="fst-italic">
                    <h2>VISI.</h2>
                    </p>
                    <ul>
                        <li>
                            <h4><i class="bi bi-check-circle"></i>
                                Membentuk generasi yang bertaqwa, berakhlak, terampil, mandiri, kreatif, sehingga mampu menjadi individu yang berkualitas dan berprestasi dalam dunia Pendidikan.</h4>
                        </li>
                    </ul>
                    <p class="fst-italic">
                    <h2>MISI</h2>
                    </p>
                    <ul>
                        <li>
                            <h4><i class="bi bi-check-circle"></i>
                                Mengembangkan pembelajaran Islami.</h4>
                        </li>
                        <li>
                            <h4><i class="bi bi-check-circle"></i>
                                Menciptakan rasa aman dalam kehidupan sehari-hari melalui keteladanan dan kebiasaan.</h4>
                        </li>
                        <li>
                            <h4><i class="bi bi-check-circle"></i>
                                Mengembangkan bakat minat anak dan minat kreativitas anak.</h4>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="masuk" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Masuk ke Dashboard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Masuk</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

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

</main><!-- End #main -->
@endsection