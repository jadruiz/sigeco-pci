<?php

namespace App\Models;

use CodeIgniter\Model;

class PaqueteModel extends Model
{
    protected $table = 'sgc_registro_paquetes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'congreso_id',
        'imagen', // Nueva columna para la imagen
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
     * Obtener paquetes activos con beneficios por congreso.
     *
     * @param int $congresoId
     * @return array
     */
    public function obtenerPaquetesConBeneficios($congresoId)
    {
        return $this->select(
                'sgc_registro_paquetes.id, 
                 sgc_registro_paquetes.nombre, 
                 sgc_registro_paquetes.imagen, 
                 sgc_registro_paquetes.costo_registro, 
                 sgc_registro_paquetes.descripcion, 
                 GROUP_CONCAT(sgc_paquete_beneficios.beneficio SEPARATOR "|") AS beneficios'
            )
            ->join('sgc_paquete_beneficios', 'sgc_paquete_beneficios.paquete_id = sgc_registro_paquetes.id', 'left')
            ->where('sgc_registro_paquetes.congreso_id', $congresoId)
            ->where('sgc_registro_paquetes.activo', 1)
            ->groupBy('sgc_registro_paquetes.id')
            ->orderBy('sgc_registro_paquetes.costo_registro', 'ASC') // Ordenar por costo
            ->findAll();
    }

    /**
     * Obtener costos adicionales asociados a un paquete específico.
     *
     * @param int $paqueteId
     * @return array
     */
    public function obtenerCostosAdicionales($paqueteId)
    {
        return $this->db->table('sgc_paquetes_costos_adicionales')
            ->select(
                'sgc_costos_adicionales.nombre, 
                 sgc_costos_adicionales.descripcion, 
                 sgc_costos_adicionales.costo'
            )
            ->join('sgc_costos_adicionales', 'sgc_costos_adicionales.id = sgc_paquetes_costos_adicionales.costo_adicional_id')
            ->where('sgc_paquetes_costos_adicionales.paquete_id', $paqueteId)
            ->get()
            ->getResultArray();
    }

    /**
     * Obtener un paquete específico con sus beneficios y costos adicionales.
     *
     * @param int $paqueteId
     * @return array
     */
    public function obtenerPaqueteDetalle($paqueteId)
    {
        // Obtener detalles del paquete con beneficios
        $paquete = $this->select(
                'sgc_registro_paquetes.id, 
                 sgc_registro_paquetes.nombre, 
                 sgc_registro_paquetes.imagen, 
                 sgc_registro_paquetes.costo_registro, 
                 sgc_registro_paquetes.descripcion, 
                 GROUP_CONCAT(sgc_paquete_beneficios.beneficio SEPARATOR "|") AS beneficios'
            )
            ->join('sgc_paquete_beneficios', 'sgc_paquete_beneficios.paquete_id = sgc_registro_paquetes.id', 'left')
            ->where('sgc_registro_paquetes.id', $paqueteId)
            ->groupBy('sgc_registro_paquetes.id')
            ->first();

        // Obtener costos adicionales si existen
        $costosAdicionales = $this->obtenerCostosAdicionales($paqueteId);

        // Combinar el resultado
        if ($paquete) {
            $paquete['beneficios'] = !empty($paquete['beneficios']) ? explode('|', $paquete['beneficios']) : [];
            $paquete['costos_adicionales'] = $costosAdicionales;
        }

        return $paquete;
    }
}
