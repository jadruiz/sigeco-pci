<!-- app/Views/layouts/template.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo) ? esc($titulo) : '' ?></title>

    <!-- Bootstrap 5.3.0 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/foundations.css" rel="stylesheet" />
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>

<body>
    <header>
        <h1 class="text-center">Examen</h1>
        <!-- Aquí puedes agregar un menú o cualquier otro elemento de navegación -->
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="text-center mt-4">
        <p>&copy; <?= date('Y') ?> EDI - Examen de Diagnóstico en Inglés</p>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5.3.0 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>