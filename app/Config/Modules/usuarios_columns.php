<?php

use App\Services\ModuleOptionsService;

$moduleOptionsService = new ModuleOptionsService();
$optionsDivision = $moduleOptionsService->getDivisionOptions();
$optionsCampus = $moduleOptionsService->getCampusOptions();

return [
    'filter_tabs' => [
        1 => 'Datos Generales',
        2 => 'Información Académica',
        3 => 'Roles y Estado'
    ],
    'columns' => [
        ['db' => 'id_usuario', 'title' => ''],
        ['db' => 'nombre_usuario', 'title' => 'Usuario'],
        ['db' => 'nombre_completo', 'title' => 'Nombre Completo', 'permission' => 'admin_ver_nombre'],
        ['db' => 'correo_electronico', 'title' => 'Correo Electrónico', 'permission' => 'admin_ver_correo'],
        ['db' => 'telefono', 'title' => 'Teléfono', 'permission' => 'admin_ver_telefono'],
        ['db' => 'roles', 'title' => 'Roles', 'filter' => [
            'label' => 'Roles',
            'form_element' => [
                'type' => 'text',
                'placeholder' => 'Buscar roles'
            ],
            'num_columns' => 4,
            'tab' => 3
        ]],
        ['db' => 'estado_usuario', 'title' => 'Estado', 'filter' => [
            'label' => 'Estado',
            'form_element' => [
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo'
                ]
            ],
            'num_columns' => 4,
            'tab' => 3
        ]],
        ['db' => 'fecha_registro_usuario', 'title' => 'Fecha de Registro'],

        // Información académica
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
        ['db' => 'id_carrera', 'title' => 'ID Carrera', 'visible' => false, 'filter' => [
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
    ]
];
