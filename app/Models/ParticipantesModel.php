<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipantesModel extends Model
{
    protected $table = 'sgc_participantes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'password',
        'email',
        'telefono',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'activo',
        'eliminado',
        'creado_en',
        'actualizado_en'
    ];

    protected $useTimestamps = false;

    /**
     * Obtener participante por nombre de usuario
     *
     * @param string $username
     * @return array|null
     */
    public function obtenerPorUsername($username)
    {
        return $this->where('username', $username)
                    ->where('activo', 1)
                    ->where('eliminado', 0)
                    ->first();
    }
}
