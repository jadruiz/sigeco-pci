<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Services\AuthService;

class AuthFilter implements FilterInterface
{
    protected $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var IncomingRequest $request */
        if (!$this->authService->isAuthenticated()) {
            if ($request->isAJAX()) {
                return service('response')->setJSON(['status' => 'session_expired'])->setStatusCode(401);
            }
            return redirect()->to('/admin/login');
        }

        // Si se pasa un permiso específico, verifica
        if ($arguments && !$this->authService->hasPermission($arguments[0])) {
            return redirect()->to('/admin/dashboard')->with('error', 'No tienes permisos para esta acción.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere acción adicional después
    }
}
