<?php

namespace App\Models;

use CodeIgniter\Model;

class CongresoPatrocinadorModel extends Model
{
    protected $table = 'sgc_congreso_patrocinadores';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'congreso_id',
        'patrocinador_id',
        'nivel'
    ];

    /**
     * Obtener patrocinadores asociados a un congreso
     *
     * @param int $congresoId
     * @return array
     */
    public function obtenerPatrocinadoresPorCongreso($congresoId)
    {
        return $this->select('sgc_patrocinadores.nombre, sgc_patrocinadores.logo, sgc_patrocinadores.sitio_web, sgc_congreso_patrocinadores.nivel')
            ->join('sgc_patrocinadores', 'sgc_patrocinadores.id = sgc_congreso_patrocinadores.patrocinador_id')
            ->where('sgc_congreso_patrocinadores.congreso_id', $congresoId)
            ->where('sgc_patrocinadores.activo', 1)
            ->orderBy('sgc_congreso_patrocinadores.nivel', 'ASC')
            ->findAll();
    }
}
