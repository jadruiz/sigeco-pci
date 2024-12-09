<!-- Sponsors Section -->
<section class="clients-section style-four">
    <div class="auto-container">
        <div class="sponsors-outer">
            <!--Sponsors Carousel-->
            <ul class="platinum-carousel owl-carousel owl-theme">
                <?php foreach ($patrocinadores as $patrocinador): ?>
                    <li class="slide-item">
                        <figure class="image">
                            <a href="<?= esc($patrocinador['sitio_web']); ?>" target="_blank">
                                <img src="<?= base_url(esc($patrocinador['logo'])); ?>" 
                                     alt="<?= esc($patrocinador['nombre']); ?>">
                            </a>
                        </figure>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
