<?php

return [
    'filter_tabs' => [
        1 => 'Datos Generales',
        2 => 'Participación',
        3 => 'Finanzas',
        4 => 'Artículos',
        5 => 'Actividades',
        6 => 'Patrocinadores'
    ],
    'columns' => [
        // Datos Generales
        ['db' => 'congreso_id', 'title' => 'ID', 'visible' => true],
        ['db' => 'nombre_congreso', 'title' => 'Nombre Congreso', 'filter' => [
            'label' => 'Nombre Congreso',
            'form_element' => ['type' => 'text'],
            'num_columns' => 6,
            'tab' => 1
        ]],
        ['db' => 'estado', 'title' => 'Estado', 'filter' => [
            'label' => 'Estado',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'convocatoria' => 'Convocatoria',
                    'registro' => 'Registro',
                    'activo' => 'Activo',
                    'finalizado' => 'Finalizado'
                ]
            ],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'anio', 'title' => 'Año', 'filter' => [
            'label' => 'Año',
            'form_element' => ['type' => 'number_range', 'min_value' => 2000, 'max_value' => date('Y')],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'fecha_inicio', 'title' => 'Fecha Inicio', 'filter' => [
            'label' => 'Fecha Inicio',
            'form_element' => ['type' => 'date'],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'fecha_fin', 'title' => 'Fecha Fin', 'filter' => [
            'label' => 'Fecha Fin',
            'form_element' => ['type' => 'date'],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'organizador', 'title' => 'Organizador', 'filter' => [
            'label' => 'Organizador',
            'form_element' => ['type' => 'text'],
            'num_columns' => 6,
            'tab' => 1
        ]],

        // Participación
        ['db' => 'total_inscripciones', 'title' => 'Total Inscripciones', 'filter' => [
            'label' => 'Rango Inscripciones',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 1000],
            'num_columns' => 4,
            'tab' => 2
        ]],
        ['db' => 'inscripciones_completadas', 'title' => 'Completadas', 'filter' => [
            'label' => 'Rango Completadas',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 1000],
            'num_columns' => 4,
            'tab' => 2
        ]],
        ['db' => 'inscripciones_pendientes', 'title' => 'Pendientes', 'filter' => [
            'label' => 'Rango Pendientes',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 1000],
            'num_columns' => 4,
            'tab' => 2
        ]],
        ['db' => 'total_ponentes', 'title' => 'Total Ponentes', 'filter' => [
            'label' => 'Rango Ponentes',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 500],
            'num_columns' => 4,
            'tab' => 2
        ]],
        ['db' => 'total_asistentes', 'title' => 'Total Asistentes', 'filter' => [
            'label' => 'Rango Asistentes',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 5000],
            'num_columns' => 4,
            'tab' => 2
        ]],

        // Finanzas
        ['db' => 'ingresos_totales', 'title' => 'Ingresos Totales', 'filter' => [
            'label' => 'Rango Ingresos',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 100000],
            'num_columns' => 4,
            'tab' => 3
        ]],
        ['db' => 'pagos_pendientes', 'title' => 'Pagos Pendientes', 'filter' => [
            'label' => 'Rango Pagos Pendientes',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 50000],
            'num_columns' => 4,
            'tab' => 3
        ]],

        // Artículos
        ['db' => 'total_articulos', 'title' => 'Artículos Totales', 'filter' => [
            'label' => 'Rango Artículos',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 1000],
            'num_columns' => 4,
            'tab' => 4
        ]],
        ['db' => 'promedio_calificacion_articulos', 'title' => 'Promedio Calificación', 'filter' => [
            'label' => 'Rango Calificación',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 10],
            'num_columns' => 4,
            'tab' => 4
        ]],

        // Actividades
        ['db' => 'total_actividades', 'title' => 'Total Actividades', 'filter' => [
            'label' => 'Rango Actividades',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 100],
            'num_columns' => 4,
            'tab' => 5
        ]],

        // Patrocinadores
        ['db' => 'total_patrocinadores', 'title' => 'Total Patrocinadores', 'filter' => [
            'label' => 'Rango Patrocinadores',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 50],
            'num_columns' => 4,
            'tab' => 6
        ]]
    ]
];
