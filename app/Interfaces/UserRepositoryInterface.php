<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    /**
     * Recupera todos los usuarios.
     *
     * @return mixed
     */
    public function findAll();

    /**
     * Busca un usuario por su ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function find($id);

    /**
     * Crea un nuevo usuario con los datos proporcionados.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * Actualiza los datos de un usuario existente.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

    /**
     * Elimina un usuario por su ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete($id);
}
