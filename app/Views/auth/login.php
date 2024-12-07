<?= $this->extend('layouts/template_hero') ?>
<?= $this->section('header') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<style>
    .login-wrapper .btn {
        width: 100%;
    }

    input::placeholder {
        color: #dee2e6 !important;
    }
</style>
<div class="container login-wrapper mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <form id="loginForm" action="<?= base_url('login/autenticar') ?>" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Ingresa tu Clave de Aspirante</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="AS24-01245" required>
                </div>
                <button type="button" id="validateButton" class="btn btn-lg btn-primary">INICIAR</button>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="validationModalLabel">Confirmar Datos</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalBody"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="confirmButton" type="button" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#validateButton').on('click', function(e) {
            e.preventDefault();
            const username = $('#username').val();
            if (username) {
                $.ajax({
                    url: '<?= base_url('login/validarUsuario') ?>',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        username: username
                    }),
                    success: function(response) {
                        const modalBody = $('#modalBody');
                        const modal = new bootstrap.Modal($('#validationModal'), {});

                        if (response.success) {
                            modalBody.html(`
    <p class="fw-bold">¿Son estos tus datos?</p>
    <table class="table table-bordered table-sm">
        <tbody>
            <tr>
                <th class="text-end">Clave de aspirante:</th>
                <td class="text-start">${response.usuario.username}</td>
            </tr>
            <tr>
                <th class="text-end">Nombre:</th>
                <td class="text-start">${response.usuario.nombre_completo}</td>
            </tr>
            <tr>
                <th class="text-end">Correo:</th>
                <td class="text-start">${response.usuario.email}</td>
            </tr>
            <tr>
                <th class="text-end">Carrera:</th>
                <td class="text-start">${response.usuario.carrera_detalle}</td>
            </tr>
        </tbody>
    </table>
`);
                        } else {
                            modalBody.html(`<p class="text-danger">${response.error}</p>`);
                        }

                        modal.show();
                    },
                    error: function() {
                        alert('Hubo un error al validar los datos. Inténtalo nuevamente.');
                    }
                });
            } else {
                alert('Por favor, ingresa tu clave de aspirante.');
            }
        });

        $('#confirmButton').on('click', function() {
            $('#loginForm').submit();
        });
    });
</script>

<?= $this->endSection() ?>