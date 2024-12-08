<?php

namespace App\Models;

use CodeIgniter\Model;

class PaqueteModel extends Model
{
    protected $table = 'sgc_registro_paquetes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'congreso_id',
        'nombre',
        'descripcion',
        'costo_registro',
        'costo_participacion',
        'otros_costos',
        'activo',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Obtener paquetes por ID de congreso
     *
     * @param int $congreso_id
     * @return array
     */
    public function obtenerPaquetesPorCongreso($congreso_id)
    {
        return $this->where(['congreso_id' => $congreso_id, 'activo' => 1])
                    ->findAll();
    }
}
