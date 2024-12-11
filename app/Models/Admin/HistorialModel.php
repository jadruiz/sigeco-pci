<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class HistorialModel extends Model
{
    protected $table = 'sgc_articulos_historial';
    protected $primaryKey = 'id';
    protected $allowedFields = ['articulo_id', 'estado_anterior', 'estado_nuevo', 'usuario_id', 'fecha_cambio'];
}
