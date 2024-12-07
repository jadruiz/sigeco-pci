<!doctype html>
<html lang="es" class="light-theme">

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
    <!-- CSS Files -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!--link href="<?= base_url() ?>assets/css/bootstrap-extended.css" rel="stylesheet"-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/foundations.css" rel="stylesheet" />
    <title><?= isset($title) ? $title : 'Examen de Lenguas | EDL' ?></title>
</head>

<body class="bg-white">
    <div class="wrapper">
        <?= $this->renderSection('content') ?>
    </div>
</body>

</html>