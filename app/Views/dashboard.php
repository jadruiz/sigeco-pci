<?= $this->extend('layouts/template_seccion') ?>

<?= $this->section('header_page') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/examen/seccion.css') ?>" />
<?= $this->endSection() ?>

<?= $this->section('header') ?>
<div class="container-fluid bg-primary text-white py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-8 d-flex align-items-center left">
                <h1>Proceso de Revalidación y Diagnóstico de <b>Inglés</b> para Nuevo Ingreso 2025</h1>
            </div>
            <div class="col-md-4 align-items-center text-end right">
                <a href="<?= base_url('logout') ?>" class="btn btn-danger">Cerrar sesión</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
    .nav-tabs-container {
        background-color: #f8f9fa;
        position: relative;
        top: -1px;
    }

    .nav-tabs-container .container {
        padding-left: 0;
        padding-right: 0;
    }

    .nav-tabs {
        border-bottom: none;
    }

    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-bottom: none;
        background-color: #f8f9fa;
        color: #65696f;
    }

    .nav-tabs .nav-link.active {
        background-color: #fff;
        border-color: #dee2e6 #dee2e6 #fff;
        color: #0d6efd;
    }

    .nav-tabs .nav-link[disabled] {
        color: #ccc;
        cursor: not-allowed;
    }

    .nav-tabs .nav-link {
        border: 0px;
        border-radius: 0px;
        font-size: 24px;
        font-weight: 500;
    }
</style>

<div class="nav-tabs-container">
    <div class="container">
        <ul class="nav nav-tabs" id="processTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= ($step == 1) ? 'active' : '' ?>" id="tab-instrucciones" data-bs-toggle="tab" data-bs-target="#instrucciones" type="button" role="tab" aria-controls="instrucciones" aria-selected="<?= ($step == 1) ? 'true' : 'false' ?>" <?= ($step < 1) ? 'disabled' : '' ?> data-step="1">
                    1. Instrucciones
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= ($step == 2) ? 'active' : '' ?>" id="tab-prueba-audio" data-bs-toggle="tab" data-bs-target="#prueba-audio" type="button" role="tab" aria-controls="prueba-audio" aria-selected="<?= ($step == 2) ? 'true' : 'false' ?>" <?= ($step < 2) ? 'disabled' : '' ?> data-step="2">
                    2. Prueba de Audio
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= ($step == 3) ? 'active' : '' ?>" id="tab-aplicacion" data-bs-toggle="tab" data-bs-target="#aplicacion" type="button" role="tab" aria-controls="aplicacion" aria-selected="<?= ($step == 3) ? 'true' : 'false' ?>" <?= ($step < 3) ? 'disabled' : '' ?> data-step="3">
                    3. Exámenes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= ($step == 4) ? 'active' : '' ?>" id="tab-resultados" data-bs-toggle="tab" data-bs-target="#resultados" type="button" role="tab" aria-controls="resultados" aria-selected="<?= ($step == 4) ? 'true' : 'false' ?>" <?= ($step < 4) ? 'disabled' : '' ?> data-step="4">
                    4. Resultados
                </button>
            </li>
        </ul>
    </div>
</div>

