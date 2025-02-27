@extends('layout.source')
@section('content')
<title>contact</title>
<!-- ======= Header ======= -->
<header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="/"><img src="assets/landing/img/hero-bg.jpg" >TK ISlAM HASANUDDIN</a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo me-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a href="/">Beranda</a></li>
                <li><a href="/about">Tentang</a></li>
                <li><a class="active" href="contact">Kontak</a></li>
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

        <a href="{{ route('login') }}" class="get-started-btn">{{Auth::check() ? 'Dashboard' : 'Masuk'}}</a>    </div>
    </div>
</header><!-- End Header -->
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs" data-aos="fade-in">
        <div class="container">
            <h2>Hubungi Kami</h2>
            <p>"Silakan hubungi kami untuk informasi lebih lanjut atau pertanyaan lainnya." </p>
        </div>
    </div><!-- End Breadcrumbs -->
    <section id="about" class="about">
        <div class="container" data-aos="fade-up">

            <div class="row">
                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                    <img src="assets/landing/img/hero-bg.jpg" class="img-fluid" alt="">
                </div>
                <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                    <h3>Hubungi Kami </h3>
                    <p class="fst-italic">
                    <h2>Phone</h2>
                    </p>
                    <ul>
                        <li>
                            <h4><i class="class=bi bi-phone"></i>
                                0821 3486 3529</h4>
                                
                        </li>
                    </ul>
                    <p class="fst-italic">
                    <h2>Email</h2>
                    </p>
                    <ul>
                        <li>
                            <h4><i  class="bi bi-envelope"></i>
                                tk.islamhasanuddin@gmail.com</h4>
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

</main><!-- End #main -->
@endsection