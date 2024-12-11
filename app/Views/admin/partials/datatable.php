<link rel="stylesheet" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css" />
<link rel="stylesheet" href="<?= base_url('assets/css/custom-datatables.css') ?>" />
<div class="container-fluid mt-3">
    <div id="contentDt" class="row">
        <div class="col-md-12">
            <table id="main-datatable" class="table table-striped vertical-align-middle" style="width:100%">
                <thead>
                    <tr>
                        <?php foreach ($columns as $column) : ?>
                            <th><?= $column['title'] ?? ' ' ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->section('extra-js') ?>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
<script src="<?= base_url('assets/js/custom-datatables.js') ?>"></script>
<script src="<?= base_url('assets/js/datatable-config.js') ?>"></script>
<script src="<?= base_url('assets/js/crud-config.js') ?>"></script>
<?= $this->endSection() ?>