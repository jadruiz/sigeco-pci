<!-- About Section -->
<section class="about-section">
    <div class="parallax-scene parallax-scene-1 anim-icons">
        <span data-depth="0.40" class="parallax-layer icon icon-circle-3"></span>
        <span data-depth="0.99" class="parallax-layer icon icon-circle-4"></span>
    </div>

    <div class="auto-container">
        <div class="row">
            <!-- Content Column -->
            <div class="content-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column">
                    <div class="sec-title">
                        <span class="title">Detalles del Congreso</span>
                        <h2><?= esc($congreso['nombre']) ?></h2>
                    </div>
                    
                    <div class="text">
                        <?= nl2br(esc($congreso['descripcion'])) ?>
                    </div>

                    <ul class="list-unstyled">
                        <li><strong>Fecha Inicio:</strong> <?= date('d M, Y', strtotime($congreso['fecha_inicio'])) ?></li>
                        <li><strong>Fecha Fin:</strong> <?= date('d M, Y', strtotime($congreso['fecha_fin'])) ?></li>
                        <li><strong>Lugar:</strong> <?= esc($congreso['lugar']) ?></li>
                    </ul>

                    <!-- Mostrar estado actual del congreso -->
                    <div class="estado-congreso">
                        <span class="badge bg-primary">
                            Estado Actual: <?= strtoupper($congreso['estado']) ?>
                        </span>
                    </div>

                    <!-- Botón condicional dependiendo del estado -->
                    <div class="btn-box mt-4">
                        <?php if ($congreso['estado'] == 'convocatoria'): ?>
                            <a href="<?= site_url("congreso/{$congreso['slug']}/convocatoria") ?>" class="theme-btn btn-style-one">
                                Ver Convocatoria <span class="flaticon-arrow"></span>
                            </a>
                        <?php elseif ($congreso['estado'] == 'registro'): ?>
                            <a href="<?= site_url("congreso/{$congreso['slug']}/registro") ?>" class="theme-btn btn-style-one">
                                Registrarse Ahora <span class="flaticon-arrow"></span>
                            </a>
                        <?php elseif ($congreso['estado'] == 'activo'): ?>
                            <a href="<?= site_url("congreso/{$congreso['slug']}/programa") ?>" class="theme-btn btn-style-one">
                                Ver Programa <span class="flaticon-arrow"></span>
                            </a>
                        <?php elseif ($congreso['estado'] == 'finalizado'): ?>
                            <a href="<?= site_url("congreso/{$congreso['slug']}/finalizado") ?>" class="theme-btn btn-style-one">
                                Ver Resultados <span class="flaticon-arrow"></span>
                            </a>
                        <?php else: ?>
                            <a href="#" class="theme-btn btn-style-one disabled">
                                Próximamente <span class="flaticon-arrow"></span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Image Column -->
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column">
                    <div class="image-box">
                        <figure class="image wow fadeInRight">
                            <a href="<?= base_url('uploads/congresos/' . esc($congreso['cover_image'])) ?>" 
                               class="lightbox-image" data-fancybox="images">
                                <img src="<?= base_url('uploads/congresos/' . esc($congreso['cover_image'])) ?>" 
                                     alt="<?= esc($congreso['nombre']) ?>">
                            </a>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End About Section -->
