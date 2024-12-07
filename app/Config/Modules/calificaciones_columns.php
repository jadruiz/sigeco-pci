<?php

use App\Services\ModuleOptionsService;

$moduleOptionsService = new ModuleOptionsService();
$optionsDivision = $moduleOptionsService->getDivisionOptions();
$optionsCampus = $moduleOptionsService->getCampusOptions();
return [
    'filter_tabs' => [
        1 => 'Datos Generales',
        2 => 'Información Académica',
        3 => 'Procesos y Exámenes',
        4 => 'Resultados',
    ],
    'columns' => [
        ['db' => 'resultado_id'],
        ['db' => 'estado_calificacion', 'visible' => false],
        ['db' => 'nombre_completo', 'title' => 'Nombre Completo', 'permission' => 'admin_ver_nombre'],
        ['db' => 'usuario_email', 'title' => 'Correo Electrónico', 'permission' => 'admin_ver_correo'],
        ['db' => 'usuario_telefono', 'title' => 'Teléfono', 'permission' => 'admin_ver_telefono'],

        // Información académica
        ['db' => 'nombre_carrera', 'title' => 'Carrera', 'tab' => 2],
        ['db' => 'nombre_division', 'title' => 'División', 'visible' => false, 'filter' => [
            'label' => 'División',
            'form_element' => [
                'type' => 'select',
                'options' => $optionsDivision
            ],
            'tab' => 2,
            'num_columns' => 4
        ]],
        ['db' => 'nombre_campus', 'title' => 'Campus', 'visible' => false, 'filter' => [
            'label' => 'Campus',
            'form_element' => [
                'type' => 'select',
                'options' => $optionsCampus
            ],
            'tab' => 2,
            'num_columns' => 4
        ]],

        // Procesos y exámenes
        ['db' => 'examen_id', 'title' => 'ID Examen', 'tab' => 3],
        ['db' => 'examen_titulo', 'title' => 'Examen Título', 'tab' => 3],
        ['db' => 'resultado_id', 'title' => 'ID Resultado'],

        // Calificaciones
        ['db' => 'total_puntaje', 'title' => 'Puntaje Total', 'filter' => [
            'label' => 'Global',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 0,
                'max_value' => 100
            ],
            'tab' => 4,
            'num_columns' => 4
        ]],
        ['db' => 'lectura_puntaje', 'title' => 'Reading', 'visible' => true, 'filter' => [
            'label' => 'Reading',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 0,
                'max_value' => 100
            ],
            'tab' => 4,
            'num_columns' => 4
        ]],
        ['db' => 'escritura_puntaje', 'title' => 'Writing', 'visible' => true, 'filter' => [
            'label' => 'Writing',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 0,
                'max_value' => 100
            ],
            'tab' => 4,
            'num_columns' => 4
        ]],
        ['db' => 'escucha_puntaje', 'title' => 'Listenig', 'visible' => true, 'filter' => [
            'label' => 'Listenig',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 0,
                'max_value' => 100
            ],
            'tab' => 4,
            'num_columns' => 4
        ]],
        ['db' => 'habla_puntaje', 'title' => 'Speaking', 'visible' => true, 'filter' => [
            'label' => 'Speaking',
            'form_element' => [
                'type' => 'number_range',
                'min_value' => 0,
                'max_value' => 100
            ],
            'tab' => 4,
            'num_columns' => 4
        ]],

        // Estado y fechas del proceso de calificación
        ['db' => 'estado_calificacion', 'title' => 'Estado Calificación', 'filter' => [
            'label' => 'Estado Calificación',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'Calificado' => 'Calificado',
                    'Pendiente' => 'Pendiente'
                ]
            ],
            'tab' => 4,
            'num_columns' => 4
        ]],
        ['db' => 'proceso_nombre', 'title' => 'Proceso', 'tab' => 3],
        ['db' => 'proceso_fecha_apertura', 'title' => 'Apertura Proceso'],
        ['db' => 'proceso_fecha_cierre', 'title' => 'Cierre Proceso'],
        ['db' => 'fecha_resultado_creacion', 'title' => 'Fecha Resultado']
    ]
];
