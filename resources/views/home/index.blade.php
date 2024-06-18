<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ $title }} | {{ env('APP_NAME') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/home/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5fd2369345.js" crossorigin="anonymous"></script>
    <link href="/home/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid position-relative nav-bar p-0">
        <div class="position-relative p-0 " style="z-index: 9;">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 pl-3 pl-lg-5">
                <a href="/" class="navbar-brand d-flex align-items-center">
                    <img src="/home/img/logo.png" alt="Logo" style="height: 50px; width: auto; margin-right: 10px;">
                    <h2 class="m-0 text-secondary">{{ Str::upper(env('APP_NAME')) }}</h2>
                </a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                    <div class="navbar-nav ml-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">Beranda</a>
                        <a href="#about" class="nav-item nav-link">Tentang</a>
                        <a href="#service" class="nav-item nav-link">Layanan</a>
                        <a href="#paket" class="nav-item nav-link">Paket</a>

                        @can('superadmin')
                            <a href="/panel" class="nav-item nav-link btn btn-primary text-white ml-3">Dashboard</a>
                        @elsecan('admin')
                            <a href="/panel" class="nav-item nav-link btn btn-primary text-white ml-3">Dashboard</a>
                        @elsecan('user')
                            <a href="/orders" class="nav-item nav-link btn btn-primary text-white ml-3">Dashboard</a>
                        @endcan

                        @guest
                            <a href="/login" class="nav-item nav-link btn btn-primary text-white ml-3">Login</a>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <!-- Navbar End -->


    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div id="header-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="/home/img/a.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">Laundry & Dry Cleaning</h4>
                            <h1 class="display-3 text-white mb-md-4">Pilihan Terbaik untuk Layanan Laundry</h1>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="/home/img/b.jpg" alt="Image">
                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3" style="max-width: 900px;">
                            <h4 class="text-white text-uppercase mb-md-3">Laundry & Dry Cleaning</h4>
                            <h1 class="display-3 text-white mb-md-4">Staf yang Sangat Profesional</h1>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                <div class="btn btn-secondary" style="width: 45px; height: 45px;">
                    <span class="carousel-control-prev-icon mb-n2"></span>
                </div>
            </a>
            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                <div class="btn btn-secondary" style="width: 45px; height: 45px;">
                    <span class="carousel-control-next-icon mb-n2"></span>
                </div>
            </a>
        </div>
    </div>
    <!-- Carousel End -->

    <!-- Contact Info Start -->
    <div class="container-fluid contact-info mt-5 mb-4">
        <div class="container" style="padding: 0 30px;">
            <div class="row" id="">
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-4 mb-lg-0"
                    style="height: 100px; border-top-left-radius: 15px;">
                    <div class="d-inline-flex">
                        <i class="fa fa-2x fa-map-marker-alt text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Lokasi</h5>
                            <p class="m-0 text-white">Indonesia</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-primary mb-4 mb-lg-0"
                    style="height: 100px;">
                    <div class="d-inline-flex text-left">
                        <i class="fa fa-2x fa-envelope text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Email</h5>
                            <p class="m-0 text-white">{{ $admin->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-center justify-content-center bg-secondary mb-4 mb-lg-0"
                    style="height: 100px; border-top-right-radius: 15px;">
                    <div class="d-inline-flex text-left">
                        <i class="fa fa-2x fa-phone-alt text-white m-0 mr-3"></i>
                        <div class="d-flex flex-column">
                            <h5 class="text-white font-weight-medium">Telpon</h5>
                            <p class="m-0 text-white">{{ $admin->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Info End -->


    <!-- Tentang Start -->
    <div class="container-fluid py-5">
        <div class="container pt-0 pt-lg-4">
            <div class="row align-items-center" id="about">
                <div class="col-lg-5" data-aos="fade-right">
                    <img class="img-fluid" src="/home/img/sec.jpg" alt="">
                </div>
                <div class="col-lg-7 mt-5 mt-lg-0 pl-lg-5" data-aos="fade-left">
                    <h6 class="text-secondary text-uppercase font-weight-medium mb-3">Tentang Kami</h6>
                    <h1 class="mb-4">Penyedia layanan laundry berkualitas</h1>
                    <h5 class="font-weight-medium font-italic mb-4"> Kami mengutamakan kualitas dan kepuasan pelanggan
                        dalam setiap layanan yang kami sediakan.</h5>
                    <p class="mb-2">Kami menyediakan layanan laundry berkualitas tinggi untuk memastikan pakaian Anda
                        bersih dan segar setiap saat. Dengan peralatan modern dan produk pembersih terbaik, kami
                        menjamin hasil yang memuaskan.</p>
                    <div class="row">
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-secondary font-weight-medium m-0">Layanan pembersih terbaik</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-secondary font-weight-medium m-0">Proses cepat</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-secondary font-weight-medium m-0">Staf Profesional dan Terlatih</p>
                            </div>
                        </div>
                        <div class="col-sm-6 pt-3">
                            <div class="d-flex align-items-center">
                                <i class="fa fa-check text-primary mr-2"></i>
                                <p class="text-secondary font-weight-medium m-0">Garansi Kepuasan 100%</p>
                            </div>
                        </div>
                        <a href="/orders" class="btn btn-primary py-md-3 px-md-5 mt-5 ml-3">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tentang End -->


    <!-- Services Start -->
    <div class="container-fluid pt-5 pb-3 mb" id="service">
        <div class="container">
            <div data-aos="fade-down">
                <h6 class="text-secondary text-uppercase text-center font-weight-medium mb-3">Layanan Kami</h6>
                <h1 class="display-4 text-center mb-5">Kami Tawarkan</h1>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-3 col-md-6 pb-1 zoom-in" data-aos="flip-left">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-light mb-4 px-4"
                        style="height: 300px;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white shadow rounded-circle mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-3x fa-cloud-sun text-primary"></i>
                        </div>
                        <h4 class="font-weight-bold m-0">Pengering</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1 zoom-in" data-aos="flip-left">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-light mb-4 px-4"
                        style="height: 300px;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white shadow rounded-circle mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="fas fa-3x fa-soap text-primary"></i>
                        </div>
                        <h4 class="font-weight-bold m-0">Cuci & Laundry</h4>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 pb-1 zoom-in" data-aos="flip-left">
                    <div class="d-flex flex-column align-items-center justify-content-center text-center bg-light mb-4 px-4"
                        style="height: 300px;">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white shadow rounded-circle mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="fa fa-3x fa-burn text-primary"></i>
                        </div>
                        <h4 class="font-weight-bold m-0">Laundry Express</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


    <!-- Process Start -->
    <div class="container-fluid pt-5 mb-5 gambar"
        style="background-image: url('/home/img/c.jpeg'); background-attachment: fixed; background-size: cover; background-position: center;">
        <div class="container">
            <h6 class="text-white text-uppercase text-center font-weight-medium mb-3">Proses Laundry</h6>
            <h1 class="display-4 text-center mb-5 text-primary">Bagaimana Kami Bekerja</h1>
            <div class="d-flex justify-content-center flex-wrap">
                <div class="d-flex flex-column align-items-center text-center mb-5 mx-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4 "
                        style="width: 150px; height: 150px; border-width: 15px !important;">
                        <h2 class="display-2 text-primary m-0">1</h2>
                    </div>
                    <h3 class="text-primary font-weight-bold m-0 mt-2">Buat</h3>
                </div>
                <div class="d-flex flex-column align-items-center text-center mb-5 mx-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4 "
                        style="width: 150px; height: 150px; border-width: 15px !important;">
                        <h2 class="display-2 text-primary m-0">2</h2>
                    </div>
                    <h3 class="text-primary font-weight-bold m-0 mt-2">Antar</h3>
                </div>
                <div class="d-flex flex-column align-items-center text-center mb-5 mx-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4 "
                        style="width: 150px; height: 150px; border-width: 15px !important;">
                        <h2 class="display-2 text-primary m-0">3</h2>
                    </div>
                    <h3 class="text-primary font-weight-bold m-0 mt-2">Bayar</h3>
                </div>
                <div class="d-flex flex-column align-items-center text-center mb-5 mx-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4 "
                        style="width: 150px; height: 150px; border-width: 15px !important;">
                        <h2 class="display-2 text-primary m-0">4</h2>
                    </div>
                    <h3 class="text-primary font-weight-bold m-0 mt-2">Proses</h3>
                </div>
                <div class="d-flex flex-column align-items-center text-center mb-5 mx-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4 "
                        style="width: 150px; height: 150px; border-width: 15px !important;">
                        <h2 class="display-2 text-primary m-0">5</h2>
                    </div>
                    <h3 class="text-primary font-weight-bold m-0 mt-2">Ambil</h3>
                </div>
                <div class="d-flex flex-column align-items-center text-center mb-5 mx-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white border border-light shadow rounded-circle mb-4 "
                        style="width: 150px; height: 150px; border-width: 15px !important;">
                        <h2 class="display-2 text-primary m-0">6</h2>
                    </div>
                    <h3 class="text-primary font-weight-bold m-0 mt-2">Selesai</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Process End -->

    @if ($products->count() > 0)
        <!-- Paket -->
        <div class="container-fluid pt-2 pb-3" style="margin-top: 100px;">
            <div class="container" id="paket" data-aos="zoom-in">
                <h1 class="display-4 text-center mb-5">Paket Laundry</h1>
                <div class="row justify-content-center">
                    @foreach ($products as $product)
                        <div class="col-lg-4 mb-4 zoom-in">
                            <div class="bg-light text-center mb-2 pt-4">
                                <div class="d-inline-flex flex-column align-items-center justify-content-center bg-primary shadow mt-2 mb-4 p-3"
                                    style="width: auto; height: auto; border: 15px solid #ffffff;">
                                    <h1 class="display-4 text-white mb-0">
                                        {{ $product->name }}
                                    </h1>
                                </div>
                                <div class="d-flex flex-column align-items-center py-3">
                                    <p>Rp {{ number_format($product->price, 2, ',', '.') }} per kg</p>
                                    <p>Garansi Tepat Waktu</p>
                                    <p>Layanan mencakup pencucian, pengeringan, dan penyetrikaan</p>
                                </div>
                                <a href="/orders" class="btn btn-primary py-2 px-4">Pilih Paket</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Paket End -->
    @endif


    <!-- Blog Start -->
    <div class="container-fluid mt-5 pb-2">
        <div class="container">
            <div data-aos="fade-down">
                <h1 class="display-4 text-center mb-5">Ulasan Pelanggan</h1>
            </div>
            @if ($reviews->count() < 3)
                <div class="row justify-content-center">
                    <div class="col-lg-12 mb-2" style="width: 100%" data-aos="fade-up">
                        <div class="shadow mb-4">
                            <div class="position-relative">
                                <img class="img-fluid  w-100" src="{{ asset('dashboard/img/undraw_profile.svg') }}"
                                    alt=""
                                    style="height: 150px;width: 100%;object-fit: cover;overflow: hidden;">
                                <a href="/orders"
                                    class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center   text-decoration-none p-4"
                                    style="top: 0; left: 0; background: rgba(0, 0, 0, .4);">
                                    <h4 class="text-center text-white font-weight-medium mb-3">
                                        {{ fake('id_ID')->name }}
                                    </h4>
                                </a>
                            </div>
                            <p class="m-0 p-4" style="max-height: 400px;">
                                Usaha laundry adalah solusi praktis bagi mereka yang tidak sempat mencuci pakaian
                                sendiri.
                                Kualitas layanan mencuci yang baik dan pengeringan yang cepat sangat dihargai oleh
                                pelanggan. Namun, persaingan ketat di industri ini menuntut inovasi dan promosi yang
                                lebih
                                gencar untuk menarik lebih banyak pelanggan dan mempertahankan yang sudah ada.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2" style="width: 100%" data-aos="fade-up">
                        <div class="shadow mb-4">
                            <div class="position-relative">
                                <img class="img-fluid  w-100" src="{{ asset('dashboard/img/undraw_profile.svg') }}"
                                    alt=""
                                    style="height: 150px;width: 100%;object-fit: cover;overflow: hidden;">
                                <a href="/orders"
                                    class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center   text-decoration-none p-4"
                                    style="top: 0; left: 0; background: rgba(0, 0, 0, .4);">
                                    <h4 class="text-center text-white font-weight-medium mb-3">
                                        {{ fake('id_ID')->name }}
                                    </h4>
                                </a>
                            </div>
                            <p class="m-0 p-4" style="max-height: 400px;">
                                Usaha laundry menawarkan layanan yang sangat membantu, terutama bagi masyarakat
                                perkotaan
                                yang sibuk. Dengan harga terjangkau, kualitas cuci yang baik, serta waktu penyelesaian
                                yang
                                cepat, usaha ini menjadi solusi praktis. Namun, perlu peningkatan pada layanan pelanggan
                                dan
                                penambahan variasi layanan untuk memenuhi kebutuhan yang beragam.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2" style="width: 100%" data-aos="fade-up">
                        <div class="shadow mb-4">
                            <div class="position-relative">
                                <img class="img-fluid  w-100" src="{{ asset('dashboard/img/undraw_profile.svg') }}"
                                    alt=""
                                    style="height: 150px;width: 100%;object-fit: cover;overflow: hidden;">
                                <a href="/orders"
                                    class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center   text-decoration-none p-4"
                                    style="top: 0; left: 0; background: rgba(0, 0, 0, .4);">
                                    <h4 class="text-center text-white font-weight-medium mb-3">
                                        {{ fake('id_ID')->name }}
                                    </h4>
                                </a>
                            </div>
                            <p class="m-0 p-4" style="max-height: 400px;">
                                Usaha laundry memberikan kemudahan bagi pelanggan dengan layanan cuci dan setrika yang
                                efisien. Harga yang kompetitif dan layanan antar-jemput menjadi nilai tambah. Meski
                                begitu,
                                tantangan utama adalah menjaga konsistensi kualitas dan menangani peningkatan permintaan
                                pada waktu-waktu sibuk, sehingga manajemen operasional yang baik sangat diperlukan.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    @foreach ($reviews as $review)
                        <div class="col-lg-12 mb-2" style="width: 100%" data-aos="fade-up">
                            <div class="shadow mb-4">
                                <div class="position-relative">
                                    <img class="img-fluid  w-100"
                                        src="{{ $review->user->img ? asset('storage/people') . '/' . $review->user->img : asset('dashboard/img/undraw_profile.svg') }}"
                                        alt=""
                                        style="height: 150px;width: 100%;object-fit: cover;overflow: hidden;">
                                    <a href="/orders"
                                        class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-center   text-decoration-none p-4"
                                        style="top: 0; left: 0; background: rgba(0, 0, 0, .4);">
                                        <h4 class="text-center text-white font-weight-medium mb-3">
                                            {{ $review->user->name }}
                                        </h4>
                                    </a>
                                </div>
                                <p class="m-0 p-4" style="max-height: 400px;">
                                    {{ $review->review }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- Blog End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5 px-sm-3 px-md-5">
        <div class="row pt-5 d-flex flex-wrap justify-content-between">
            <div class="col-lg-3 col-md-6 mb-5">
                <a href="/orders">
                    <h1 class="text-primary text-uppercase mb-3">{{ env('APP_NAME') }}</h1>
                </a>
                <h5 class="text-dark">Penyedia layanan laundry berkualitas</h5>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-dark mb-4">Hubungi Kami</h4>
                <p><i class="fa fa-phone-alt mr-2"></i>{{ $admin->phone }}</p>
                <p><i class="fa fa-envelope mr-2"></i>{{ $admin->email }}</p>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="text-dark mb-4">Quick Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-dark mb-2" href="#about"><i class="fa fa-angle-right mr-2"></i>Tentang</a>
                    <a class="text-dark mb-2" href="#service"><i class="fa fa-angle-right mr-2"></i>Layanan</a>
                    <a class="text-dark mb-2" href="#paket"><i class="fa fa-angle-right mr-2"></i>Paket</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-white py-4 px-sm-3 px-md-5">
        <p class="m-0 text-center text-white">
            &copy; <a class="text-white font-weight-medium" href="#">{{ env('APP_NAME') }}</a>. All Rights
            Reserved.
        </p>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="/home/lib/easing/easing.min.js"></script>
    <script src="/home/lib/waypoints/waypoints.min.js"></script>
    <script src="/home/lib/counterup/counterup.min.js"></script>
    <script src="/home/lib/owlcarousel/owl.carousel.min.js"></script>

    <!--AOS-->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            disable: ['mobile', 'phone'],
        });
    </script>

    <!-- Contact Javascript File -->
    <script src="/home/mail/jqBootstrapValidation.min.js"></script>
    <script src="/home/mail/contact.js"></script>
    <script src="/home/js/main.js"></script>

</body>

</html>
