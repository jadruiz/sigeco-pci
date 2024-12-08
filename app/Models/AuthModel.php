<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
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

    /**
     * Buscar usuario por nombre de usuario
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)
            ->where('activo', 1)
            ->where('eliminado', 0)
            ->first();
    }

    /**
     * Crear un nuevo usuario
     */
    public function createUser(array $data)
    {
        $data['activo'] = 1;
        $data['eliminado'] = 0;
        return $this->insert($data);
    }

    public function getUserByUsernameOrEmail($input)
    {
        return $this->where('activo', 1)
            ->where('eliminado', 0)
            ->groupStart()
            ->where('username', $input)
            ->orWhere('email', $input)
            ->groupEnd()
            ->first();
    }
}
