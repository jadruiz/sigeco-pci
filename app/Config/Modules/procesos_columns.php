<?php

use App\Services\ModuleOptionsService;

$moduleOptionsService = new ModuleOptionsService();
$optionsEstatus = [
    'Habilitado' => 'Habilitado',
    'Deshabilitado' => 'Deshabilitado',
    'Archivado' => 'Archivado',
    'Pendiente' => 'Pendiente'
];

return [
    'filter_tabs' => [
        1 => 'Información del Proceso',
        2 => 'Configuración de Exámenes'
    ],
    'columns' => [
        // Información del Proceso
        [
            'db' => 'proceso_id',
            'title' => 'ID Proceso'
        ],
        [
            'db' => 'proceso_nombre',
            'title' => 'Nombre del Proceso'
        ],
        [
            'db' => 'proceso_descripcion',
            'title' => 'Descripción',
            'type' => 'html'
        ],
        [
            'db' => 'proceso_estatus',
            'title' => 'Estatus',
            'filter' => [
                'label' => 'Estatus',
                'form_element' => [
                    'type' => 'select',
                    'options' => $optionsEstatus
                ],
                'num_columns' => 4,
                'tab' => 1
            ]
        ],
        [
            'db' => 'proceso_abre_en',
            'title' => 'Fecha de Apertura',
            'filter' => [
                'label' => 'Fecha de Apertura',
                'form_element' => [
                    'type' => 'date'
                ],
                'num_columns' => 4,
                'tab' => 1
            ]
        ],
        [
            'db' => 'proceso_cierra_en',
            'title' => 'Fecha de Cierre',
            'filter' => [
                'label' => 'Fecha de Cierre',
                'form_element' => [
                    'type' => 'date'
                ],
                'num_columns' => 4,
                'tab' => 1
            ]
        ],

        // Configuración de Exámenes
        [
            'db' => 'total_examenes',
            'title' => 'Total de Exámenes',
            'filter' => [
                'label' => 'Número de Exámenes',
                'form_element' => [
                    'type' => 'number',
                    'placeholder' => 'Buscar por total de exámenes'
                ],
                'num_columns' => 4,
                'tab' => 2
            ]
        ]
    ]
];
