<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\KACL\UserModel;

class UserRepository implements UserRepositoryInterface
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function findAll()
    {
        // Asume que el modelo UserModel ya está utilizando Soft Deletes
        // Esto solo traerá los usuarios que no han sido marcados como eliminados
        return $this->userModel->where('deleted_at', null)->findAll();
    }

    public function find($id)
    {
        // Similar al método findAll, solo obtiene el usuario si no ha sido eliminado
        return $this->userModel->where('deleted_at', null)->find($id);
    }

    public function create(array $data)
    {
        // Hashea la contraseña antes de crear el usuario
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $this->userModel->insert($data);
    }

    public function update($id, array $data)
    {
        // Verifica si se ha proporcionado una nueva contraseña y no está vacía
        if (isset($data['password']) && !empty($data['password'])) {
            // Hashea la nueva contraseña
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            // Elimina la contraseña del array de datos si no se desea actualizar
            unset($data['password']);
        }

        // Actualiza el usuario en la base de datos con los datos proporcionados
        return $this->userModel->update($id, $data);
    }

    public function delete($id)
    {
        // Realiza un soft delete si tu modelo está configurado para ello
        return $this->userModel->delete($id);
    }
}
