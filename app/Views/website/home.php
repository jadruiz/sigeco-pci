<?= $this->extend('website/layouts/main'); ?>
<?= $this->section('content'); ?>
<section class="main-slider">
    <div class="rev_slider_wrapper fullwidthbanner-container" id="rev_slider_one_wrapper" data-source="gallery">
        <div class="rev_slider fullwidthabanner" id="rev_slider_one" data-version="5.4.1">
            <ul>
                <?php if (!empty($congresos)) : ?>
                    <?php foreach ($congresos as $congreso) : ?>
                        <li data-transition="fade" data-description="Congreso Slide">
                            <!-- Imagen de fondo -->
                            <img src="<?= base_url($congreso['cover_image']); ?>" 
                                 alt="<?= esc($congreso['nombre']); ?>" 
                                 class="rev-slidebg" 
                                 data-bgfit="cover" 
                                 data-bgposition="center center" 
                                 data-bgrepeat="no-repeat">

                            <!-- Fecha del Congreso -->
                            <div class="tp-caption"
                                 data-x="left"
                                 data-y="middle"
                                 data-voffset="-150"
                                 data-frames='[{"delay":1000,"speed":1500,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                                <div class="title">
                                    <?= esc(date('d M, Y', strtotime($congreso['fecha_inicio']))); ?>
                                    - <?= esc(date('d M, Y', strtotime($congreso['fecha_fin']))); ?>
                                </div>
                            </div>

                            <!-- Título del Congreso -->
                            <div class="tp-caption"
                                 data-x="left"
                                 data-y="middle"
                                 data-voffset="-40"
                                 data-frames='[{"delay":1500,"speed":1500,"frame":"0","from":"y:[-100%];","to":"o:1;","ease":"Power3.easeInOut"}]'>
                                <h2><?= esc($congreso['nombre']); ?></h2>
                            </div>

                            <!-- Botón Más Información -->
                            <div class="tp-caption"
                                 data-x="left"
                                 data-y="middle"
                                 data-voffset="125"
                                 data-frames='[{"delay":2000,"speed":1500,"frame":"0","from":"y:[100%];","to":"o:1;","ease":"Power4.easeInOut"}]'>
                                <div class="link-box">
                                    <a href="<?= base_url('congresos/detalle/' . $congreso['id']); ?>" 
                                       class="theme-btn btn-style-one">
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
<?= $this->endSection(); ?>
