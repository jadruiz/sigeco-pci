<?php
// app/Helpers/auth_helper.php

use App\Services\Acl\AuthService;

if (!function_exists('has_permission')) {
    function has_permission($permiso)
    {
        $authService = new AuthService();
        return $authService->hasPermission($permiso);
    }
}

if (!function_exists('has_role')) {
    function has_role($rol)
    {
        $authService = new AuthService();
        return $authService->hasRole($rol);
    }
}
