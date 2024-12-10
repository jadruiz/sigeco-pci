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

    public function seleccionarPlan($slug, $paqueteId)
    {
        $userId = session()->get('wlp_id');
        // Verificar datos necesarios
        if (!$userId || !$paqueteId) {
            return redirect()->back()->with('error', 'Datos inválidos o incompletos.');
        }
        // Obtener datos del congreso
        $congreso = $this->congresoModel->where('slug', $slug)->first();
        if (!$congreso) {
            return redirect()->back()->with('error', 'El congreso no existe.');
        }
        // Instancias de modelos
        $inscripcionModel = new \App\Models\InscripcionCongresoModel();
        $progresoModel = new \App\Models\RegistroProgresoModel();

        // Actualizar o insertar inscripción en `sgc_inscripciones_congreso`
        $inscripcion = $inscripcionModel
            ->where('participante_id', $userId)
            ->where('congreso_id', $congreso['id'])
            ->first();

        if ($inscripcion) {
            // Actualizar si existe
            $inscripcionModel->update($inscripcion['id'], [
                'paquete_id' => $paqueteId,
                'estado' => 'en_proceso',
                'fecha_inscripcion' => date('Y-m-d H:i:s')
            ]);
            $mensaje = 'Plan actualizado correctamente.';
        } else {
            // Insertar nueva inscripción
            $inscripcionModel->insert([
                'congreso_id' => $congreso['id'],
                'participante_id' => $userId,
                'paquete_id' => $paqueteId,
                'estado' => 'en_proceso'
            ]);
            $mensaje = 'Plan seleccionado correctamente.';
        }

        // Actualizar o insertar progreso en `sgc_registro_progreso`
        $progreso = $progresoModel
            ->where('participante_id', $userId)
            ->where('congreso_id', $congreso['id'])
            ->first();

        if ($progreso) {
            // Actualizar el paso_actual y paquete_id
            $progresoModel->update($progreso['id'], [
                'paso_actual' => 3,
                'paquete_id' => $paqueteId,
                'fecha_actualizacion' => date('Y-m-d H:i:s')
            ]);
        } else {
            // Insertar nuevo registro de progreso
            $progresoModel->insert([
                'participante_id' => $userId,
                'congreso_id' => $congreso['id'],
                'paquete_id' => $paqueteId,
                'paso_actual' => 3,
                'estado' => 'en_proceso'
            ]);
        }
        // Redirigir al paso 3 con mensaje
        return redirect()->to("congreso/$slug/registro/paso/3")->with('success', $mensaje);
    }
}
