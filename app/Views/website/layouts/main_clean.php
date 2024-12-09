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
        <div class="preloader"></div>
        <?= $this->renderSection('header') ?>
        <?= $this->renderSection('content') ?>
        <?= $this->renderSection('footer') ?>
    </div>
    <!--End pagewrapper-->
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
