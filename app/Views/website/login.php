<?= $this->extend('website/layouts/actions'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark text-white text-center">
                    <h4><i class="fa-solid fa-sign-in-alt"></i> Iniciar Sesión</h4>
                </div>
                <div class="card-body">
                    <!-- Alertas -->
                    <?php if (session()->has('alert')): ?>
                        <div class="alert alert-danger"><?= session('alert'); ?></div>
                    <?php endif; ?>
                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success"><?= session('success'); ?></div>
                    <?php endif; ?>

                    <!-- Formulario de Login -->
                    <form action="<?= base_url('iniciar-sesion/procesar'); ?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label"><i class="fa-solid fa-user"></i> Usuario</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fa-solid fa-lock"></i> Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100"><i class="fa-solid fa-sign-in-alt"></i> Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
