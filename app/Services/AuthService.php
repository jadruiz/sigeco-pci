<?php

namespace App\Services;

use App\Models\Admin\UsuarioModel;

class AuthService
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function isAuthenticated(): bool
    {
        return session()->has('adm_usuario_id');
    }

    public function getUserId(): ?int
    {
        return session()->get('adm_usuario_id');
    }

    public function hasPermission(string $permiso): bool
    {
        if (!$this->isAuthenticated()) {
            return false;
        }
        $permisos = session()->get('permisos', []);
        return in_array($permiso, $permisos);
    }

    public function hasRole(string $rol): bool
    {
        $roles = session()->get('roles', []);
        return in_array($rol, $roles);
    }

    public function guardarRolesYPermisosEnSesion(int $userId)
    {
        $roles = $this->usuarioModel->getRolesPorUsuario($userId);
        $permisos = $this->usuarioModel->getPermisosPorUsuario($userId);
        session()->set([
            'roles' => array_column($roles, 'nombre'),
            'permisos' => array_column($permisos, 'nombre'),
        ]);
    }

    public function attemptLogin(string $username, string $password): bool
    {
        $user = $this->usuarioModel->where('username', $username)
            ->where('activo', 1)
            ->first();
        if ($user && password_verify($password, $user['password_hash'])) {
            $this->setUserSession($user);
            $this->guardarRolesYPermisosEnSesion($user['id']);
            return true;
        }

        return false;
    }

    protected function setUserSession(array $user): void
    {
        $data = [
            'adm_usuario_id' => $user['id'],
            'adm_username'   => $user['username'],
            'adm_nombre'     => $user['nombre'],
            'adm_apellido_paterno' => $user['apellido_paterno'],
            'adm_logged_in'  => true,
        ];

        session()->set($data);
    }

    public function logout(): void
    {
        session()->destroy();
    }

    /**
     * Obtiene y guarda en sesión los módulos permitidos del usuario.
     *
     * @param int $userId
     * @return array
     */
    public function getModulosPermitidos(int $userId): array
    {
        if (!session()->has('modulos_permitidos')) {
            $modulosPermitidos = $this->usuarioModel->getModulosPermitidos($userId);
            session()->set('modulos_permitidos', $modulosPermitidos);
        }

        return session('modulos_permitidos');
    }

    /**
     * Obtiene y guarda en sesión los permisos del módulo específico para el usuario.
     *
     * @param int $userId
     * @param int $moduloId
     * @return array
     */
    public function getPermisosModulo(int $userId, int $moduloId): array
    {
        $sessionKey = "permisos_modulo_{$moduloId}";

        if (!session()->has($sessionKey)) {
            $permisosModulo = $this->usuarioModel->getPermisosModulo($userId, $moduloId);
            session()->set($sessionKey, $permisosModulo);
        }

        return session($sessionKey);
    }
}
