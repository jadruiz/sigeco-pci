<?= $this->extend('website/layouts/main'); ?>
<?= $this->section('content'); ?>

<section class="main-slider">
    <div class="rev_slider_wrapper fullwidthbanner-container" id="rev_slider_one_wrapper" data-source="gallery">
        <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
            <ul>
                <?php if (!empty($congresos)) : ?>
                    <?php foreach ($congresos as $index => $congreso) : ?>
                        <li data-transition="parallaxvertical" 
                            data-description="Slide <?= esc($index + 1); ?>" 
                            data-easein="default" 
                            data-easeout="default"
                            data-fstransition="fade" 
                            data-masterspeed="1500"
                            data-slotamount="default">

                            <!-- Imagen de fondo -->
                            <img src="<?= base_url($congreso['cover_image']); ?>" 
                                 alt="<?= esc($congreso['nombre']); ?>" 
                                 class="rev-slidebg" 
                                 data-bgfit="cover" 
                                 data-bgparallax="10" 
                                 data-bgposition="center center" 
                                 data-bgrepeat="no-repeat" 
                                 data-no-retina="true">

                            <!-- Título -->
                            <div class="tp-caption" 
                                 data-x="left" 
                                 data-y="middle" 
                                 data-voffset="-150"
                                 data-frames='[{"delay":1000,"speed":1000,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                                <h2><?= esc($congreso['nombre']); ?></h2>
                            </div>

                            <!-- Descripción -->
                            <div class="tp-caption" 
                                 data-x="left" 
                                 data-y="middle" 
                                 data-voffset="-30"
                                 data-frames='[{"delay":1500,"speed":1000,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                                <p><?= esc(substr($congreso['descripcion'], 0, 150)); ?>...</p>
                            </div>

                            <!-- Botones -->
                            <div class="tp-caption" 
                                 data-x="left" 
                                 data-y="middle" 
                                 data-voffset="100"
                                 data-frames='[{"delay":2000,"speed":1000,"frame":"0","from":"y:[100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                                <div class="link-box">
                                    <a href="<?= base_url('congreso/' . esc($congreso['slug'])); ?>" 
                                       class="theme-btn btn-style-one">Ver más</a>
                                    <a href="<?= base_url('registro/inscripcion/' . esc($congreso['id'])); ?>" 
                                       class="theme-btn btn-style-two">Registrarse</a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Mensaje cuando no hay congresos -->
                    <li>
                        <div class="tp-caption text-center" 
                             data-x="center" 
                             data-y="center"
                             data-frames='[{"delay":1000,"speed":1000,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                            <h2 class="text-white">No hay congresos disponibles actualmente</h2>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>

<?= $this->endSection(); ?>
