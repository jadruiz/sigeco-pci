<section class="pricing-section">
    <div class="auto-container">
        <div class="sec-title text-center">
            <span class="title">Regístrate</span>
            <h2>Elige un Paquete</h2>
        </div>

        <div class="row">
            <?php if (!empty($paquetes)): ?>
                <?php foreach ($paquetes as $index => $paquete): ?>
                    <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="<?= ($index + 1) * 200 ?>ms">
                        <div class="inner-box shadow-sm rounded d-flex flex-column h-100">
                            <!-- Imagen del paquete -->
                            <figure class="image text-center mb-3">
                                <img src="<?= base_url($paquete['imagen'] ?? 'uploads/default.png') ?>"
                                    alt="<?= esc($paquete['nombre']) ?> - Imagen del paquete"
                                    class="img-fluid rounded"
                                    loading="lazy" width="100" height="100">
                            </figure>

                            <!-- Título del paquete -->
                            <div class="text-center mb-2">
                                <span class="title font-weight-bold"><?= esc($paquete['nombre']) ?></span>
                                <p class="text-muted"><?= esc($paquete['descripcion']) ?></p>
                            </div>

                            <!-- Precio -->
                            <div class="text-center mb-2">
                                <h4 class="price text-primary font-weight-bold">$<?= number_format($paquete['costo_registro'], 2) ?></h4>
                            </div>

                            <!-- Lista de beneficios -->
                            <ul class="features list-unstyled flex-grow-1 mb-0">
                                <?php
                                $beneficios = isset($paquete['beneficios']) ? explode('|', $paquete['beneficios']) : [];
                                ?>
                                <?php if (!empty($beneficios)): ?>
                                    <?php foreach ($beneficios as $beneficio): ?>
                                        <li class="text-muted mb-1">
                                            <i class="fa fa-check text-primary"></i> <?= esc($beneficio) ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="text-danger">No hay beneficios especificados</li>
                                <?php endif; ?>
                            </ul>

                            <!-- Botón de compra -->
                            <div class="btn-box text-center mt-auto">
                                <a href="<?= site_url('registro?paquete_id=' . $paquete['id']) ?>" class="btn btn-primary">
                                    REGISTRARSE <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No hay paquetes disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .pricing-block .image img {
        max-height: 100px;
    }

    .pricing-block .features li {
        padding: 4px 0px;
    }

    /* Asegurar que cada bloque tiene la misma altura */
    .pricing-block .inner-box {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* Asegura que el botón quede abajo */
        height: 100%;
        /* Ocupa toda la altura */
        padding: 20px;
        border: 1px solid #ddd;
        background-color: #fff;
        transition: all 0.3s ease-in-out;
    }

    /* Espacio uniforme entre elementos */
    .features {
        margin-bottom: 20px;
    }

    /* Aumentar espacio entre las filas */
    .row {
        margin-bottom: 30px;
    }

    /* Mejorar diseño del botón */
    .btn-box .btn {
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        padding: 10px 20px;
        text-transform: uppercase;
    }
</style>