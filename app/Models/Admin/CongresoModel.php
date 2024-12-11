<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class CongresoModel extends Model
{
    protected $table = 'sgc_congresos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombre',
        'descripcion',
        'cover_image',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'lugar',
        'direccion',
        'latitud',
        'longitud',
        'cupos',
        'organizador',
        'activo',
        'created_at',
        'updated_at'
    ];
}
