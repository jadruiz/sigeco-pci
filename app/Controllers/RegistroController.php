<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegistroModel;

class RegistroController extends BaseController
{
    protected $registroModel;

    public function __construct()
    {
        // Inicializar el modelo
        $this->registroModel = new RegistroModel();
    }

    /**
     * Muestra el formulario de registro
     */
    public function index()
    {
        return view('website/registro/form', ['title' => 'Registro de Participantes']);
    }

    /**
     * Almacena un nuevo registro de participante
     */
    public function store()
    {
        $data = $this->request->getPost();

        // Validación de confirmación de contraseña
        if ($data['password'] !== $data['confirm_password']) {
            return redirect()->back()->withInput()
                ->with('errors', ['Las contraseñas no coinciden.']);
        }

        // Eliminar confirm_password para evitar insertar datos innecesarios
        unset($data['confirm_password']);

        // Validar con las reglas del modelo
        if (!$this->validate($this->registroModel->validationRules, $this->registroModel->validationMessages)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Preparar datos
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['activo'] = 1;
        $data['eliminado'] = 0;

        // Insertar datos
        if (!$this->registroModel->createParticipant($data)) {
            return redirect()->back()->withInput()
                ->with('alert', 'Ocurrió un error al registrar el usuario. Inténtalo nuevamente.');
        }

        // Registro exitoso
        return redirect()->to('/registro')->with('success', 'Registro exitoso 🎉. ¡Inicia sesión para continuar!');
    }
}
