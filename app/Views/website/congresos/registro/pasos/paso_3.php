<h3>Paso 3: Seleccionar Plan</h3>
<form method="post" action="/registro/guardarPlan">
    <div>
        <?php foreach ($planes as $plan): ?>
            <label>
                <input type="radio" name="paquete_id" value="<?= esc($plan['id']) ?>" required>
                <?= esc($plan['nombre']) ?> - $<?= esc(number_format($plan['costo_registro'], 2)) ?>
            </label>
            <br>
        <?php endforeach; ?>
    </div>
    <button type="submit" class="btn btn-success">Finalizar Registro</button>
</form>
