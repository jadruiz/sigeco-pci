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
                        <div class="inner-box shadow-sm rounded">
                            <!-- Imagen del paquete -->
                            <figure class="image text-center">
                                <img src="<?= base_url($paquete['imagen'] ?? 'uploads/default.png') ?>" 
                                     alt="<?= esc($paquete['nombre']) ?> - Imagen del paquete"
                                     class="img-fluid rounded" 
                                     loading="lazy" width="300" height="200">
                            </figure>

                            <!-- Título del paquete -->
                            <div class="text-center">
                                <span class="title font-weight-bold d-block mt-3"><?= esc($paquete['nombre']) ?></span>
                                <p class="text-muted"><?= esc($paquete['descripcion']) ?></p>
                            </div>

                            <!-- Precio -->
                            <div class="text-center">
                                <h4 class="price text-primary font-weight-bold">$<?= number_format($paquete['costo_registro'], 2) ?></h4>
                            </div>

                            <!-- Lista de beneficios -->
                            <ul class="features list-unstyled mt-3">
                                <?php if (!empty($paquete['beneficios'])): ?>
                                    <?php foreach ($paquete['beneficios'] as $beneficio): ?>
                                        <li class="text-muted"><i class="fa fa-check text-success"></i> <?= esc($beneficio) ?></li>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <li class="text-danger">No hay beneficios especificados</li>
                                <?php endif; ?>
                            </ul>

                            <!-- Botón de compra -->
                            <div class="btn-box text-center mt-4">
                                <a href="<?= site_url('registro?paquete_id=' . $paquete['id']) ?>" class="theme-btn btn btn-primary">
                                    Comprar Ticket <i class="fas fa-arrow-right"></i>
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
<!--End Pricing Section -->
