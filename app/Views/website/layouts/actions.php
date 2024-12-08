<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? esc($title) : 'Sistema de Registro'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .content-wrapper {
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url(); ?>">
                <i class="fa-solid fa-graduation-cap"></i> SGC Participantes
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('registro'); ?>">
                            <i class="fa-solid fa-user-plus"></i> Registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido -->
    <div class="content-wrapper">
        <div class="container">
            <?= $this->renderSection('content'); ?>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="bg-dark text-white text-center py-3">
        <div class="container">
            <p class="mb-0">
                <i class="fa-regular fa-copyright"></i> <?= date('Y'); ?> Sistema de Gestión de Congresos
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
