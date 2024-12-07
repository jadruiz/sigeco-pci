<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthUserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var IncomingRequest $request */
        if (!session()->get('logged_in')) {
            if ($request->isAJAX()) {
                return service('response')->setJSON(['status' => 'session_expired'])->setStatusCode(401);
            }
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after
    }
}
