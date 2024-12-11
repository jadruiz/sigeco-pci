<?= $this->extend('website/layouts/panel_participants') ?>
<?= $this->section('content'); ?>

<div class="container py-5">
<?php if (session('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
    <form action="<?= base_url('api/articulos/subir/' . $congreso['id']); ?>" 
          method="post" enctype="multipart/form-data" class="p-4 border rounded bg-white shadow needs-validation" novalidate>
          <?= csrf_field() ?>
        <h4 class="mb-4 text-center text-primary">Subir Artículo - <?= esc($congreso['nombre']); ?></h4>
        <!-- Primera Fila -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="titulo" class="form-label">Título del Artículo</label>
                <input type="text" name="titulo" id="titulo" class="form-control" 
                       placeholder="Escribe el título del artículo" aria-describedby="tituloHelp" required>
                <small id="tituloHelp" class="form-text text-muted">Debe ser breve y representativo del contenido.</small>
            </div>
            <div class="col-md-6">
                <label for="palabras_clave" class="form-label">Palabras Clave</label>
                <input type="text" name="palabras_clave" id="palabras_clave" class="form-control" 
                       placeholder="Ejemplo: IA, Machine Learning" aria-describedby="palabrasClaveHelp" required>
                <small id="palabrasClaveHelp" class="form-text text-muted">Separadas por comas.</small>
            </div>
        </div>
        <!-- Segunda Fila -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="autores" class="form-label">Autores Principales</label>
                <input type="text" name="autores" id="autores" class="form-control" 
                       placeholder="Ejemplo: John Doe, Jane Smith" aria-describedby="autoresHelp" required>
                <small id="autoresHelp" class="form-text text-muted">Lista de autores separados por coma.</small>
            </div>
            <div class="col-md-6">
                <label for="area_tematica" class="form-label">Área Temática</label>
                <select name="area_tematica" id="area_tematica" class="form-select" required>
                    <option value="" disabled selected>Selecciona una área</option>
                    <option value="1">Inteligencia Artificial</option>
                    <option value="2">Educación</option>
                    <option value="3">Ciencias de la Computación</option>
                </select>
            </div>
        </div>
        <!-- Tercera Fila -->
        <div class="row mb-3">
            <div class="col-md-12">
                <label for="resumen" class="form-label">Resumen</label>
                <textarea name="resumen" id="resumen" class="form-control" rows="4" 
                          placeholder="Escribe un breve resumen del artículo" required></textarea>
            </div>
        </div>
        <!-- Cuarta Fila -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="archivo" class="form-label">Archivo del Artículo</label>
                <input type="file" name="archivo" id="archivo" class="form-control" accept=".pdf,.zip,.tar" required>
                <small class="form-text text-muted">Formatos permitidos: PDF, ZIP, TAR. Máximo 10MB.</small>
            </div>
            <div class="col-md-6">
                <label for="archivo_fuente" class="form-label">Archivo Fuente (Opcional)</label>
                <input type="file" name="archivo_fuente" id="archivo_fuente" class="form-control" accept=".zip,.ta,.tex">
                <small class="form-text text-muted">Sube archivos fuente LaTeX comprimidos (ZIP/TAR).</small>
            </div>
        </div>

        <!-- Quinta Fila -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="idioma" class="form-label">Idioma del Artículo</label>
                <select name="idioma" id="idioma" class="form-select" required>
                    <option value="es">Español</option>
                    <option value="en">Inglés</option>
                    <option value="pt">Portugués</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="comentarios" class="form-label">Comentarios Adicionales</label>
                <textarea name="comentarios" id="comentarios" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <!-- Checkbox Declaración -->
        <div class="row mb-4">
            <div class="col-md-12 form-check">
                <input type="checkbox" name="declaracion" id="declaracion" class="form-check-input" required>
                <label class="form-check-label" for="declaracion">
                    Confirmo que el artículo es original y acepto los <a href="#">términos y condiciones</a>.
                </label>
            </div>
        </div>

        <!-- Botón Enviar -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary px-5">Subir Artículo</button>
        </div>
    </form>
</div>

<script>
// Validación Bootstrap
(function () {
    'use strict';
    window.addEventListener('load', function () {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function (form) {
            form.addEventListener('submit', function (event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?= $this->endSection(); ?>