<div class="container mt-4 mb-5">
    <div class="tab-content" id="processTabsContent">
        <!-- Tab 1: Instrucciones -->
        <div class="tab-pane fade <?= ($step == 1) ? 'show active' : '' ?>" id="instrucciones" role="tabpanel" aria-labelledby="tab-instrucciones">
            <h3>Instrucciones</h3>
            <p><b>Nota:</b> La calificación de este examen no afecta tu expediente académico.</p>
            <ol>
                <li>Realiza el examen sin utilizar material de ayuda.</li>
                <li>No uses diccionarios ni referencias externas.</li>
                <li>Utiliza <a href="https://www.google.com/chrome/" target="_blank">Google Chrome</a> si experimentas problemas.</li>
                <li>El examen tiene varias secciones. Completa cada una y haz clic en <b>Siguiente</b> para avanzar.</li>
            </ol>
        </div>

        <!-- Tab 2: Prueba de Audio -->
        <div class="tab-pane fade <?= ($step == 2) ? 'show active' : '' ?>" id="prueba-audio" role="tabpanel" aria-labelledby="tab-prueba-audio">
            <h3>Realiza una Prueba de Audio</h3>
            <p>Por favor, asegúrate de que puedes escuchar correctamente el audio antes de comenzar el examen.</p>
            <div class="alert alert-info mt-3">
                <b>Nota:</b> Asegúrate de que el volumen de tu dispositivo esté en un nivel adecuado y que los auriculares estén conectados (si los usas).
            </div>
            <button id="btnTestAudio" class="btn btn-primary mb-3">
                <i class="fa fa-volume-up"></i> Escuchar Prueba de Audio
            </button>
        </div>

        <!-- Tab 3: Exámenes -->
        <div class="tab-pane fade <?= ($step == 3) ? 'show active' : '' ?>" id="examenes" role="tabpanel" aria-labelledby="tab-examenes">
            <h3>Exámenes Disponibles</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Examen</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($examenes)): ?>
                        <?php foreach ($examenes as $examen): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($examen['titulo']) ?></strong></td>
                                <td><?= $examen['habilitado'] ? 'Disponible' : 'No disponible' ?></td>
                                <td>
                                    <?php if ($examen['habilitado']): ?>
                                        <a href="<?= base_url("examen/{$examen['examen_id']}/seccion/1") ?>" class="btn btn-primary">
                                            <?= $examen['hasResult'] ? 'Ver Resultados' : 'Iniciar Examen' ?>
                                        </a>
                                    <?php else: ?>
                                        <button class="btn btn-secondary" disabled>No disponible</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No hay exámenes disponibles en este momento.</td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>


        <!-- Tab 4: Resultados -->
        <div class="tab-pane fade <?= ($step == 4) ? 'show active' : '' ?>" id="resultados" role="tabpanel" aria-labelledby="tab-resultados">
            <h3>Resultados</h3>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Examen</th>
                        <th>Reading</th>
                        <th>Writing</th>
                        <th>Listening</th>
                        <th>Speaking</th>
                        <th>Puntaje Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($resultados)): ?>
                        <?php foreach ($resultados as $resultado): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($resultado['titulo']) ?></strong></td>
                                <td><?= htmlspecialchars($resultado['puntaje_reading']) ?></td>
                                <td><?= htmlspecialchars($resultado['puntaje_writing']) ?></td>
                                <td><?= htmlspecialchars($resultado['puntaje_listening']) ?></td>
                                <td><?= htmlspecialchars($resultado['puntaje_speaking']) ?></td>
                                <td><strong><?= htmlspecialchars($resultado['puntaje_total']) ?></strong></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No hay resultados disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footer') ?>
<div class="container mt-3">
    <div class="row">
        <div class="col-md-6 text-start">
        </div>
        <div class="col-md-6 text-end">
            <button id="btn-prev" type="button" class="btn btn-primary" <?= ($step == 1) ? 'disabled' : '' ?>>Anterior</button>
            <button id="btn-next" type="button" class="btn btn-light" <?= ($step < 4 && $step >= 1) ? '' : 'disabled' ?>>Siguiente</button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('footer_scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const tabElements = Array.from(document.querySelectorAll('#processTabs .nav-link'));

        // Función para obtener el índice del tab activo
        function getCurrentStep() {
            return tabElements.findIndex(tab => tab.classList.contains('active')) + 1;
        }

        // Función para actualizar los botones
        function updateButtons(currentStep) {
            btnPrev.disabled = currentStep <= 1;
            btnNext.disabled = currentStep >= tabElements.length || tabElements[currentStep]?.hasAttribute('disabled');
        }

        // Función para mostrar el tab correspondiente
        function showTab(step) {
            const tab = tabElements[step - 1];
            if (!tab.hasAttribute('disabled')) {
                const tabInstance = new bootstrap.Tab(tab);
                tabInstance.show();
            }
        }

        // Eventos para los botones
        btnPrev.addEventListener('click', () => {
            const currentStep = getCurrentStep();
            if (currentStep > 1) {
                showTab(currentStep - 1);
                updateButtons(currentStep - 1);
            }
        });

        btnNext.addEventListener('click', () => {
            const currentStep = getCurrentStep();
            if (currentStep < tabElements.length) {
                showTab(currentStep + 1);
                updateButtons(currentStep + 1);
            }
        });

        // Inicializar botones según el tab activo
        updateButtons(getCurrentStep());
    });
</script>
<?= $this->endSection() ?>