<?php

namespace App\Models;

use CodeIgniter\Model;

class ActividadProgramaModel extends Model
{
    protected $table = 'sgc_actividades_programa';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'congreso_id', 
        'titulo', 
        'descripcion', 
        'fecha_actividad', 
        'hora_inicio', 
        'hora_fin',
        'sala_id', 
        'tipo_actividad',
        'activo'
    ];
}
