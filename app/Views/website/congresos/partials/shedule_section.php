<!-- Shedule Section -->
<section class="shedule-section style-three">
    <div class="auto-container">
        <div class="sec-title text-center">
            <span class="title"><?= esc($congreso['nombre']); ?></span>
            <h2>Programación del Congreso</h2>
        </div>

        <div class="shedule-tabs tabs-box">
            <div class="btns-box">
                <!-- Tabs Buttons -->
                <ul class="tab-buttons clearfix">
                    <?php
                    $isFirst = true;
                    $dayCounter = 1;
                    ?>
                    <?php foreach ($actividadesPorFecha as $fecha => $actividades): ?>
                        <li class="tab-btn <?= $isFirst ? 'active-btn' : ''; ?>" data-tab="#tab-<?= date('Ymd', strtotime($fecha)); ?>">
                            Día <?= $dayCounter; ?> <br>
                            <span><?= date('d M, Y', strtotime($fecha)); ?></span>
                        </li>
                        <?php
                        $isFirst = false;
                        $dayCounter++;
                        ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="tabs-content">
                <?php $isFirst = true; ?>
                <?php foreach ($actividadesPorFecha as $fecha => $actividades): ?>
                    <!-- Tab Content -->
                    <div class="tab <?= $isFirst ? 'active-tab' : ''; ?>" id="tab-<?= date('Ymd', strtotime($fecha)); ?>">
                        <?php foreach ($actividades as $actividad): ?>
                            <!-- Shedule Block -->
                            <div class="shedule-block">
                                <div class="inner-box clearfix">
                                    <div class="content-box">
                                        <div class="date">
                                            <span class="icon far fa-clock"></span>
                                            <?= date('H:i', strtotime($actividad['hora_inicio'])); ?> - <?= date('H:i', strtotime($actividad['hora_fin'])); ?>
                                        </div>
                                        <h4><?= esc($actividad['titulo']); ?></h4>
                                        <div class="text"><?= esc($actividad['descripcion']); ?></div>
                                        <ul class="shedule-info clearfix">
                                            <li><span>Sala:</span> <?= esc($actividad['sala_nombre'] ?? 'Por definir'); ?></li>
                                            <li><span>Tipo:</span> <?= ucfirst($actividad['tipo_actividad']); ?></li>
                                        </ul>
                                    </div>
                                    <div class="btn-box">
                                        <a href="#" class="theme-btn btn-style-three">Leer Más</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php $isFirst = false; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<!--End Shedule Section -->