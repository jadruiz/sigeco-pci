<?php

namespace App\Models;

use CodeIgniter\Model;

class ConvocatoriaModel extends Model
{
    protected $table = 'sgc_convocatorias';
    protected $allowedFields = ['congreso_id', 'descripcion', 'fecha_inicio', 'fecha_fin', 'activo'];

    public function getConvocatoriasByFilter($estado = null)
    {
        $builder = $this->select('sgc_convocatorias.*, sgc_congresos.nombre as nombre_congreso')
                        ->join('sgc_congresos', 'sgc_convocatorias.congreso_id = sgc_congresos.id')
                        ->where('sgc_convocatorias.activo', 1);

        if ($estado) {
            $builder->where('sgc_congresos.estado', $estado);
        }

        return $builder->get()->getResultArray();
    }
}
