<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>RetroPhotos</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Cardo:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: PhotoFolio
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/photofolio-bootstrap-photography-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid d-flex align-items-center justify-content-between">

      <a href="{{ url('/') }}" class="logo d-flex align-items-center  me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <i class="bi bi-camera"></i>
        <h1>RetroPhotos</h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
            <li><a href="{{ url('/') }}">Acasa</a></li>
            <li><a href="{{ url('/gallery') }}" class="active">Galerie</a></li>
        @if(Auth::check())
            <li><a href="{{ url('/upload') }}">Incarca Imagini</a></li>
            <li>
            <form action="{{ route('logout') }}" method="post" style="display: inline;">
                    {{ csrf_field() }}
              <button class="btn-delog" type="submit">Delogare</button>
            </form>
          </li>
        @else
            <li><a href="{{ url('/register') }}">Inregistrare</a></li>
            <li><a href="{{ url('/login') }}">Logare</a></li>
        @endif
        </ul>
      </nav>


      <div class="header-social-links">
        <a href="{{ url('/') }}" class="twitter"><i class="bi bi-twitter"></i></a>
        <a href="{{ url('/') }}" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="{{ url('/') }}" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="{{ url('/') }}" class="linkedin"><i class="bi bi-linkedin"></i></i></a>
      </div>
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->

  <main id="main" data-aos="fade" data-aos-delay="1500">

    <!-- ======= End Page Header ======= -->
    <div class="page-header d-flex align-items-center">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Galerie</h2>
            @if(Session::has('succes'))
                <div class="alert" style="font-size:2rem; color:green"; role="alert">
            {{ Session::get('succes') }}
            @endif
            <p>Pozele tuturor utilizatorilor</p>
          </div>
        </div>
      </div>
    </div><!-- End Page Header -->

    
    <form action="{{ route('image.search') }}" method="GET" class="form-search">
    <input type="text" name="search" placeholder="Caută imagini..." class="input-search">
    <button type="submit" class="search-btn">Caută</button>
    </form>

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
  <div class="container-fluid">
    <div class="row gy-4 justify-content-center">
      @foreach ($images as $image)
        <div class="col-xl-3 col-lg-4 col-md-6 pb-5">
          <div class="gallery-item h-100">
          <div class="text-center mb-3 titlu-img">{{ $image->text }}</div>
                <img src="{{ asset('images/' . $image->image) }}" alt="Imagine" style="height: 300px; width:400px" class="mb-4">
                @if (Auth::check() && Auth::user()->name === 'admin')
                <div class="button-img">
                  <form action="{{ route('image.edit', ['id' => $image->id]) }}" method="GET" class="form">
                    @csrf
                        <button type="submit" class="btn-delog btn-get-started-img btn-get-started-img-edit" img-id="{{ $image->id }}" img-text="{{ $image->text }}">Edit</button>
                  </form>
                  <form action="{{ route('delete.image', ['id' => $image->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delog btn-get-started-img btn-get-started-img-delete" >Delete</button>
                  </form>
                </div>
                @endif
            </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>RetroPhotos</span></strong>.<br> All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/photofolio-bootstrap-photography-website-template/ -->
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader">
    <div class="line"></div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>