<?php

namespace App\Interfaces;

/**
 * Interfaz para el repositorio de roles.
 *
 * Define los contratos para las operaciones de acceso a datos relacionadas con
 * la gestión de roles en el sistema.
 */
interface RoleRepositoryInterface
{
    /**
     * Encuentra un rol por su identificador único.
     *
     * @param int $roleId El ID del rol.
     * @return object|null El rol encontrado o null si no existe.
     */
    public function findRoleById(int $roleId);

    /**
     * Encuentra un rol por su nombre.
     *
     * @param string $roleName El nombre del rol.
     * @return object|null El rol encontrado o null si no existe.
     */
    public function findRoleByName(string $roleName);

    /**
     * Crea un nuevo rol en el sistema.
     *
     * @param string $roleName El nombre del nuevo rol.
     * @param array|null $permissions Los permisos asociados al rol (opcional).
     * @return bool Retorna true si el rol fue creado con éxito, de lo contrario false.
     */
    public function createRole(string $roleName, array $permissions = null): bool;

    /**
     * Actualiza la información de un rol existente.
     *
     * @param int $roleId El ID del rol a actualizar.
     * @param array $roleData Datos del rol para actualizar.
     * @return bool Retorna true si el rol fue actualizado con éxito, de lo contrario false.
     */
    public function updateRole(int $roleId, array $roleData): bool;

    /**
     * Elimina un rol del sistema.
     *
     * @param int $roleId El ID del rol a eliminar.
     * @return bool Retorna true si el rol fue eliminado con éxito, de lo contrario false.
     */
    public function deleteRole(int $roleId): bool;

    /**
     * Asocia permisos a un rol.
     *
     * @param int $roleId El ID del rol.
     * @param array $permissions Lista de permisos a asociar.
     * @return bool Retorna true si los permisos fueron asociados con éxito, de lo contrario false.
     */
    public function attachPermissions(int $roleId, array $permissions): bool;

    /**
     * Desasocia permisos de un rol.
     *
     * @param int $roleId El ID del rol.
     * @param array $permissions Lista de permisos a desasociar.
     * @return bool Retorna true si los permisos fueron desasociados con éxito, de lo contrario false.
     */
    public function detachPermissions(int $roleId, array $permissions): bool;

    // Puedes incluir más métodos según las necesidades específicas de tu aplicación.
}
