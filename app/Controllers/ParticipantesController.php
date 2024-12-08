<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\ProcesoModel;

class ParticipantesController extends BaseController
{

    protected $procesoModel;

    public function __construct()
    {
       // $this->procesoModel = new ProcesoModel();
    }

    public function index()
    {
        /*if (session()->get('logged_in')) {
            return redirect()->to('/proceso/paso/1');
        }
        return view('auth/login');*/
    }
/*
    public function autenticar()
    {
        $session = session();
        $proceso_id = (int)$session->get('proceso_id');

        $model = new UsuarioModel();
        $username = $this->request->getPost('username');

        // Verifica si la matrícula existe en la base de datos
        $usuario = $model->where('username', $username)->first();
        if ($usuario) {
            $session->set([
                'id'        => $usuario['id'],
                'username'  => $usuario['username'],
                'carrera_id'  => $usuario['carrera_id'],
                'es_prueba'  => (bool)$usuario['es_prueba'],
                'es_observador'  => (bool)$usuario['es_observador'],
                'logged_in' => true,
            ]);
            // Redirigir al paso actual si el usuario intenta acceder a un paso mayor al permitido
            $procesoDetalle = $this->procesoModel->obtenerOIniciarProcesoDetalle($proceso_id, $usuario['id']);
            $pasoActualUsuario = (int) $procesoDetalle['step'];
            if ($pasoActualUsuario > 0) {
                return redirect()->to("proceso/paso/$pasoActualUsuario");
            }
            return redirect()->to('/proceso/paso/1');
        } else {
            $session->setFlashdata('error', 'Matrícula incorrecta');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        // Destruye la sesión del usuario y redirige a la página de login
        session()->destroy();
        return redirect()->to('/');
    }

    public function validarUsuario()
{
    if ($this->request->isAJAX()) {
        $username = $this->request->getJSON()->username;

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('username', $username)->first();

        if ($usuario) {
            $procesoModel = new ProcesoModel();
            $detallesUsuario = $procesoModel->obtenerDetallesUsuarioPorUsername($username);

            return $this->response->setJSON([
                'success' => true,
                'usuario' => $detallesUsuario
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'error' => 'No se encontraron datos para la clave proporcionada.'
            ]);
        }
    }

    return $this->response->setStatusCode(403)->setJSON(['error' => 'Método no permitido.']);
}*/
 
}
