<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class RevisionModel extends Model
{
    protected $table = 'sgc_evaluaciones_articulos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['articulo_id', 'revisor_id', 'comentarios', 'calificacion', 'estado_evaluacion', 'fecha_evaluacion'];
}
