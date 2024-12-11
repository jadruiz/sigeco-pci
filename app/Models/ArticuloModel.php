<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticuloModel extends Model
{
    protected $table = 'sgc_articulos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'congreso_id',
        'categoria_id',
        'participante_id',
        'titulo',
        'resumen',
        'ruta_archivo',
        'ruta_archivo_fuente',
        'estado',
        'fecha_envio',
        'fecha_actualizacion',
        'fecha_publicacion',
        'idioma',
        'numero_paginas',
        'comentarios',
        'doi',
        'visitas'
    ];    

    protected $useTimestamps = false;

    /**
     * Obtener todos los artículos de un congreso específico
     *
     * @param int $congresoId
     * @return array
     */
    public function obtenerArticulosPorCongreso($congresoId)
    {
        return $this->where('congreso_id', $congresoId)->findAll();
    }

    /**
     * Obtener artículos filtrados por estado
     *
     * @param int $congresoId
     * @param string $estado
     * @return array
     */
    public function obtenerArticulosPorEstado($congresoId, $estado)
    {
        return $this->where('congreso_id', $congresoId)
                    ->where('estado', $estado)
                    ->findAll();
    }

    /**
     * Obtener un artículo por ID
     *
     * @param int $articuloId
     * @return array|null
     */
    public function obtenerArticuloPorId($articuloId)
    {
        return $this->find($articuloId);
    }

    /**
     * Crear un nuevo artículo
     *
     * @param array $data
     * @return int|bool ID del artículo insertado o false si falla
     */
    public function crearArticulo($data)
    {
        return $this->insert($data);
    }

    /**
     * Actualizar un artículo existente
     *
     * @param int $articuloId
     * @param array $data
     * @return bool
     */
    public function actualizarArticulo($articuloId, $data)
    {
        return $this->update($articuloId, $data);
    }

    /**
     * Eliminar un artículo
     *
     * @param int $articuloId
     * @return bool
     */
    public function eliminarArticulo($articuloId)
    {
        return $this->delete($articuloId);
    }

    /**
     * Contar el número de artículos por estado
     *
     * @param int $congresoId
     * @param string $estado
     * @return int
     */
    public function contarArticulosPorEstado($congresoId, $estado)
    {
        return $this->where('congreso_id', $congresoId)
                    ->where('estado', $estado)
                    ->countAllResults();
    }

    /**
     * Buscar artículos por título o resumen (búsqueda general)
     *
     * @param int $congresoId
     * @param string $keyword
     * @return array
     */
    public function buscarArticulos($congresoId, $keyword)
    {
        return $this->where('congreso_id', $congresoId)
                    ->groupStart()
                        ->like('titulo', $keyword)
                        ->orLike('resumen', $keyword)
                    ->groupEnd()
                    ->findAll();
    }
}
