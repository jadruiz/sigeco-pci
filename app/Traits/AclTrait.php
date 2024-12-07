<?php

namespace App\Traits;

use App\Libraries\KACL\AclService;

/**
 * Trait AclTrait.
 * 
 * Proporciona métodos reutilizables para integrar la verificación de permisos
 * y otras funcionalidades de ACL en controladores o modelos.
 */
trait AclTrait
{
    /**
     * Verifica si el usuario actual tiene un permiso específico.
     * 
     * @param string $permissionKey La clave del permiso a verificar.
     * @return bool Retorna true si el usuario tiene el permiso, false de lo contrario.
     */
    public function hasPermission(string $permissionKey): bool
    {
        $aclService = new AclService();
        $userId = session()->get('user_id'); // Asume que el ID del usuario se almacena en la sesión

        return $aclService->checkUserPermission($userId, $permissionKey);
    }

    /**
     * Verifica si el usuario actual tiene alguno de los roles especificados.
     * 
     * @param array $roles Un array de roles a verificar.
     * @return bool Retorna true si el usuario tiene al menos uno de los roles, false de lo contrario.
     */
    public function hasAnyRole(array $roles): bool
    {
        $aclService = new AclService();
        $userId = session()->get('user_id'); // Asume que el ID del usuario se almacena en la sesión

        foreach ($roles as $role) {
            if ($aclService->userHasRole($userId, $role)) {
                return true;
            }
        }

        return false;
    }

    // Aquí puedes agregar más métodos relacionados con ACL según las necesidades de tu aplicación.
}
