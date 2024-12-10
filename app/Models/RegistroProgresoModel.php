<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistroProgresoModel extends Model
{
    protected $table = 'sgc_registro_progreso';
    protected $primaryKey = 'id';
    protected $allowedFields = ['participante_id', 'congreso_id','paquete_id','estado', 'paso_actual', 'fecha_actualizacion'];
    protected $useTimestamps = false;
}
