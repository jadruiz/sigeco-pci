<!doctype html>
<html lang="en" class="light-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/favicon.png">
    <!-- loader-->
    <link href="<?= base_url() ?>assets/css/pace.min.css" rel="stylesheet" />
    <script src="<?= base_url() ?>assets/js/pace.min.js"></script>
    <!--plugins-->
    <link href="<?= base_url() ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <!--Theme Styles-->
    <link href="<?= base_url() ?>assets/css/dark-theme.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/semi-dark.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/header-colors.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/foundations.css" rel="stylesheet" />
    <title><?= isset($title) ? $title : env('app.sgc.fullnameAcronyms','').' | '.env('app.sgc.fullname','') ?></title>
    <script>
        const baseUrl = '<?= base_url() ?>';
        const moduleKey = '<?= $moduleKey ?>';
        const csrfToken = '<?= csrf_hash() ?>';
        const csrfTokenName = '<?= csrf_token() ?>';
    </script>
</head>

<body>
    <!--start wrapper-->
    <div class="wrapper">
        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="<?= base_url() ?>assets/images/logo-icon-2.png" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text"><?= env('app.sgc.admin.fullnameAcronyms','')?></h4>
                </div>
                <div class="toggle-icon ms-auto"><ion-icon name="menu-sharp"></ion-icon></div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <?php foreach ($modulos as $modulo): ?>
                    <li>
                        <a href="<?= base_url($modulo['path']) ?>">
                            <div class="parent-icon">
                                <i class="fa "></i>
                                <ion-icon name="<?= esc($modulo['icono']) ?>"></ion-icon>
                            </div>
                            <div class="menu-title"><?= esc($modulo['nombre']) ?></div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!--end navigation-->
        </aside>
        <!--end sidebar -->
        <!--start top header-->
        <header class="top-header">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-menu-button"><ion-icon name="menu-sharp"></ion-icon></div>
                <?= $this->renderSection('global-search') ?>
                <div class="top-navbar-right ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item mobile-search-button">
                            <a class="nav-link" href="javascript:;">
                                <div class="">
                                    <ion-icon name="search-sharp"></ion-icon>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link dark-mode-icon" href="javascript:;">
                                <div class="mode-icon">
                                    <ion-icon name="moon-sharp"></ion-icon>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item dropdown dropdown-user-setting">
                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                                <div class="user-setting">
                                    <img src="<?= base_url() ?>assets/images/avatars/default-profile.png" class="user-img" alt="">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <div class="d-flex flex-row align-items-center gap-2">
                                            <img src="<?= base_url() ?>assets/images/avatars/default-profile.png" alt="" class="rounded-circle" width="54" height="54">
                                            <div class="">
                                                <h6 class="mb-0 dropdown-user-name"><?= session()->get('adm_nombre') ?></h6>
                                                <small class="mb-0 dropdown-user-designation text-secondary"><?= session()->get('adm_username') ?></small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/dashboard') ?>">
                                        <div class="d-flex align-items-center">
                                            <div class=""><ion-icon name="speedometer-outline"></ion-icon></div>
                                            <div class="ms-3"><span>Dashboard</span></div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('admin/logout') ?>">
                                        <div class="d-flex align-items-center">
                                            <div class=""><ion-icon name="log-out-outline"></ion-icon></div>
                                            <div class="ms-3"><span>Salir</span></div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--end top header-->
        <!-- start page content wrapper-->
        <div class="page-content-wrapper">
            <!-- start page content-->
            <div class="page-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
        <a href="javaScript:;" class="back-to-top"><ion-icon name="arrow-up-outline"></ion-icon></a>
        <?= $this->renderSection('offcanvas') ?>
        <div class="overlay"></div>
    </div>
    <!--end wrapper-->
    <!-- JS Files-->
    <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <!--plugins-->
    <script src="<?= base_url() ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <!-- Main JS-->
    <script src="<?= base_url() ?>assets/js/main.js"></script>
    <script src="<?= base_url() ?>assets/js/global.js"></script>
    <?= $this->renderSection('extra-js') ?>
</body>

</html>