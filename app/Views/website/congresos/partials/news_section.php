<!-- News Section -->
<section class="news-section">
    <div class="auto-container">
        <!-- Título de la sección -->
        <div class="sec-title text-center">
            <span class="title">Últimas Novedades</span>
            <h2>Noticias del Congreso</h2>
        </div>

        <div class="row">
            <?php if (!empty($noticias)): ?>
                <?php foreach ($noticias as $index => $noticia): ?>
                    <!-- News Block -->
                    <div class="news-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="<?= $index * 200 ?>ms">
                        <div class="inner-box shadow-sm">
                            <!-- Imagen de la noticia -->
                            <div class="image-box">
                                <figure class="image">
                                    <img src="<?= base_url($noticia['imagen'] ?? 'uploads/default-news.jpg') ?>" 
                                         alt="<?= esc($noticia['titulo']) ?>" 
                                         class="img-fluid rounded" loading="lazy">
                                </figure>
                            </div>

                            <!-- Contenido de la noticia -->
                            <div class="lower-content">
                                <div class="date">
                                    <?= date('d', strtotime($noticia['fecha_publicacion'])) ?>
                                    <span><?= date('M', strtotime($noticia['fecha_publicacion'])) ?></span>
                                </div>
                                <h4>
                                    <a href="<?= esc($noticia['enlace'] ?? '#') ?>" target="_blank">
                                        <?= esc($noticia['titulo']) ?>
                                    </a>
                                </h4>
                                <div class="text-box">
                                    <div class="text">
                                        <?= esc(word_limiter($noticia['contenido'], 20)) ?>
                                    </div>
                                    <?php if (!empty($noticia['enlace'])): ?>
                                        <div class="link-box">
                                            <a href="<?= esc($noticia['enlace']) ?>" target="_blank">Leer Más</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mensaje si no hay noticias -->
                <div class="col-12 text-center">
                    <p class="text-muted">No hay noticias disponibles en este momento.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- End News Section -->
