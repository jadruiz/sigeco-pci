<!-- app/Views/admin/partials/panel_filtros.php -->
<?php $collapsible = $collapsible ?? false; ?>
<?php if ($collapsible) : ?>
    <div class="accordion" id="filterAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFilterPanel">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilterPanel" aria-expanded="false" aria-controls="collapseFilterPanel">
                    Búsqueda avanzada
                </button>
            </h2>
            <div id="collapseFilterPanel" class="accordion-collapse collapse" aria-labelledby="headingFilterPanel" data-bs-parent="#filterAccordion">
                <div class="accordion-body">
<?php endif; ?>
<form id="form-filter" method="POST" class="form-horizontal">
    <div class="container">
        <!-- Navigation Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <?php foreach ($filter_tabs as $tabId => $tabName) : ?>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $tabId == 1 ? 'active' : '' ?>" id="tab-<?= $tabId ?>-tab" data-bs-toggle="tab" data-bs-target="#tab-<?= $tabId ?>" type="button" role="tab" aria-controls="tab-<?= $tabId ?>" aria-selected="<?= $tabId == 1 ? 'true' : 'false' ?>">
                        <?= $tabName ?>
                    </button>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3">
            <?php foreach ($filter_tabs as $tabId => $tabName) : ?>
                <div class="tab-pane fade <?= $tabId == 1 ? 'show active' : '' ?>" id="tab-<?= $tabId ?>" role="tabpanel" aria-labelledby="tab-<?= $tabId ?>-tab">
                    <div class="row mb-3">
                        <?php
                        $currentRowWidth = 0;
                        foreach ($columns as $column) :
                            if (isset($column['filter']) && $column['filter']['tab'] == $tabId) :
                                $num_columns = $column['filter']['num_columns'] ?? 3;
                                $col_width = 12 / $num_columns;
                                if ($currentRowWidth + $col_width > 12) {
                                    echo '</div><div class="row mb-3">';
                                    $currentRowWidth = 0;
                                }
                                $currentRowWidth += $col_width;
                        ?>
                            <div class="col-md-<?= $col_width ?>">
                                <label for="<?= $column['db'] ?>" class="form-label"><?= $column['filter']['label'] ?></label>
                                <?php if ($column['filter']['form_element']['type'] == 'select') : ?>
                                    <select name="<?= $column['db'] ?>" id="<?= $column['db'] ?>" class="form-select">
                                        <?php foreach ($column['filter']['form_element']['options'] as $value => $text) : ?>
                                            <option value="<?= $value ?>"><?= $text ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php elseif ($column['filter']['form_element']['type'] == 'number_range') : ?>
                                    <div class="input-group">
                                        <?php
                                        $min_value = $column['filter']['form_element']['min_value'] ?? '';
                                        $max_value = $column['filter']['form_element']['max_value'] ?? '';
                                        ?>
                                        <input type="number" name="<?= $column['db'] ?>_min" class="form-control range-min" placeholder="Min" value="<?= $min_value ?>">
                                        <span class="input-group-text">a</span>
                                        <input type="number" name="<?= $column['db'] ?>_max" class="form-control range-max" placeholder="Max" value="<?= $max_value ?>">
                                    </div>
                                <?php elseif ($column['filter']['form_element']['type'] == 'date') : ?>
                                    <div class="input-group">
                                        <input type="date" name="<?= $column['db'] ?>_start" class="form-control" placeholder="Desde">
                                        <span class="input-group-text">a</span>
                                        <input type="date" name="<?= $column['db'] ?>_end" class="form-control" placeholder="Hasta">
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</form>
<?php if ($collapsible) : ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
