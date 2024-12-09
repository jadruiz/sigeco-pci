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

    // Obtener paquetes activos por congreso
    public function obtenerPaquetesConDetalles($congresoId)
    {
        return $this->select('sgc_registro_paquetes.*, GROUP_CONCAT(sgc_paquete_beneficios.beneficio) AS beneficios')
            ->join('sgc_paquete_beneficios', 'sgc_paquete_beneficios.paquete_id = sgc_registro_paquetes.id', 'left')
            ->where(['sgc_registro_paquetes.congreso_id' => $congresoId, 'sgc_registro_paquetes.activo' => 1])
            ->groupBy('sgc_registro_paquetes.id')
            ->findAll();
    }

    // Obtener costos adicionales por paquete
    public function obtenerCostosAdicionales($paqueteId)
    {
        return $this->db->table('sgc_paquetes_costos_adicionales')
            ->select('sgc_costos_adicionales.nombre, sgc_costos_adicionales.descripcion, sgc_costos_adicionales.costo')
            ->join('sgc_costos_adicionales', 'sgc_costos_adicionales.id = sgc_paquetes_costos_adicionales.costo_adicional_id')
            ->where('sgc_paquetes_costos_adicionales.paquete_id', $paqueteId)
            ->get()
            ->getResultArray();
    }

   public function obtenerPaquetesConBeneficios($congresoId)
{
    return $this->select('sgc_registro_paquetes.id, sgc_registro_paquetes.nombre, sgc_registro_paquetes.costo_registro, sgc_registro_paquetes.descripcion, GROUP_CONCAT(sgc_paquete_beneficios.beneficio SEPARATOR "|") as beneficios')
        ->join('sgc_paquete_beneficios', 'sgc_paquete_beneficios.paquete_id = sgc_registro_paquetes.id', 'left')
        ->where('sgc_registro_paquetes.congreso_id', $congresoId)
        ->where('sgc_registro_paquetes.activo', 1)
        ->groupBy('sgc_registro_paquetes.id')
        ->findAll();
}
}
