<?php

namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table = 'sgc_pagos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'participante_id',
        'nombre_invitado',
        'email_invitado',
        'telefono_invitado',
        'congreso_id',
        'monto',
        'moneda',
        'estado_pago',
        'referencia',
        'metodo_pago_id',
        'metodo_pago',
        'fecha_pago'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true; 
    protected $createdField  = 'fecha_pago';
    protected $updatedField  = null;

    protected $validationRules = [
        'participante_id' => 'permit_empty|integer',
        'congreso_id'     => 'required|integer',
        'monto'           => 'required|decimal',
        'moneda'          => 'required|string|max_length[10]',
        'estado_pago'     => 'required|in_list[pendiente,completado,cancelado]',
        'referencia'      => 'required|string|max_length[255]',
        'metodo_pago'     => 'required|string|max_length[50]'
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Método para registrar un pago.
     * @param array $data
     * @return int|false Devuelve el ID del pago registrado o false si falla.
     */
    public function registrarPago(array $data)
    {
        return $this->insert($data, true); // true retorna el ID
    }

    /**
     * Obtener pagos por referencia.
     * @param string $referencia
     * @return array|null
     */
    public function obtenerPagoPorReferencia($referencia)
    {
        return $this->where('referencia', $referencia)->first();
    }

    /**
     * Actualizar estado del pago.
     * @param string $referencia
     * @param string $estado
     * @return bool
     */
    public function actualizarEstadoPago($referencia, $estado)
    {
        return $this->where('referencia', $referencia)->set(['estado_pago' => $estado])->update();
    }
}
