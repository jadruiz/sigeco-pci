<?php

// Ubicación: app/Controllers/Acl/Auth.php
namespace App\Controllers\Acl;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Services\Acl\AuthService;
use App\Models\Acl\UsuarioModel;

class AuthController extends \App\Controllers\BaseController
{
    protected $authService;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->authService = new AuthService();
    }

    public function login()
    {
        if ($this->authService->isAuthenticated()) {
            return redirect()->to('/admin/dashboard');
        }
        if (strtoupper($this->request->getMethod()) === 'POST') {
            if (!$this->validate($this->loginValidationRules())) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
    
            if ($this->authService->attemptLogin($username, $password)) {
                return redirect()->to('/admin/dashboard');
            }
            return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
        }
    
        return view('acl/login');
    }    

    private function loginValidationRules(): array
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function logout()
    {
        $this->authService->logout();
        return redirect()->to('/admin/login');
    }

    public function secret($text){
        echo password_hash($text, PASSWORD_DEFAULT);
    }
}
