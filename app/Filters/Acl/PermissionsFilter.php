<?php
// app/Filters/AdminPermissionsFilter.php
namespace App\Filters\Acl;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Services\Acl\AuthService;
use App\Models\Acl\UsuarioModel;

class PermissionsFilter implements FilterInterface
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        // Verifica si el usuario tiene permiso para la acción específica
        if ($arguments && isset($arguments[0])) {
            $permiso = $arguments[0];
            if (!$this->authService->hasPermission($permiso)) {
                // Redirige al usuario si no tiene permiso
                return redirect()->to('/admin/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario implementar lógica aquí
    }
}
