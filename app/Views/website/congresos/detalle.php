<?= $this->extend('website/layouts/main'); ?>
<?= $this->section('content'); ?>

<!-- Page Title -->
<section class="page-title">
    <div class="auto-container">
        <h1>
            <?= esc($congreso['nombre']) ?>
            <!-- Badge dinámico -->
            <?php if ($congreso['estado'] === 'activo'): ?>
                <span class="badge badge-success">Activo</span>
            <?php elseif ($congreso['estado'] === 'finalizado'): ?>
                <span class="badge badge-danger">Finalizado</span>
            <?php else: ?>
                <span class="badge badge-secondary">Estado: <?= esc($congreso['estado']); ?></span>
            <?php endif; ?>
        </h1>
        <ul class="bread-crumb clearfix">
            <li><a href="<?= site_url('/') ?>">Inicio</a></li>
            <li><a href="<?= site_url('/congresos') ?>">Congresos</a></li>
            <li><?= esc(strtoupper($congreso['slug'])) ?></li>
        </ul>
    </div>
</section>
<!-- End Page Title -->

<!-- About Section (Siempre presente) -->
<?= $this->include('website/congresos/partials/about_section'); ?>

<!-- Map Section -->
<?php if (in_array($congreso['estado'], ['planeacion', 'convocatoria', 'registro', 'activo'])): ?>
    <?= $this->include('website/congresos/partials/map_section'); ?>
<?php endif; ?>

<!-- Call for Papers -->
<?php if ($congreso['estado'] == 'convocatoria'): ?>
    <?= $this->include('website/congresos/partials/call_for_papers'); ?>
<?php endif; ?>

<!-- Registro -->
<?php if ($congreso['estado'] == 'registro'): ?>
    <?= $this->include('website/congresos/partials/registro_section'); ?>
<?php endif; ?>

<!-- Congreso Activo -->
<?php if ($congreso['estado'] == 'activo'): ?>
    <?= $this->include('website/congresos/partials/speakers_section'); ?>
    <?= $this->include('website/congresos/partials/shedule_section'); ?>
    <?= $this->include('website/congresos/partials/tickets_section'); ?>
    <?= $this->include('website/congresos/partials/sponsors_section'); ?>
    <?= $this->include('website/congresos/partials/news_section'); ?>
    <?= $this->include('website/congresos/partials/live_streaming_section'); ?>
    <?= $this->include('website/congresos/partials/media_section'); ?>
    <?= $this->include('website/congresos/partials/faq_section'); ?>
    <?= $this->include('website/congresos/partials/social_media_section'); ?>
<?php endif; ?>

<!-- Congreso Finalizado -->
<?php if ($congreso['estado'] == 'finalizado'): ?>
    <?= $this->include('website/congresos/partials/agradecimientos_section'); ?>
    <?= $this->include('website/congresos/partials/resultados_section'); ?>
    <?= $this->include('website/congresos/partials/speakers_section'); ?>
<?php endif; ?>

<?= $this->endSection(); ?>
