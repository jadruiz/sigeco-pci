<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('global-search') ?><?= $this->include('admin/partials/searchbar') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('admin/partials/breadcrumbs') ?>
<?= $this->include('admin/partials/alertas') ?>
<?= $this->include('admin/partials/panel_filtros') ?>
<div class="d-flex justify-content-end mt-3">
    <?php if (has_permission('admin_agregar_' . $moduleKey) || has_role('Administrador')) : ?>
        <button type="button" class="btn btn-success btn-sm me-2" onclick="CRUD.agregar()">
            <ion-icon name="add-circle-outline"></ion-icon> Agregar
        </button>
    <?php endif; ?>
    <?php if (has_permission('admin_importar_sustentantes')) : ?>
        <button type="button" class="btn btn-info btn-sm" onclick="CRUD.importar()">
            <ion-icon name="cloud-upload-outline"></ion-icon> Importar
        </button>
    <?php endif; ?>
</div>
<?= $this->include('admin/partials/datatable') ?>
<?= $this->endSection() ?>
<?= $this->section('extra-js') ?>
<script>
    $(document).ready(function() {
        const moduleConfig = {
            tableId: '#main-datatable',
            ajaxUrl: "<?= base_url('admin/' . $moduleKey . '/lista_json') ?>",
            columns: <?= json_encode(array_map(function ($col) {
                            return [
                                'data' => $col['dt'],
                                'visible' => isset($col['visible']) ? $col['visible'] : true
                            ];
                        }, $columns)) ?>,
            columnDefs: [{
                targets: 0,
                orderable: false,
                render: function(data, type, row) {
                    return `<?php if (has_permission('admin_editar_' . $moduleKey) || has_role('Administrador')) : ?>
                            <button type="button" class="btn btn-warning btn-sm" onclick="CRUD.editar(${row[0]})">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <?php endif; ?>
                            <?php if (has_permission('admin_eliminar_' . $moduleKey) || has_role('Administrador')) : ?>
                            <button type="button" class="btn btn-danger btn-sm" onclick="CRUD.eliminar(${row[0]})">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                            <?php endif; ?>
                            <?php if (has_permission('admin_eliminar_' . $moduleKey) || has_role('Administrador')) : ?>
                            <a type="button" class="btn btn-info btn-sm" href="<?=base_url('admin/articulos/revision/')?>${row[0]}">
                                <ion-icon name="checkmark-circle-outline"></ion-icon>
                            </a>
                            <?php endif; ?>`;
                }
            }]
        };

        const table = initModuleDatatable(moduleConfig);
        initFilterToolsBar(table);

        $('#global-search').on('keyup', function() {
            handleGlobalSearch($(this).val(), table);
        });

        $('#modalidad_carrera, #id_campus, #id_division').on('change', function() {
            var modalidad = $('#modalidad_carrera').val();
            var campus = $('#id_campus').val();
            var division = $('#id_division').val();
            cargarOpcionesCarreras(modalidad, campus, division);
        });

        initInputFormFilterActions(table);
    });
</script>
<?= $this->endSection() ?>