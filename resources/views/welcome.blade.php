<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Residentes - Bienvenido</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="{{ asset('images/icon.png') }}" rel="icon">
        <link href="{{ asset('images/icon.png') }}" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="assets/css/style.css" rel="stylesheet">

        <!-- =======================================================
        * Template Name: Presento - v3.7.0
        * Template URL: https://bootstrapmade.com/presento-bootstrap-corporate-template/
        * Author: BootstrapMade.com
        * License: https://bootstrapmade.com/license/
        ======================================================== -->
    </head>
    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top d-flex align-items-center">
            <div class="container d-flex align-items-center">
                <h1 class="logo me-auto"><a href="index.html">Residentes<span>.</span></a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->

                <nav id="navbar" class="navbar order-last order-lg-0">
                    <ul>
                        <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
                        <li><a class="nav-link scrollto" href="#about">Acerca de</a></li>
                        <li><a class="nav-link scrollto" href="#team">Directorio</a></li>
                        <li><a class="nav-link scrollto " href="#portfolio">Galería</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

                <a href="#about" class="get-started-btn scrollto">Ver más</a>
            </div>
        </header><!-- End Header -->

        <!-- ======= Hero Section ======= -->
        <section id="hero" class="d-flex align-items-center">

            <div class="container" data-aos="zoom-out" data-aos-delay="100">
                <div class="row">
                    <div class="col-xl-6">
                    <h1>Liga de Residentes del Interior</h1>
                    <h2>Somos una liga de futbol de residentes del interior del país</h2>
                    <a href="#about" class="btn-get-started scrollto">Ver más</a>
                    </div>
                </div>
            </div>

        </section><!-- End Hero -->

        <main id="main">

            <!-- ======= Clients Section ======= -->
            <section id="clients" class="clients">
                <div class="container" data-aos="zoom-in">

                    <div class="clients-slider swiper">
                        <div class="swiper-wrapper align-items-center">
                            @foreach (App\Models\Club::where('deleted_at', NULL)->where('logo', '<>', NULL)->get() as $item)
                            <div class="swiper-slide"><img src="{{ asset('storage/'.str_replace('.', '-small.', $item->logo)) }}" class="img-fluid" alt=""></div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
            </section>
            <!-- End Clients Section -->

            <!-- ======= About Section ======= -->
            <section id="about" class="about section-bg">
                <div class="container" data-aos="fade-up">

                    <div class="row no-gutters">
                        <div class="content col-xl-5 d-flex align-items-stretch">
                            <div class="content">
                                <h3>Voluptatem dignissimos provident quasi</h3>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                                </p>
                                {{-- <a href="#" class="about-btn"><span>About us</span> <i class="bx bx-chevron-right"></i></a> --}}
                            </div>
                        </div>
                        <div class="col-xl-7 d-flex align-items-stretch">
                            <div class="icon-boxes d-flex flex-column justify-content-center">
                            <div class="row">
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                <i class="bx bx-receipt"></i>
                                <h4>Corporis voluptates sit</h4>
                                <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                <i class="bx bx-cube-alt"></i>
                                <h4>Ullamco laboris nisi</h4>
                                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                <i class="bx bx-images"></i>
                                <h4>Labore consequatur</h4>
                                <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                                <i class="bx bx-shield"></i>
                                <h4>Beatae veritatis</h4>
                                <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                                </div>
                            </div>
                            </div><!-- End .content-->
                        </div>
                    </div>
                </div>
            </section>
            <!-- End About Section -->

            <!-- ======= Counts Section ======= -->
            <section id="counts" class="counts">
                <div class="container" data-aos="fade-up">

                    <div class="row">

                        <div class="col-lg-3 col-md-6">
                            <div class="count-box">
                                <i class="bi bi-bookmark-star-fill"></i>
                                <span data-purecounter-start="0" data-purecounter-end="{{ App\Models\Club::where('deleted_at', NULL)->count() }}" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Clubes</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-5 mt-md-0">
                            <div class="count-box">
                            <i class="bi bi-people"></i>
                            <span data-purecounter-start="0" data-purecounter-end="{{ App\Models\Player::where('deleted_at', NULL)->count() }}" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Jugadores</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                            <div class="count-box">
                            <i class="bi bi-trophy"></i>
                            <span data-purecounter-start="0" data-purecounter-end="{{ App\Models\Championship::where('deleted_at', NULL)->where('year', 'like', '%'.date('Y').'%')->count() }}" data-purecounter-duration="1" class="purecounter"></span>
                            <p>Campeonatos</p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                            <div class="count-box">
                                <i class="bi bi-card-list"></i>
                                <span data-purecounter-start="0" data-purecounter-end="{{ App\Models\Category::where('deleted_at', NULL)->count() }}" data-purecounter-duration="1" class="purecounter"></span>
                                <p>Categorías</p>
                            </div>
                        </div>

                    </div>

                </div>
            </section>
            <!-- End Counts Section -->

            <!-- ======= Tabs Section ======= -->
            <section id="tabs" class="tabs">
                <div class="container" data-aos="fade-up">
                    
                    <div class="section-title">
                        <h2>Tabla de posiciones</h2>
                        <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.</p>
                    </div>

                    @php
                        $fixtures = App\Models\ChampionshipsCategory::with(['championship', 'category','teams.team', 'details.local.team_players.player', 'details.visitor.team_players.player', 'details.players.cards'])
                                            ->whereHas('championship', function($q){
                                                $q->where('year', 'like', '%'.date('Y').'%');
                                            })->get();
                    @endphp
                    
                    @foreach ($fixtures as $fixture)
                    <div class="panel panel-bordered">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="7"><h4 class="text-center">{{ $fixture->category->name }}</h4></th>
                                        </tr>
                                        <tr>
                                            <th>N&deg;</th>
                                            <th>Equipo</th>
                                            <th>PJ</th>
                                            <th>PG</th>
                                            <th>PE</th>
                                            <th>PP</th>
                                            <th>Pts.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cont = 0;
                                        @endphp
                                        @foreach ($fixture->teams as $item)
                                            @php
                                                $pg = 0;
                                                $pe = 0;
                                                $pp = 0;
                                                foreach($fixture->details as $detail){
                                                    if($detail->status == 'finalizado'){
                                                        if(($detail->local_id == $item->team_id || $detail->visitor_id == $item->team_id) && $detail->winner_id == $item->team_id){
                                                            $pg++;
                                                        }
                                                        if(($detail->local_id == $item->team_id || $detail->visitor_id == $item->team_id) && $detail->winner_id == null){
                                                            $pe++;
                                                        }
    
                                                        if(($detail->local_id == $item->team_id || $detail->visitor_id == $item->team_id) && $detail->winner_id != null && $detail->winner_id != $item->team_id){
                                                            $pp++;
                                                        }
                                                    }
                                                }
                                                $fixture->teams[$cont]->pj = $pg + $pe + $pp;
                                                $fixture->teams[$cont]->pg = $pg;
                                                $fixture->teams[$cont]->pe = $pe;
                                                $fixture->teams[$cont]->pp = $pp;
                                                $fixture->teams[$cont]->points = ($pg *3) + ($pe *1);
                                                $cont++;
                                            @endphp
                                        @endforeach
    
                                        @php
                                            $cont = 1;
                                        @endphp
                                        @foreach ($fixture->teams->sortByDesc('points') as $item)
                                            <tr>
                                                <td>{{ $cont }}</td>
                                                <td><img src="{{ $item->team->club->logo ? asset('storage/'.$item->team->club->logo) : asset('images/default.jpg') }}" width="20px" alt=""> {{ $item->team->name }}</td>
                                                <td>{{ $item->pj }}</td>
                                                <td>{{ $item->pg }}</td>
                                                <td>{{ $item->pe }}</td>
                                                <td>{{ $item->pp }}</td>
                                                <td>{{ $item->points }}</td>
                                            </tr>
                                            @php
                                                $cont++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                                <br><br>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section><!-- End Tabs Section -->

            <!-- ======= Team Section ======= -->
            <section id="team" class="team section-bg">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                    <h2>Directorio</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.</p>
                    </div>

                    <div class="row">

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="100">
                        <div class="member-img">
                            <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                            <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Walter White</h4>
                            <span>Chief Executive Officer</span>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="200">
                        <div class="member-img">
                            <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                            <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Sarah Jhonson</h4>
                            <span>Product Manager</span>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="300">
                        <div class="member-img">
                            <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                            <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>William Anderson</h4>
                            <span>CTO</span>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="400">
                        <div class="member-img">
                            <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                            <div class="social">
                            <a href=""><i class="bi bi-twitter"></i></a>
                            <a href=""><i class="bi bi-facebook"></i></a>
                            <a href=""><i class="bi bi-instagram"></i></a>
                            <a href=""><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                        <div class="member-info">
                            <h4>Amanda Jepson</h4>
                            <span>Accountant</span>
                        </div>
                        </div>
                    </div>

                    </div>

                </div>
            </section>
            <!-- End Team Section -->

            <!-- ======= Portfolio Section ======= -->
            <section id="portfolio" class="portfolio">
                <div class="container" data-aos="fade-up">

                    <div class="section-title">
                    <h2>Galería</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea.</p>
                    </div>

                    <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 d-flex justify-content-center">
                        <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-app">App</li>
                        <li data-filter=".filter-card">Card</li>
                        <li data-filter=".filter-web">Web</li>
                        </ul>
                    </div>
                    </div>

                    <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 1</h4>
                            <p>App</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 1"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 3</h4>
                            <p>Web</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-2.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 2</h4>
                            <p>App</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-3.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 2</h4>
                            <p>Card</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-4.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 2</h4>
                            <p>Web</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-5.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 2"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-app">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>App 3</h4>
                            <p>App</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-6.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="App 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 1</h4>
                            <p>Card</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-7.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 1"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-card">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Card 3</h4>
                            <p>Card</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-8.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Card 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item filter-web">
                        <div class="portfolio-wrap">
                        <img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>Web 3</h4>
                            <p>Web</p>
                            <div class="portfolio-links">
                            <a href="assets/img/portfolio/portfolio-9.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox" title="Web 3"><i class="bx bx-plus"></i></a>
                            <a href="portfolio-details.html" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                        </div>
                    </div>

                    </div>

                </div>
            </section>
            <!-- End Portfolio Section -->

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer">

            <div class="footer-top">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-3 col-md-6 footer-contact">
                            <h3>Residentes<span>.</span></h3>
                            <p>
                                A108 Adam Street <br>
                                New York, NY 535022<br>
                                United States <br><br>
                                <strong>Phone:</strong> +1 5589 55488 55<br>
                                <strong>Email:</strong> info@example.com<br>
                            </p>
                        </div>

                        <div class="col-lg-2 col-md-6 footer-links">
                            <h4>Useful Links</h4>
                            <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Services</h4>
                            <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-4 col-md-6 footer-newsletter">
                            <h4>Join Our Newsletter</h4>
                            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>

                            <div class="social-links text-right mt-5 pt-5 pt-md-0">
                                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container d-md-flex py-4">

                <div class="me-md-auto text-center text-md-start">
                    <div class="copyright">
                    &copy; Copyright <strong><span>IdeaCreativa</span></strong>. All Rights Reserved
                    </div>
                    <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/presento-bootstrap-corporate-template/ -->
                    Diseñado por <a href="https://ideacreativa.dev/" target="_blank" title="Ir a Idea Creativa">IdeaCreativa</a>
                    </div>
                </div>
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/purecounter/purecounter.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>
    </body>
</html>
