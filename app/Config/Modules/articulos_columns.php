<?php 
return [
    'filter_tabs' => [
        1 => 'Datos Generales',
        2 => 'Calificaciones',
        3 => 'Fechas',
        4 => 'Otros Filtros'
    ],
    'columns' => [
        // Datos Generales
        ['db' => 'articulo_id', 'title' => 'ID', 'visible' => true],
        ['db' => 'titulo', 'title' => 'Título', 'filter' => [
            'label' => 'Título',
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
                    'enviado' => 'Enviado',
                    'en_revision' => 'En Revisión',
                    'aceptado' => 'Aceptado',
                    'rechazado' => 'Rechazado',
                    'publicado' => 'Publicado'
                ]
            ],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'nombre_congreso', 'title' => 'Congreso', 'filter' => [
            'label' => 'Congreso',
            'form_element' => ['type' => 'text'],
            'num_columns' => 6,
            'tab' => 1
        ]],
        ['db' => 'categoria', 'title' => 'Categoría', 'filter' => [
            'label' => 'Categoría',
            'form_element' => ['type' => 'text'],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'autor_principal', 'title' => 'Autor Principal'],

        // Calificaciones
        ['db' => 'calificacion_promedio', 'title' => 'Promedio Calificación', 'filter' => [
            'label' => 'Rango Calificación',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 10],
            'num_columns' => 4,
            'tab' => 2
        ]],
        ['db' => 'total_comentarios', 'title' => 'Total Comentarios', 'filter' => [
            'label' => 'Rango Comentarios',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 100],
            'num_columns' => 4,
            'tab' => 2
        ]],

        // Fechas
        ['db' => 'fecha_envio', 'title' => 'Fecha Envío', 'filter' => [
            'label' => 'Fecha Envío',
            'form_element' => ['type' => 'date'],
            'num_columns' => 4,
            'tab' => 3
        ]],
        ['db' => 'ultima_actualizacion', 'title' => 'Última Actualización', 'filter' => [
            'label' => 'Fecha Actualización',
            'form_element' => ['type' => 'date'],
            'num_columns' => 4,
            'tab' => 3
        ]],
        ['db' => 'fecha_publicacion', 'title' => 'Fecha Publicación', 'filter' => [
            'label' => 'Fecha Publicación',
            'form_element' => ['type' => 'date'],
            'num_columns' => 4,
            'tab' => 3
        ]],

        // Otros Filtros
        ['db' => 'idioma', 'title' => 'Idioma', 'filter' => [
            'label' => 'Idioma',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'es' => 'Español',
                    'en' => 'Inglés'
                ]
            ],
            'num_columns' => 4,
            'tab' => 4
        ]],
        ['db' => 'numero_paginas', 'title' => 'Número Páginas', 'filter' => [
            'label' => 'Rango Páginas',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 1000],
            'num_columns' => 4,
            'tab' => 4
        ]],
        ['db' => 'visitas', 'title' => 'Visitas', 'filter' => [
            'label' => 'Rango Visitas',
            'form_element' => ['type' => 'number_range', 'min_value' => 0, 'max_value' => 10000],
            'num_columns' => 4,
            'tab' => 4
        ]]
    ]
];
