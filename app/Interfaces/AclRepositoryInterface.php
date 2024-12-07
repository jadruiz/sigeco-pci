<?php

namespace App\Interfaces;

/**
 * Interfaz para el repositorio de control de acceso (ACL).
 *
 * Define los contratos para las operaciones de acceso a datos relacionadas con
 * roles, permisos y asignaciones de permisos a usuarios.
 */
interface AclRepositoryInterface
{
    /**
     * Obtiene los permisos de un usuario basado en su ID.
     *
     * @param int|string $userId El ID del usuario.
     * @return array Lista de permisos del usuario.
     */
    public function getPermissionsByUserId($userId): array;

    /**
     * Verifica si un usuario tiene un permiso específico.
     *
     * @param int|string $userId El ID del usuario.
     * @param string $permissionKey La clave del permiso a verificar.
     * @return bool Retorna true si el usuario tiene el permiso, de lo contrario false.
     */
    public function checkUserPermission($userId, $permissionKey): bool;

    /**
     * Asigna un rol a un usuario.
     *
     * @param int|string $userId El ID del usuario.
     * @param string $roleKey La clave del rol a asignar.
     * @return bool Retorna true si el rol se asignó correctamente, de lo contrario false.
     */
    public function assignRoleToUser($userId, $roleKey): bool;

    // Agrega más métodos según sean necesarios para tu aplicación
}
