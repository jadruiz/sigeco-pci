<?= $this->extend('website/layouts/main'); ?>
<?= $this->section('content'); ?>

<section class="main-slider">
    <div class="rev_slider_wrapper fullwidthbanner-container" id="rev_slider_one_wrapper" data-source="gallery">
        <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
            <ul>
                <?php if (!empty($congresos)) : ?>
                    <?php foreach ($congresos as $index => $congreso) : ?>
                        <li data-transition="fade"
                            data-description="Slide <?= esc($index + 1); ?>"
                            data-masterspeed="1000">

                            <!-- Imagen de fondo -->
                            <img src="<?= base_url($congreso['cover_image']); ?>"
                                alt="<?= esc($congreso['nombre']); ?>"
                                class="rev-slidebg"
                                data-bgfit="cover"
                                data-bgposition="center center"
                                data-no-retina="true">

                            <!-- Título -->
                            <div class="tp-caption tp-resizeme"
                                data-x="center" data-y="middle" data-voffset="-100"
                                data-width="['700','600','500','400']"
                                data-textAlign="center"
                                data-frames='[{"delay":500,"speed":1200,"frame":"0","from":"y:-100%;opacity:0;","to":"o:1;","ease":"Power3.easeOut"}]'>
                                <h2 class="text-white"><?= esc($congreso['nombre']); ?></h2>
                            </div>

                            <!-- Descripción -->
                            <div class="tp-caption tp-resizeme"
                                data-x="center" data-y="middle" data-voffset="0"
                                data-width="['700','600','500','400']"
                                data-textAlign="center"
                                data-frames='[{"delay":1000,"speed":1200,"frame":"0","from":"y:100%;opacity:0;","to":"o:1;","ease":"Power3.easeOut"}]'>
                                <p class="text-white"><?= esc(substr($congreso['descripcion'], 0, 150)); ?>...</p>
                            </div>

                            <!-- Botones -->
                            <div class="tp-caption tp-resizeme"
                                data-x="center" data-y="middle" data-voffset="100"
                                data-frames='[{"delay":1500,"speed":1200,"frame":"0","from":"y:50%;opacity:0;","to":"o:1;","ease":"Power3.easeOut"}]'>
                                <a href="<?= base_url('congreso/' . esc($congreso['slug'])); ?>"
                                    class="theme-btn btn-style-one">Ver más</a>
                                <a href="<?= base_url('congreso/' . esc($congreso['slug']).'/registro'); ?>"
                                    class="theme-btn btn-style-two">Registrarse</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <!-- Slide predeterminado -->
                    <li>
                        <img src="<?= base_url('assets/images/default-slide.jpg'); ?>"
                            alt="No hay congresos"
                            class="rev-slidebg">
                        <div class="tp-caption text-center"
                            data-x="center" data-y="center">
                            <h2 class="text-white">No hay congresos disponibles actualmente</h2>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>
<style>
    .main-slider {
        background: var(--clr-primary-darkest);
    }
    .tp-bgimg.defaultimg {
    opacity: 0.16 !important;
}
</style>
<?= $this->endSection(); ?>