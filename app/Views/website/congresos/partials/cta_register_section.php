<!-- Call To Action -->
<section class="call-to-action">
    <div class="auto-container">
        <div class="content-box text-center">
            <span class="title"><?= esc($congreso['nombre']); ?></span>
            <h3>¡Regístrate ahora!</h3>
            <div class="text">
                Asegura tu lugar. No pierdas la oportunidad de ser parte de este evento único lleno de conocimiento, innovación y networking.
            </div>
            <div class="btn-box">
                <a href="<?= site_url('congresos/registro/' . esc($congreso['slug'])); ?>" class="theme-btn btn-style-one">
                    REGISTRARSE <span class="flaticon-arrow"></span>
                </a>
            </div>
        </div>
    </div>
</section>
<!-- End Call To Action -->
