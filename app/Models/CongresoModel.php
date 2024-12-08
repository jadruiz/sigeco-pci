<?php

namespace App\Models;

use CodeIgniter\Model;

class CongresoModel extends Model
{
    protected $table = 'sgc_congresos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'cover_image',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'anio',
        'fecha_inicio',
        'fecha_fin',
        'activo',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    
    public function getUltimosCongresos($limit = 10)
    {
        return $this->where('activo', 1)
                    ->orderBy('fecha_inicio', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function obtenerCongresoPorId($id)
    {
        return $this->where('id', $id)->first();
    }

     /**
     * Obtener congresos ordenados por estado y fecha.
     */
    public function obtenerCongresosOrdenados()
    {
        return $this->orderBy("CASE 
                                    WHEN estado = 'activo' THEN 1
                                    WHEN estado = 'registro' THEN 2
                                    WHEN estado = 'convocatoria' THEN 3
                                    WHEN estado = 'finalizado' THEN 4
                                END", 'ASC')
                    ->orderBy('fecha_inicio', 'DESC')
                    ->findAll();
    }
    public function obtenerCongresosActivos($limit = 10)
{
    return $this->where('activo', 1)
                ->whereNotIn('estado', ['edicion']) // Excluir 'edicion'
                ->orderBy("CASE 
                                WHEN estado = 'activo' THEN 1
                                WHEN estado = 'registro' THEN 2
                                WHEN estado = 'convocatoria' THEN 3
                                WHEN estado = 'finalizado' THEN 4
                            END", 'ASC')
                ->orderBy('fecha_inicio', 'DESC')
                ->findAll($limit);
}

}
