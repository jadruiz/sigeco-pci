<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistroProgresoModel extends Model
{
    protected $table = 'sgc_registro_progreso';
    protected $primaryKey = 'id';
    protected $allowedFields = ['participante_id', 'paso_actual', 'fecha_actualizacion'];
    protected $useTimestamps = false;
}
