<?php

use App\Services\ModuleOptionsService;

$moduleOptionsService = new ModuleOptionsService();

return [
    'filter_tabs' => [
        1 => 'Datos Generales',
        2 => 'Configuración de Proceso'
    ],
    'columns' => [
        ['db' => 'examen_id', 'title' => 'ID Examen'],
        ['db' => 'version', 'title' => 'Versión'],
        ['db' => 'titulo', 'title' => 'Título'],
        ['db' => 'descripcion', 'title' => 'Descripción', 'visible' => false, 'filter' => [
            'label' => 'Descripción',
            'form_element' => [
                'type' => 'text',
                'placeholder' => 'Buscar descripción'
            ],
            'tab' => 1,
            'num_columns' => 6
        ]],
        ['db' => 'creado_en', 'title' => 'Fecha de Creación', 'filter' => [
            'label' => 'Fecha de Creación',
            'form_element' => [
                'type' => 'date_range'
            ],
            'tab' => 1,
            'num_columns' => 6
        ]],
        ['db' => 'actualizado_en', 'title' => 'Última Actualización'],
        ['db' => 'examen_previo_id', 'title' => 'Examen Previo', 'visible' => false, 'filter' => [
            'label' => 'Examen Previo',
            'form_element' => [
                'type' => 'select',
                'options' => []
            ],
            'tab' => 2,
            'num_columns' => 6
        ]],
        ['db' => 'proceso_id', 'title' => 'ID Proceso', 'visible' => false],
        ['db' => 'proceso_nombre', 'title' => 'Proceso', 'filter' => [
            'label' => 'Proceso',
            'form_element' => [
                'type' => 'select',
                'options' => []
            ],
            'tab' => 2,
            'num_columns' => 6
        ]],
        ['db' => 'proceso_estatus', 'title' => 'Proceso Estatus', 'visible' => false, 'filter' => [
            'label' => 'Estatus',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    '1' => 'Sí',
                    '0' => 'No'
                ]
            ],
            'tab' => 2,
            'num_columns' => 6
        ]],
        ['db' => 'numero_preguntas', 'title' => '# Preguntas', 'filter' => [
            'label' => 'Número de Preguntas',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 1,
                'max_value' => 100
            ],
            'tab' => 2,
            'num_columns' => 6
        ]]
    ]
];
