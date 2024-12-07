<?php

namespace App\Filters\Acl;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var IncomingRequest $request */
        if (!session()->get('adm_usuario_id')) {
            if ($request->isAJAX()) {
                return service('response')->setJSON(['status' => 'session_expired'])->setStatusCode(401);
            }
            return redirect()->to('/admin/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
