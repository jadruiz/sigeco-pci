<?= $this->extend('website/layouts/main_clean') ?>

<?= $this->section('header_page') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/registro/registro.css') ?>" />
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<section class="page-title">
    <div class="auto-container">
        <h1>
            Registro al "<?= esc($congreso['nombre']) ?>"
        </h1>
    </div>
</section>
<style>
    .page-title {
    padding: 60px 0 60px;
}
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
        font-size: 18px;
        font-weight: 500;
    }

    @media (max-width: 576px) {
        .title-process {
            display: none !important;
        }
    }
</style>

<div class="nav-tabs-container">
    <div class="container">
        <ul class="nav nav-tabs" id="registrationTabs" role="tablist">
            <?php 
            $index = 1;
            foreach ($etapas as $key => $etapa): ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= ($paso == $index) ? 'active' : '' ?>"
                        href="<?= base_url("congreso/$slug/registro/paso/$index") ?>"
                        <?= ($pasoActualUsuario < $index) ? 'disabled' : '' ?>>
                        <strong><?= $index . '. ' . ucfirst($key) ?></strong><br>
                    </a>
                </li>
            <?php 
            $index++; 
            endforeach; ?>
        </ul>
    </div>
</div>

<div class="container mt-4 mb-5">
    <div class="tab-content" id="registrationTabsContent">
        <?php
        // Renderizar la sub-vista correspondiente al paso actual
        switch ($paso):
            case 1:
                echo view('website/congresos/registro/pasos/paso_1', ['slug' => $slug]);
                break;

            case 2:
                echo view('website/congresos/registro/pasos/paso_2', ['planes' => $planes ?? []]);
                break;

            case 3:
                echo view('website/registro/pasos/paso_3', [
                    'usuario' => $usuario,
                    'congreso' => $congreso,
                ]);
                break;

            case 4:
                echo view('website/registro/pasos/paso_4_finalizar');
                break;
        endswitch;
        ?>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 text-start">
            <?php if ($prevStepUrl): ?>
                <a href="<?= $prevStepUrl ?>" id="btn-previous" class="btn btn-lg btn-secondary">Anterior</a>
            <?php endif; ?>
        </div>
        <div class="col-md-6 text-end">
            <?php if ($nextStepUrl): ?>
                <a href="<?= $nextStepUrl ?>" id="btn-next" class="btn btn-lg btn-primary">Siguiente</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('bottom_body') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = Array.from(document.querySelectorAll('#registrationTabs .nav-link'));

        tabs.forEach(tab => {
            if (tab.hasAttribute('disabled')) {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();
                });
            }
        });
    });
</script>
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<footer class="main-footer">
    <div class="auto-container">
        <!-- Footer Content -->
        <div class="footer-content">
            <div class="copyright-text">© Copyright <a href="#"></a> <?= date('Y'); ?> <?= env('app.sgc.fullnameAcronyms', '') . ' | ' . env('app.sgc.fullname', '') ?>. Todos los derechos reservados.</div>
        </div>
    </div>
</footer>
<?= $this->endSection() ?>