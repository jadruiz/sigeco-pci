<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RegistroModel;
use App\Models\CongresoModel;

class RegistroController extends BaseController
{
    protected $registroModel;
    protected $congresoModel;

    public function __construct()
    {
        // Inicializar el modelo
        $this->registroModel = new RegistroModel();
        $this->congresoModel = new CongresoModel();
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

    public function setCongreso($congresoSlug, $redirectType)
    {
        $session = session();
        $session->set('wss_congreso_slug', $congresoSlug);
        // Redireccionar según el parámetro
        if ($redirectType == 2) {
            return redirect()->to('/registro')->with('success', 'Congreso seleccionado correctamente.');
        } elseif ($redirectType == 1) {
            return redirect()->to('/iniciar-sesion')->with('success', 'Congreso seleccionado. Por favor inicia sesión.');
        } else {
            return redirect()->to('/')->with('error', 'Opción de redirección inválida.');
        }
    }

    public function paso($paso = 1)
    {
        $session = session();
        $usuario_id = $session->get('id');
        $username = $session->get('username');

        if (!$usuario_id) {
            return redirect()->to('/login')->with('alert', 'Debes iniciar sesión para continuar.');
        }

        // Obtener datos del participante
        $participante = $this->registroModel->find($usuario_id);
        $pasoActualUsuario = (int) $participante['paso_actual'];

        if ($paso > $pasoActualUsuario) {
            return redirect()->to("registro/paso/$pasoActualUsuario");
        }

        $etapas = ['iniciar_sesion', 'seleccionar_congreso', 'plan_pago'];
        $data = [
            'paso' => $paso,
            'username' => $username,
            'pasoActualUsuario' => $pasoActualUsuario,
            'etapas' => $etapas,
            'nextStepUrl' => ($paso < count($etapas)) ? site_url("registro/paso/" . ($paso + 1)) : null,
            'prevStepUrl' => ($paso > 1) ? site_url("registro/paso/" . ($paso - 1)) : null,
        ];

        switch ($paso) {
            case 1:
                $data['usuario'] = $participante;
                break;

            case 2:
                $data['congresos'] = $this->congresoModel->findAll();
                break;

            case 3:
                $data['planes'] = $this->registroModel->obtenerPlanes();
                break;

            case 4:
                $data['resumen'] = [
                    'usuario' => $participante,
                    'congreso' => $this->congresoModel->find($participante['congreso_id']),
                    'plan' => $this->registroModel->obtenerPlanPorId($participante['paquete_id']),
                ];
                break;
        }

        return view("registro/pasos/paso_$paso", $data);
    }

    /**
     * Avanzar al siguiente paso del registro
     */
    public function avanzarPaso()
    {
        $session = session();
        $usuario_id = $session->get('id');
        if (!$usuario_id) {
            return redirect()->to('/login');
        }
        $participante = $this->registroModel->find($usuario_id);
        $nuevoPaso = $participante['paso_actual'] + 1;
        // Actualizar el paso del usuario
        $this->registroModel->update($usuario_id, ['paso_actual' => $nuevoPaso]);
        return redirect()->to("/registro/paso/$nuevoPaso");
    }
}
