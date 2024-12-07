<?= $this->extend('admin/layouts/login_template') ?>
<?= $this->section('content') ?>
<style>
    .login-cover-img {
        background-color: var(--bs-primary);
        border-left: 20px solid var(--clr-secondary);
        background-image: url('<?= base_url('admin/auth/ingresar') ?>assets/images/exams.jpg');
    }

    .wrapper {
        height: 100vh;
    }

    .card.shadow-none {
        --bs-card-border-color: 0px;
    }
</style>
<div class="container-xxl">
    <div class="row g-0 m-0">
        <div class="col-xl-6 col-lg-12">
            <div class="login-cover-wrapper">
                <div class="card shadow-none">
                    <div class="card-body">
                        <div class="text-center">
                            <p>Sistema de gestión y aplicación de exámenes de lenguas</p>
                            <h4>Inicio de sesión</h4>
                        </div>
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('admin/login') ?>" method="post" class="form-body row g-3">
                            <?= csrf_field() ?>
                            <div class="col-12">
                                <label for="username" class="form-label">Usuario</label>
                                <input type="text" class="form-control" id="username" name="username" <?= set_value('username') ?> required>
                            </div>
                            <div class="col-12">
                                <label for="inputPassword" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!--div class="col-12 col-lg-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckRemember" name="remember">
                                    <label class="form-check-label" for="flexSwitchCheckRemember">Recuérdame</label>
                                </div>
                            </div-->
                            <div class="col-12 col-lg-6 text-end">
                                <a onclick="alert('Envia un correo a adruiz@uv.mx')">¿Olvidaste tu contraseña?</a>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12 text-center">
                                <p class="mb-0">¿No tienes una cuenta? <a onclick="alert('Envia un correo a adruiz@uv.mx')">Regístrate</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-12">
            <div class="position-absolute top-0 h-100 d-xl-block d-none login-cover-img bg-primary">
                <div class="text-white p-5 w-100">
                    <!--img src="assets/images/uqroo.png" width="300" alt="scOpi" class="mb-4"-->
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>