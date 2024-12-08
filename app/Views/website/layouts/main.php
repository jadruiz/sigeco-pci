<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title><?= isset($title) ? $title : env('app.sgc.fullnameAcronyms', '') . ' | ' . env('app.sgc.fullname', '') ?></title>
    <!-- Stylesheets -->
    <link href="<?= base_url('assets/website/css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/website/css/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/website/css/responsive.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/website/plugins/revolution/css/settings.css') ?>" rel="stylesheet" type="text/css"><!-- REVOLUTION SETTINGS STYLES -->
    <link href="<?= base_url('assets/website/plugins/revolution/css/layers.css') ?>" rel="stylesheet" type="text/css"><!-- REVOLUTION LAYERS STYLES -->
    <link href="<?= base_url('assets/website/plugins/revolution/css/navigation.css') ?>" rel="stylesheet" type="text/css"><!-- REVOLUTION NAVIGATION STYLES -->
    <link rel="shortcut icon" href="<?= base_url('assets/website/images/favicon.png') ?>" type="image/x-icon">
    <link rel="icon" href="<?= base_url('assets/website/images/favicon.png') ?>" type="image/x-icon">
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="<?= base_url('assets/website/js/respond.js') ?>"></script><![endif]-->
    <link href="<?= base_url() ?>assets/css/foundations.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/website/css/custom.css" rel="stylesheet" />
</head>

<body>
    <div class="page-wrapper">
        <!-- Preloader -->
        <div class="preloader"></div>
        <!-- Main Header-->
        <header class="main-header">
            <!--Header-Upper-->
            <div class="header-upper">
                <div class="outer-container">
                    <div class="clearfix">
                        <div class="pull-left logo-box">
                            <div class="logo"><a href="index.html"><img src="<?= base_url('assets/website/images/logo.png') ?>" alt="" title=""></a></div>
                        </div>

                        <!--Nav Box-->
                        <div class="nav-outer clearfix">
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler"><span class="icon flaticon-menu-1"></span></div>
                            <!-- Main Menu -->
                            <nav class="main-menu navbar-expand-md navbar-light">
                                <div class="collapse navbar-collapse clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <li><a href="contact">Contacto</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <div class="outer-box">
                                <div class="cart-btn"><a href="shopping-cart.html"><span class="icon flaticon-shopping-bag"></span> <span class="count">2</span></a></div>
                                <div class="search-box">
                                    <div class="search-box-btn"><span class="icon flaticon-magnifying-glass"></span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Outer btn -->
                        <div class="outer-btn">
                            <a href="registro" class="theme-btn btn-style-one">Registro <span class="flaticon-arrow"></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Header Upper-->
            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                <nav class="menu-box">
                    <div class="nav-logo"><a href="index.html"><img src="<?= base_url('assets/website/images/logo-2.png') ?>" alt="" title=""></a></div>

                    <ul class="navigation clearfix"><!--Keep This Empty / Menu will come through Javascript--></ul>
                </nav>
            </div><!-- End Mobile Menu -->
        </header>
        <?= $this->renderSection('content') ?>
        <!--End Main Header -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="auto-container">
                <!-- Upper Box -->
                <div class="upper-box">
                    <div class="row">
                        <div class="title-column col-lg-6 col-md-12 col-sm-12">
                            <h2>Sucríbete <br>a nuestro boletín</h2>
                        </div>
                        <div class="form-column col-lg-6 col-md-12 col-sm-12">
                            <!--Newsletter Form-->
                            <div class="newsletter-form">
                                <form method="post" action="blog.html">
                                    <div class="form-group">
                                        <input type="email" name="field-name" value="" placeholder="Your email" required>
                                        <button type="submit" class="theme-btn btn-style-one">Sucríbete <span class="flaticon-arrow"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Content -->
                <div class="footer-content">
                    <div class="footer-logo"><a href="#"><img src="<?= base_url('assets/website/images/logo.png') ?>" alt=""></a></div>
                    <div class="social-links">
                        <div class="text-box">
                            <h3>Redes sociales</h3>
                            <div class="text">Mantente al día</div>
                        </div>
                        <ul class="social-icon-colored">
                            <li class="google-plus"><a href="#"><span class="fab fa-google-plus-g"></span></a></li>
                            <li class="facebbok"><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                            <li class="dribble"><a href="#"><span class="fab fa-dribbble"></span></a></li>
                            <li class="twitter"><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li class="instagram"><a href="#"><span class="fab fa-instagram"></span></a></li>
                            <li class="vimeo"><a href="#"><span class="fab fa-vimeo-v"></span></a></li>
                        </ul>
                    </div>
                    <div class="copyright-text">© Copyright <a href="#"></a> 2019. Todos los derechos reservados.</div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->
    </div>
    <!--End pagewrapper-->

    <!--Search Popup-->
    <div id="search-popup" class="search-popup">
        <div class="close-search theme-btn"><span class="fa fa-times"></span></div>
        <div class="popup-inner">
            <div class="overlay-layer"></div>
            <div class="search-form">
                <form method="post" action="index.html">
                    <div class="form-group">
                        <fieldset>
                            <input type="search" class="form-control" name="search-input" value="" placeholder="Search Here" required>
                            <input type="submit" value="Search Now!" class="theme-btn">
                        </fieldset>
                    </div>
                </form>
                <br>
                <h3>Recent Search Keywords</h3>
                <ul class="recent-searches">
                    <li><a href="#">Business</a></li>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">SEO</a></li>
                    <li><a href="#">Logistics</a></li>
                    <li><a href="#">Freedom</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!--Scroll to top-->
    <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-double-up"></span></div>
    <script src="<?= base_url('assets/website/js/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/popper.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/bootstrap.min.js') ?>"></script>
    <!--Revolution Slider-->
    <script src="<?= base_url('assets/website/plugins/revolution/js/jquery.themepunch.revolution.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/jquery.themepunch.tools.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.actions.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.carousel.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.migration.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.navigation.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.parallax.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/plugins/revolution/js/extensions/revolution.extension.video.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/main-slider-script.js') ?>"></script>
    <!--Revolution Slider-->
    <script src="<?= base_url('assets/website/js/jquery-ui.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/jquery.fancybox.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/appear.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/jquery.countdown.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/parallax.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/owl.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/jquery.paroller.min.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/wow.js') ?>"></script>
    <script src="<?= base_url('assets/website/js/script.js') ?>"></script>
    <!--Google Map APi Key-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcaOOcFcQ0hoTqANKZYz-0ii-J0aUoHjk"></script>
    <script src="<?= base_url('assets/website/js/map-script.js') ?>"></script>
    <!--End Google Map APi-->
    <?= $this->renderSection('bottom_body') ?>
</body>

</html>
