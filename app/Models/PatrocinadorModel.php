<?php

namespace App\Models;

use CodeIgniter\Model;

class PatrocinadorModel extends Model
{
    protected $table = 'sgc_patrocinadores';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'congreso_id',
        'nombre',
        'logo',
        'sitio_web',
        'descripcion',
        'activo'
    ];

    /**
     * Obtener patrocinadores por ID de congreso
     *
     * @param int $congreso_id
     * @return array
     */
    public function obtenerPatrocinadoresPorCongreso($congreso_id)
    {
        return $this->where(['congreso_id' => $congreso_id, 'activo' => 1])
                    ->findAll();
    }
}
