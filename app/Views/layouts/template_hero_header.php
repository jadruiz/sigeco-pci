<!-- app/Views/layouts/template.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo) ? esc($titulo) : 'Sistema de Gestión de Lenguas' ?></title>
    <link rel="icon" type="image/png" href="<?= base_url() ?>assets/favicon.png">
    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background-color: #f8f9fa;
            /* Cambiar el fondo a un color más claro para mejor contraste */
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container.container-hero {
            padding: 0px;
            display: block;
        }

        .container-hero {
            max-width: 800px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
        }

        .container-hero {
            background-color: #fff;
            padding: 40px;
            display: flex;
            align-items: center;
            text-align: center;
        }

        .carousel-item img,
        .process-card img {
            border-radius: 10px;
        }

        .btn-custom {
            background-color: #007bff;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            color: #fff;
        }

        @media (max-width: 575.98px) {
            main {
                padding-left: 20px;
                padding-right: 20px;
            }
            .fixed-bottom{
                position: inherit;
            }
        }
        body {
    border-top: 10px solid var(--clr-secondary);
}
    </style>
    <link href="<?= base_url() ?>assets/css/foundations.css" rel="stylesheet" />
    <?= $this->renderSection('header_page') ?>
</head>

<body class="bg-primary vh-100">
    <header class="text-white pb-3 text-center">
        <?= $this->renderSection('header') ?>
    </header>
    <main class="">
        <div class="container container-hero">
            <?= $this->renderSection('content') ?>
        </div>
    </main>
    <footer class="text-white p-3 text-center bg-primary">
        <p>&copy; <?= date('Y') ?> Examen de Ubicación de Inglés - UQROO. Todos los derechos reservados.</p>
    </footer>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5.3.0 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->renderSection('footer_scripts') ?>
</body>

</html>