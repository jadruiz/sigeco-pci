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

    public function obtenerInscripcionesPorUsuario($userId)
    {
        return $this->select('sgc_inscripciones_congreso.*, sgc_congresos.nombre as nombre_congreso,sgc_congresos.slug, sgc_congresos.estado, sgc_congresos.fecha_inicio, sgc_congresos.fecha_fin, sgc_congresos.cover_image')
            ->join('sgc_congresos', 'sgc_inscripciones_congreso.congreso_id = sgc_congresos.id')
            ->where('sgc_inscripciones_congreso.participante_id', $userId)
            ->orderBy('sgc_congresos.fecha_inicio', 'DESC')
            ->findAll();
    }

    public function obtenerEstadoInscripcion($userId, $congresoId)
    {
        return $this->where('participante_id', $userId)
            ->where('congreso_id', $congresoId)
            ->first();
    }

    public function contarInscripcionesPorEstado($userId, $estado)
    {
        return $this->where('participante_id', $userId)
            ->where('estado', $estado)
            ->countAllResults();
    }
}
