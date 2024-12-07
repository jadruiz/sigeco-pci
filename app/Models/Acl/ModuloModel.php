<?php

namespace App\Models\Acl;

use CodeIgniter\Model;

class ModuloModel extends Model
{
    protected $table = 'acl_modulos';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'clave',
        'icono',
        'path',
        'nombre',
        'descripcion',
        'activo',
        'orden',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';
    protected $validationRules = [
        'clave'      => 'permit_empty|max_length[30]|is_unique[acl_modulos.clave]',
        'icono'      => 'permit_empty|max_length[100]',
        'path'       => 'permit_empty|max_length[255]',
        'nombre'     => 'required|max_length[50]|is_unique[acl_modulos.nombre]',
        'descripcion' => 'permit_empty|string',
        'activo'     => 'required|in_list[0,1]',
        'orden'      => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'nombre' => [
            'is_unique' => 'El nombre ya está en uso.'
        ],
        'clave' => [
            'is_unique' => 'La clave ya está en uso.'
        ]
    ];
}
