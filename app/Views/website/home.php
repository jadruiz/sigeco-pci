<?= $this->extend('website/layouts/main'); ?>
<?= $this->section('content'); ?>

<section class="main-slider">
    <div class="rev_slider_wrapper fullwidthbanner-container" id="rev_slider_one_wrapper" data-source="gallery">
        <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
            <ul>
                <?php if (!empty($congresos)) : ?>
                    <?php foreach ($congresos as $congreso) : ?>
                        <li data-transition="fade" data-description="Congreso Slide">
                            <!-- Imagen de fondo del congreso -->
                            <img src="<?= base_url('' . $congreso['cover_image']); ?>" alt="<?= esc($congreso['nombre']); ?>" class="rev-slidebg" 
                                data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" data-no-retina="">

                            <!-- Fecha del congreso -->
                            <div class="tp-caption" 
                                data-x="['left','left','left','left']" 
                                data-y="['middle','middle','middle','middle']" 
                                data-voffset="['-150','-150','-150','-150']" 
                                data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                                <div class="title">
                                    <?= esc(date('F d, Y', strtotime($congreso['fecha_inicio']))); ?> - <?= esc(date('F d, Y', strtotime($congreso['fecha_fin']))); ?>
                                </div>
                            </div>

                            <!-- Nombre del congreso -->
                            <div class="tp-caption" 
                                data-x="['left','left','left','left']" 
                                data-y="['middle','middle','middle','middle']" 
                                data-voffset="['-40','-30','-30','-50']"
                                data-frames='[{"delay":1500,"speed":1500,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                                <h2><?= esc($congreso['nombre']); ?></h2>
                            </div>

                            <!-- Botón de más información -->
                            <div class="tp-caption tp-resizeme" 
                                data-x="['left','left','left','left']" 
                                data-y="['middle','middle','middle','middle']" 
                                data-voffset="['125','125','125','135']"
                                data-frames='[{"delay":2000,"speed":1500,"frame":"0","from":"y:[100%];","to":"o:1;","ease":"Power4.easeInOut"}]'>
                                <div class="link-box">
                                    <a href="<?= base_url('congresos/detalle/' . $congreso['id']); ?>" class="theme-btn btn-style-one">
                                        Más Información <span class="flaticon-arrow"></span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li>
                        <div class="tp-caption" 
                            data-x="center" 
                            data-y="center" 
                            data-frames='[{"delay":500,"speed":1500,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                            <h2>No hay congresos disponibles</h2>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</section>
<!--End Main Slider-->

<?= $this->endSection(); ?>
