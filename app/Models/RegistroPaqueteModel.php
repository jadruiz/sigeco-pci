<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistroPaqueteModel extends Model
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
        'updated_at',
    ];

    /**
     * Obtener todos los paquetes activos por congreso.
     *
     * @param int $congresoId
     * @return array
     */
    public function getPaquetesByCongreso($congresoId)
    {
        return $this->where('congreso_id', $congresoId)
                    ->where('activo', 1)
                    ->findAll();
    }
}
