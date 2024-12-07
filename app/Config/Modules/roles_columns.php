<?php

return [
    'filter_tabs' => [
        1 => 'Datos Generales'
    ],
    'columns' => [
        // Datos generales del rol
        ['db' => 'rol_id', 'title' => ''],
        ['db' => 'rol_nombre', 'title' => 'Nombre del rol'],
        ['db' => 'rol_descripcion', 'title' => 'Descripción'],

        // Estado del rol
        ['db' => 'rol_activo', 'title' => 'Estado', 'filter' => [
            'label' => 'Estado',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    '1' => 'Activo',
                    '0' => 'Inactivo'
                ]
            ],
            'num_columns' => 4,
            'tab' => 1
        ]],
        ['db' => 'rol_creado_en', 'title' => 'Fecha de Creación'],
    ],
    'actions' => [
        'add' => [
            'label' => 'Agregar Rol',
            'icon' => 'add-circle-outline',
            'url' => 'admin/roles/agregar',
            'permissions' => ['admin_agregar_rol']
        ],
        'edit' => [
            'label' => 'Editar',
            'icon' => 'create-outline',
            'url' => 'admin/roles/editar',
            'permissions' => ['admin_editar_rol']
        ],
        'delete' => [
            'label' => 'Eliminar',
            'icon' => 'trash-outline',
            'url' => 'admin/roles/eliminar',
            'permissions' => ['admin_eliminar_rol']
        ]
    ]
];
