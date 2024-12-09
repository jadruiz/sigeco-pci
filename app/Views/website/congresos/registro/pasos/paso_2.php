<h3>Paso 2: Seleccionar Congreso</h3>
<form method="post" action="/registro/avanzarPaso">
    <div>
        <?php foreach ($congresos as $congreso): ?>
            <label>
                <input type="radio" name="congreso_id" value="<?= esc($congreso['id']) ?>" required>
                <?= esc($congreso['nombre']) ?> - <?= esc($congreso['descripcion']) ?>
            </label>
            <br>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-primary">Siguiente</button>
</form>
