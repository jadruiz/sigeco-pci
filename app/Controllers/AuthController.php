<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuthModel;

class AuthController extends BaseController
{
    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
        helper(['form', 'url', 'session']);
    }

    /**
     * Mostrar formulario de login
     */
    public function login()
    {
        return view('auth/login', ['title' => 'Iniciar Sesión']);
    }

    /**
     * Procesar login
     */
    public function doLogin()
    {
        $data = $this->request->getPost();

        // Validación de formulario
        if (!$this->validate([
            'username' => 'required',
            'password' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('alert', 'Usuario/Correo y contraseña son obligatorios.');
        }

        // Buscar usuario por username o email
        $user = $this->authModel->getUserByUsernameOrEmail($data['username']);

        if (!$user) {
            return redirect()->back()->with('alert', 'Usuario/Correo no encontrado.');
        }

        // Comparar contraseña ingresada con el hash almacenado en la base de datos
        if (!password_verify($data['password'], $user['password'])) {
            return redirect()->back()->with('alert', 'Contraseña incorrecta.');
        }

        // Configurar sesión
        session()->set([
            'wlp_id' => $user['id'],
            'wlp_username' => $user['username'],
            'wlp_email' => $user['email'],
            'wlp_isLoggedIn' => true
        ]);

        return redirect()->to('/dashboard')->with('success', '¡Bienvenido, ' . esc($user['nombre']) . '!');
    }
    

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/iniciar-sesion')->with('success', 'Sesión cerrada correctamente.');
    }

    /**
     * Mostrar formulario de registro
     */
    public function register()
    {
        return view('website/auth/register', ['title' => 'Registro de Usuario']);
    }

    /**
     * Procesar registro
     */
    public function doRegister()
    {
        $data = $this->request->getPost();

        // Validación del formulario
        if (!$this->validate([
            'username' => 'required|min_length[5]|is_unique[sgc_participantes.username]',
            'email'    => 'required|valid_email|is_unique[sgc_participantes.email]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'telefono' => 'required|regex_match[/^[0-9]{10}$/]',
            'nombre'   => 'required',
            'apellido_paterno' => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar datos
        unset($data['confirm_password']);
        $data['password'] = password_hash(trim($data['password']), PASSWORD_BCRYPT);
        // Crear usuario
        if (!$this->authModel->createUser($data)) {
            return redirect()->back()->with('alert', 'Error al registrar el usuario.');
        }

        return redirect()->to('/iniciar-sesion')->with('success', 'Registro exitoso. ¡Inicia sesión!');
    }
}
