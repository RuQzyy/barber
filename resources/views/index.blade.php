<!doctype html>
<html lang="en">

<head>
    <title>El Jawawi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css?family=DM+Sans:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">


    <div class="site-wrap" id="home-section">

        <div class="site-mobile-menu site-navbar-target">
            <div class="site-mobile-menu-header">
                <div class="site-mobile-menu-close mt-3">
                    <span class="icon-close2 js-menu-toggle"></span>
                </div>
            </div>
            <div class="site-mobile-menu-body"></div>
        </div>



        <header class="site-navbar site-navbar-target" role="banner">

            <div class="container">
                <div class="row align-items-center position-relative">

                    <div class="site-logo d-flex align-items-center">
                        <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">

                            <img src="{{ asset('images/logo.jpeg') }}" alt="EL JAWAWI BARBER"
                                style="width:42px;height:42px;object-fit:cover;border-radius:50%;box-shadow:0 2px 6px rgba(0,0,0,0.2);border:2px solid white;">

                            <span class="logo-text ml-2 d-none d-lg-inline"
                                style="font-weight:600;letter-spacing:0.5px;">
                                EL JAWAWI
                            </span>

                        </a>
                    </div>
                    <div class="col-9  text-right">


                        <span class="d-inline-block d-lg-none"><a href="#"
                                class="text-white site-menu-toggle js-menu-toggle py-5 text-white"><span
                                    class="icon-menu h3 text-white"></span></a></span>



                        <nav class="site-navigation text-right ml-auto d-none d-lg-block">
                            <ul class="site-menu main-menu js-clone-nav ml-auto">

                                <li><a href="#home-section">Home</a></li>

                                <li><a href="#about">Tentang</a></li>

                                <li><a href="#pricing">Layanan</a></li>

                                <li><a href="#course">Kursus</a></li>

                                <li><a href="#gallery">Galeri</a></li>

                                {{-- <li><a href="{{ route('booking') }}" class="nav-link">Booking</a></li> --}}
                                @guest
                                    <li class="active">
                                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                                    </li>
                                @endguest

                                @auth
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="nav-link logout-btn">
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                @endauth

                            </ul>
                        </nav>
                    </div>


                </div>
            </div>

        </header>

        <div class="ftco-blocks-cover-1">
            <div class="site-section-cover overlay" data-stellar-background-ratio="0.5"
                style="background-image: url('images/img_2.jpg')">
                <div class="container">
                    <div class="row align-items-center justify-content-center text-center">
                        <div class="col-md-7">
                            <h1 class="mb-3">EL JAWAWI BARBER</h1>
                            <p>
                                Layanan potong rambut profesional sekaligus tempat kursus barber dengan sistem praktik
                                langsung untuk pemula hingga mahir.
                            </p>
                            <p>
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Booking / Daftar
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section" id="about">
            <div class="container">
                <div class="row align-items-center">

                    <!-- KIRI (GAMBAR) -->
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <div class="img-years">
                            <img src="{{ asset('images/img_1.jpg') }}" alt="Barber" class="img-fluid">
                            <div class="year">
                                <span>3 <span>Tahun <br>Pengalaman</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- KANAN (TEKS) -->
                    <div class="col-lg-5 ml-auto pl-lg-5">

                        <h3 class="scissors mb-3">Tentang EL JAWAWI BARBER</h3>

                        <p class="lead mb-3">
                            EL JAWAWI BARBER menyediakan layanan potong rambut profesional untuk semua kalangan, dengan
                            hasil rapi, modern, dan sesuai kebutuhan pelanggan.
                        </p>

                        <p class="mb-4">
                            Selain layanan barbershop, kami juga membuka program kursus barber dengan metode praktik
                            langsung, membantu peserta dari nol hingga memiliki keterampilan yang siap digunakan.
                        </p>

                        <p>
                            <a href="{{ url('/about') }}" class="btn btn-primary mr-2">
                                Selengkapnya
                            </a>
                            <a href="https://wa.me/6282198965349" target="_blank" class="btn btn-outline-primary">
                                Konsultasi
                            </a>
                        </p>

                    </div>

                </div>
            </div>
        </div>



        <div class="site-section bg-light" id="pricing">
            <div class="container">

                <!-- HEADER -->
                <div class="row justify-content-center mb-5">
                    <div class="col-md-7 text-center">
                        <h3 class="scissors text-center">Layanan & Harga</h3>
                        <p class="mb-4 lead">
                            Pilihan layanan potong rambut dan program kursus barber dengan harga terjangkau dan kualitas
                            profesional.
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">

                        <div class="nonloop-block-13 owl-carousel d-flex">

                            @foreach ($layanans as $layanan)
                                <div class="item-1 h">

                                    <!-- GAMBAR (DEFAULT PER KATEGORI) -->
                                    <img src="
        @if ($layanan->kategori == 'barbershop') {{ asset('images/hasil2.jpeg') }}
        @elseif($layanan->kategori == 'kursus')
            {{ asset('images/kursus2.jpeg') }}
        @else
            {{ asset('images/suasana.jpeg') }} @endif
        "
                                        class="img-fluid">

                                    <div class="item-1-contents">

                                        <!-- JUDUL -->
                                        <h3>{{ $layanan->judul }}</h3>

                                        <!-- ITEMS -->
                                        <ul>
                                            @foreach ($layanan->items as $item)
                                                <li class="d-flex">
                                                    <span>{{ $item->nama }}</span>
                                                    <span class="price ml-auto">
                                                        {{ $item->value_formatted }}
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="site-section" id="course">
            <div class="container">

                <!-- HEADER -->
                <div class="row justify-content-center mb-5">
                    <div class="col-md-7 text-center">
                        <h3 class="scissors text-center">Paket Kursus Barber</h3>
                        <p class="mb-4 lead">
                            Program pelatihan dengan sistem praktik langsung, dirancang untuk membentuk skill hingga
                            siap kerja maupun membuka usaha sendiri.
                        </p>
                    </div>
                </div>

                <div class="row">

                    @foreach ($kursus as $item)
                        <div class="col-lg-4 col-md-6 mb-4">

                            <div
                                class="course-card
        {{ $item->is_rekomendasi ? 'featured' : '' }}
        {{ str_contains(strtolower($item->nama_kursus), 'lengkap') ? 'premium' : '' }}">

                                {{-- BADGE --}}
                                @if ($item->is_rekomendasi)
                                    <div class="badge">
                                        {{ str_contains(strtolower($item->nama_kursus), 'lengkap') ? 'Terlengkap' : 'Rekomendasi' }}
                                    </div>
                                @endif

                                {{-- IMAGE --}}
                                <div class="course-img">
                                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : asset('images/img_1.jpg') }}"
                                        class="img-fluid">
                                </div>
                                {{-- CONTENT --}}
                                <div class="course-content text-center">
                                    <h4>{{ strtoupper($item->nama_kursus) }}</h4>
                                    {{-- HARGA --}}
                                    <p class="price">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                    <ul>
                                        {{-- PERTEMUAN --}}
                                        <li>
                                            <strong>{{ $item->jumlah_pertemuan }}</strong> Pertemuan
                                        </li>
                                        {{-- DESKRIPSI JADI LIST --}}
                                        @if ($item->deskripsi)
                                            @foreach (explode("\n", $item->deskripsi) as $desc)
                                                <li>{{ $desc }}</li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- END section -->

        <div class="site-section section-3" data-stellar-background-ratio="0.5"
            style="background-image: url('{{ asset('images/hero_2.jpg') }}');">
            <div class="container">

                <!-- HEADER -->
                <div class="row justify-content-center text-center">
                    <div class="col-md-7 mb-5">
                        <h2 class="text-white scissors text-center">Fasilitas & Keunggulan</h2>
                        <p class="lead text-white">
                            Program pelatihan dengan fasilitas lengkap dan sistem pembelajaran yang dirancang untuk
                            menghasilkan barber yang siap kerja.
                        </p>
                    </div>
                </div>

                <!-- CONTENT -->
                <div class="row text-white">

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service-1 text-center">
                            <span class="service-1-icon"><span class="flaticon-scissors"></span></span>
                            <div class="service-1-contents">
                                <h3>Teknik Lengkap</h3>
                                <p>Belajar teknik potong rambut modern dan klasik secara detail.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service-1 text-center">
                            <span class="service-1-icon"><span class="flaticon-beard"></span></span>
                            <div class="service-1-contents">
                                <h3>Praktik Langsung</h3>
                                <p>Latihan langsung ke model untuk meningkatkan skill dan kepercayaan diri.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service-1 text-center">
                            <span class="service-1-icon"><span class="flaticon-barber-shop"></span></span>
                            <div class="service-1-contents">
                                <h3>Konsultasi Seumur Hidup</h3>
                                <p>Bimbingan berkelanjutan bahkan setelah kursus selesai.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service-1 text-center">
                            <span class="service-1-icon"><span class="flaticon-hair"></span></span>
                            <div class="service-1-contents">
                                <h3>Modul & Sertifikat</h3>
                                <p>Mendapatkan materi pembelajaran lengkap dan sertifikat resmi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service-1 text-center">
                            <span class="service-1-icon"><span class="flaticon-hair-spray"></span></span>
                            <div class="service-1-contents">
                                <h3>Fasilitas Nyaman</h3>
                                <p>Ruangan full AC, WiFi, dan alat lengkap disediakan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="service-1 text-center">
                            <span class="service-1-icon"><span class="flaticon-bald"></span></span>
                            <div class="service-1-contents">
                                <h3>Siap Usaha</h3>
                                <p>Diajarkan manajemen barbershop, pembukuan, dan sistem penggajian.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        <div class="site-section bg-light">
            <div class="container">
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-7 text-center mb-5">
                        <h2 class="scissors text-center">Our Top Client Says</h2>
                        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo assumenda,
                            dolorum
                            necessitatibus eius earum voluptates sed!</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="testimonial-2">
                            <div class="d-flex v-card align-items-center mb-4">
                                <img src="images/person_1.jpg" alt="Image" class="img-fluid mr-3">
                                <span>Mike Fisher</span>
                            </div>
                            <blockquote>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, deserunt
                                    eveniet
                                    veniam. Ipsam, nam, voluptatum"</p>
                            </blockquote>

                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="testimonial-2">
                            <div class="d-flex v-card align-items-center mb-4">
                                <img src="images/person_2.jpg" alt="Image" class="img-fluid mr-3">
                                <span>Jean Stanley</span>
                            </div>
                            <blockquote>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, deserunt
                                    eveniet
                                    veniam. Ipsam, nam, voluptatum"</p>
                            </blockquote>

                        </div>
                    </div>
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="testimonial-2">
                            <div class="d-flex v-card align-items-center mb-4">
                                <img src="images/person_3.jpg" alt="Image" class="img-fluid mr-3">
                                <span>Katie Rose</span>
                            </div>
                            <blockquote>
                                <p>"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatem, deserunt
                                    eveniet
                                    veniam. Ipsam, nam, voluptatum"</p>
                            </blockquote>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="site-section bg-white" id="gallery">
            <div class="container">

                <!-- HEADER -->
                <div class="row justify-content-center text-center mb-5">
                    <div class="col-md-7 text-center">
                        <h2 class="scissors text-center">Hasil & Kegiatan</h2>
                        <p>
                            Dokumentasi hasil potongan dan kegiatan pelatihan yang dilakukan di EL JAWAWI BARBER.
                        </p>
                    </div>
                </div>

                <!-- GALERI -->
                <div class="row">

                    @foreach ($galeri as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="post-entry-1 h-100">

                                <!-- GAMBAR -->
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid"
                                    style="height:250px; width:100%; object-fit:cover;">

                                <!-- CONTENT -->
                                <div class="post-entry-1-contents">
                                    <h2>{{ $item->judul }}</h2>

                                    <p style="white-space: pre-line;">
                                        {{ $item->deskripsi }}
                                    </p>
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>


        <div class="site-section section-3" data-stellar-background-ratio="0.5"
            style="background-image: url('{{ asset('images/hasil4.jpeg') }}');">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-7 mb-5">
                        <h2 class="text-white scissors text-center">
                            Siap Tampil Lebih Rapi atau Mulai Belajar Barber?
                        </h2>

                        <p class="lead text-white mb-4">
                            Nikmati layanan potong rambut profesional atau ikuti program kursus barber dengan sistem
                            praktik
                            langsung.
                        </p>

                        <p>
                            <a href="https://wa.me/6282198965349" target="_blank" class="btn btn-primary mr-2">
                                Hubungi Sekarang
                            </a>
                            <a href="#pricing" class="btn btn-outline-light">
                                Lihat Layanan
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

      <footer class="site-footer" id="contact">
    <div class="container">

        <!-- TOP -->
        <div class="row text-center text-lg-left">

            <!-- BRAND -->
            <div class="col-lg-4 mb-4">
                <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                    <img src="{{ asset('images/logo.jpeg') }}" class="footer-logo">
                    <span class="footer-logo-text ml-2">EL JAWAWI</span>
                </div>

                <p>
                    Barbershop & kursus barber profesional dengan sistem praktik langsung.
                    Dari pemula sampai siap buka usaha sendiri.
                </p>
            </div>

            <!-- KONTAK -->
            <div class="col-lg-4 mb-4">
                <h5 class="footer-title">Kontak</h5>

                <p class="mb-2">Jl. Atta, Kilo 12 – Kota Sorong</p>

                <p class="mb-2">
                    <a href="https://wa.me/6282198965349" target="_blank">
                        0821-9896-5349
                    </a>
                </p>

                <p class="mb-0">Booking & konsultasi via WhatsApp</p>
            </div>

            <!-- MENU -->
            <div class="col-lg-4 mb-4">
                <h5 class="footer-title">Menu</h5>

                <ul class="footer-menu">
                    <li><a href="#home-section">Home</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#pricing">Layanan</a></li>
                    <li><a href="#course">Kursus</a></li>
                </ul>
            </div>

        </div>

        <!-- MAPS (FULL WIDTH) -->
        <div class="row mb-4">
            <div class="col">
                <div class="map-wrapper rounded-lg overflow-hidden shadow-sm">
    <iframe
        src="https://www.google.com/maps?q=EL+Jawawi+Barber+Sorong&output=embed"
        width="100%"
        height="250"
        style="border:0;"
        allowfullscreen=""
        loading="lazy">
    </iframe>
</div>
            </div>
        </div>

        <hr>

        <!-- COPYRIGHT -->
        <div class="row">
            <div class="col text-center">
                <small>
                    &copy; <script>document.write(new Date().getFullYear());</script>
                    EL JAWAWI BARBER. All rights reserved.
                </small>
            </div>
        </div>

    </div>
</footer>

    </div>

    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/aos.js') }}"></script>

    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                const target = document.querySelector(this.getAttribute('href'));

                if (target) {
                    window.scrollTo({
                        top: target.offsetTop - 80, // offset navbar
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    <script>
        window.addEventListener("scroll", function() {
            const navbar = document.querySelector(".site-navbar");

            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    </script>

</body>

</html>
