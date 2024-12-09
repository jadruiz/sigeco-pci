<?php
namespace App\Models;

use CodeIgniter\Model;

class NoticiaModel extends Model
{
    protected $table = 'sgc_noticias';
    protected $primaryKey = 'id';
    protected $allowedFields = ['congreso_id', 'titulo', 'contenido', 'imagen', 'fecha_publicacion', 'enlace', 'activo'];

    /**
     * Obtener noticias activas de un congreso específico.
     *
     * @param int $congresoId
     * @param int $limit
     * @return array
     */
    public function obtenerNoticiasPorCongreso($congresoId, $limit = 3)
    {
        return $this->where('congreso_id', $congresoId)
            ->where('activo', 1)
            ->orderBy('fecha_publicacion', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}
