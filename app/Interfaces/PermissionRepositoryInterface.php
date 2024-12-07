<?php

namespace App\Interfaces;

/**
 * Interfaz para el repositorio de permisos.
 *
 * Define los contratos para las operaciones de acceso a datos relacionadas con
 * la gestión de permisos en el sistema.
 */
interface PermissionRepositoryInterface
{
    /**
     * Obtiene un permiso por su ID.
     *
     * @param int $permissionId El ID del permiso.
     * @return object|null Detalles del permiso o null si no se encuentra.
     */
    public function findPermissionById($permissionId);

    /**
     * Obtiene un permiso por su clave.
     *
     * @param string $permissionKey La clave del permiso a buscar.
     * @return object|null Detalles del permiso o null si no se encuentra.
     */
    public function findPermissionByKey($permissionKey);

    /**
     * Crea un nuevo permiso.
     *
     * @param string $permissionKey La clave del nuevo permiso.
     * @param string $description Descripción del permiso.
     * @return bool Retorna true si el permiso fue creado exitosamente, false de lo contrario.
     */
    public function createPermission($permissionKey, $description);

    /**
     * Actualiza un permiso existente.
     *
     * @param int $permissionId El ID del permiso a actualizar.
     * @param array $permissionData Datos del permiso a actualizar.
     * @return bool Retorna true si el permiso fue actualizado exitosamente, false de lo contrario.
     */
    public function updatePermission($permissionId, $permissionData);

    /**
     * Elimina un permiso.
     *
     * @param int $permissionId El ID del permiso a eliminar.
     * @return bool Retorna true si el permiso fue eliminado exitosamente, false de lo contrario.
     */
    public function deletePermission($permissionId);

    // Métodos adicionales según las necesidades de tu aplicación, como asignar o revocar permisos a roles o usuarios.
}
