<?php

namespace App\Models;

use CodeIgniter\Model;

class InscripcionCongresoModel extends Model
{
    protected $table = 'sgc_inscripciones_congreso';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'congreso_id',
        'participante_id',
        'paquete_id',
        'fecha_inscripcion',
        'estado',
        'notas'
    ];
    protected $useTimestamps = false;

    // Función para insertar o actualizar una inscripción
    public function guardarInscripcion($data)
    {
        $existing = $this->where('participante_id', $data['participante_id'])
                         ->where('congreso_id', $data['congreso_id'])
                         ->first();
        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            return $this->insert($data);
        }
    }
}
