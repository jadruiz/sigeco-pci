<?php

use App\Services\ModuleOptionsService;

$moduleOptionsService = new ModuleOptionsService();
$optionsDivision = $moduleOptionsService->getDivisionOptions();
$optionsCampus = $moduleOptionsService->getCampusOptions();
return [
    'filter_tabs' => [
        1 => 'Datos Generales',
        2 => 'Información Académica',
        3 => 'Procesos y Exámenes'
    ],
    'columns' => [
        ['db' => 'id_usuario', 'title' => ''],
        ['db' => 'nombre_usuario', 'title' => 'Usuario'],
        ['db' => 'nombre_completo', 'title' => 'Nombre completo', 'permission' => 'admin_ver_nombre'],
        ['db' => 'correo_electronico', 'title' => 'Correo electrónico', 'permission' => 'admin_ver_correo'],
        ['db' => 'telefono', 'title' => 'Teléfono', 'permission' => 'admin_ver_telefono'],
        ['db' => 'nombre_carrera_completo', 'title' => 'Carrera'],
        ['db' => 'modalidad_carrera', 'title' => 'Modalidad', 'visible' => false, 'filter' => [
            'label' => 'Modalidad',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todas',
                    'Escolarizado' => 'Escolarizado'
                ]
            ],
            'num_columns' => 4,
            'tab' => 2
        ]],
        ['db' => 'id_division', 'title' => 'División', 'visible' => false, 'filter' => [
            'label' => 'División',
            'form_element' => [
                'type' => 'select',
                'options' => $optionsDivision
            ],
            'tab' => 2,
            'num_columns' => 4
        ]],
        ['db' => 'id_campus', 'title' => 'Campus', 'visible' => false, 'filter' => [
            'label' => 'Campus',
            'form_element' => [
                'type' => 'select',
                'options' => $optionsCampus
            ],
            'tab' => 2,
            'num_columns' => 4
        ]],
        ['db' => 'id_carrera', 'title' => 'Id carrera', 'visible' => false, 'filter' => [
            'label' => 'Carrera',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todas'
                ]
            ],
            'tab' => 2,
            'num_columns' => 4
        ]],
        ['db' => 'total_procesos_presentados', 'title' => '# Procesos', 'filter' => [
            'label' => 'Rango de Procesos',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 0,
                'max_value' => 100
            ],
            'num_columns' => 4,
            'tab' => 3
        ]],
        ['db' => 'total_examenes_presentados', 'title' => '# Exámenes', 'filter' => [
            'label' => 'Rango de Exámenes',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 0,
                'max_value' => 100
            ],
            'num_columns' => 4,
            'tab' => 3
        ]],
        ['db' => 'fecha_ultima_actualizacion_resultados', 'title' => 'Último Exa.'],
        ['db' => 'es_usuario_de_prueba', 'title' => 'Es Prueba', 'visible' => false, 'filter' => [
            'label' => 'Es Prueba',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    '1' => 'Sí',
                    '0' => 'No'
                ]
            ],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'es_usuario_observador', 'title' => 'Es Observador', 'visible' => false, 'filter' => [
            'label' => 'Es Observador',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    '1' => 'Sí',
                    '0' => 'No'
                ]
            ],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'fecha_registro_usuario', 'title' => 'Registro']
    ]
];
