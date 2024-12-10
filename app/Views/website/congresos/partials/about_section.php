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
                            <a href="<?= base_url(esc($congreso['cover_image'])) ?>" 
                               class="lightbox-image" data-fancybox="images">
                                <img src="<?= base_url(esc($congreso['cover_image'])) ?>" 
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
<!-- Fechas Importantes -->
<section class="important-dates-section py-5 bg-light">
    <div class="container">
        <!-- Encabezado -->
        <div class="text-center mb-4">
            <h2 class="fw-bold text-primary">Fechas Importantes</h2>
            <p class="text-muted fs-5">Momentos clave del congreso organizados por etapas.</p>
        </div>

        <!-- Categorías de Fechas -->
        <?php
        setlocale(LC_TIME, 'es_ES.UTF-8', 'Spanish_Spain', 'es_ES');
        $hoy = new DateTime(); // Fecha actual
        
        $fechasCategorizadas = [
            'Convocatoria' => [
                ['titulo' => 'Publicación de Convocatoria', 'fecha' => $congreso['fecha_publicacion_convocatoria'], 'descripcion' => 'Apertura oficial de la convocatoria.'],
            ],
            'Registro' => [
                ['titulo' => 'Inicio de Registro', 'fecha' => $congreso['fecha_inicio_registro'], 'descripcion' => 'Inicio del registro de participantes.'],
                ['titulo' => 'Fin de Registro', 'fecha' => $congreso['fecha_fin_registro'], 'descripcion' => 'Cierre del registro de participantes.'],
            ],
            'Artículos' => [
                ['titulo' => 'Inicio de Presentación de Artículos', 'fecha' => $congreso['fecha_inicio_presentacion_articulos'], 'descripcion' => 'Inicio para el envío de artículos.'],
                ['titulo' => 'Fin de Presentación de Artículos', 'fecha' => $congreso['fecha_fin_presentacion_articulos'], 'descripcion' => 'Cierre del plazo de envíos.'],
                ['titulo' => 'Notificación de Aceptación', 'fecha' => $congreso['fecha_notificacion_aceptacion'], 'descripcion' => 'Anuncio de los artículos aceptados.'],
            ],
            'Actividades' => [
                ['titulo' => 'Inicio de Actividades', 'fecha' => $congreso['fecha_inicio_actividades'], 'descripcion' => 'Comienzo de las actividades del congreso.'],
                ['titulo' => 'Cierre de Actividades', 'fecha' => $congreso['fecha_cierre_actividades'], 'descripcion' => 'Finalización del evento.'],
            ],
        ];
        ?>

        <!-- Renderización de Categorías -->
        <div class="row">
            <?php foreach ($fechasCategorizadas as $categoria => $fechas): ?>
                <div class="col-12 col-md-6 mb-4">
                    <h4 class="fw-bold text-secondary mb-3"><?= esc($categoria); ?></h4>
                    <ul class="list-group list-group-flush shadow-sm rounded">
                        <?php foreach ($fechas as $fecha): 
                            if (!empty($fecha['fecha'])):
                                $fechaEvento = new DateTime($fecha['fecha']);
                                $formattedDate = strftime('%A, %d de %B de %Y', strtotime($fecha['fecha']));
                                $addToCalendarUrl = "https://www.google.com/calendar/render?action=TEMPLATE&text=" . urlencode($fecha['titulo']) .
                                    "&dates=" . date('Ymd', strtotime($fecha['fecha'])) . "/" . date('Ymd', strtotime($fecha['fecha'])) .
                                    "&details=" . urlencode($fecha['descripcion']) . "&sf=true&output=xml";
                                $eventoPasado = $fechaEvento < $hoy; // Verificar si la fecha ya pasó
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div class="me-auto">
                                    <div class="fw-bold fs-5 text-dark"><?= esc($fecha['titulo']); ?></div>
                                    <div class="text-muted small"><?= esc($fecha['descripcion']); ?></div>
                                </div>
                                <div class="text-end">
                                    <div class="text-primary fw-bold fs-6"><?= ucfirst($formattedDate); ?></div>
                                    <?php if (!$eventoPasado): ?>
                                        <a href="<?= esc($addToCalendarUrl); ?>" target="_blank" class="text-decoration-none small text-success">
                                            <i class="bi bi-calendar-plus me-1"></i>Agregar a calendario
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small"><i class="bi bi-calendar-x me-1"></i>Evento pasado</span>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<!-- End Fechas Importantes -->

