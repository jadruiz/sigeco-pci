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

    public function obtenerActividadesPorCongreso($congresoId)
    {
        return $this->select('sgc_actividades_programa.*, sgc_salas.nombre AS sala_nombre')
            ->join('sgc_salas', 'sgc_salas.id = sgc_actividades_programa.sala_id', 'left')
            ->where('sgc_actividades_programa.congreso_id', $congresoId)
            ->where('sgc_actividades_programa.activo', 1)
            ->orderBy('fecha_actividad', 'ASC')
            ->orderBy('hora_inicio', 'ASC')
            ->findAll();
    }

    public function obtenerActividadesAgrupadasPorFecha($congresoId)
    {
        $result = $this->where('congreso_id', $congresoId)
            ->orderBy('fecha_actividad', 'ASC')
            ->orderBy('hora_inicio', 'ASC')
            ->findAll();

        // Agrupar por fecha
        $agrupadas = [];
        foreach ($result as $actividad) {
            $fecha = $actividad['fecha_actividad'];
            $agrupadas[$fecha][] = $actividad;
        }

        return $agrupadas;
    }
}
