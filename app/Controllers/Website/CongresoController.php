<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\CongresoModel;
use App\Models\ActividadProgramaModel;
use App\Models\PatrocinadorModel;
use App\Models\ConvocatoriaModel;
use App\Models\RegistroPaqueteModel;
use App\Models\ParticipantesModel;

class CongresoController extends BaseController
{
    protected $congresoModel;
    protected $actividadModel;
    protected $patrocinadorModel;
    protected $convocatoriaModel;
    protected $registroPaqueteModel;
    protected $participanteModel;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->congresoModel = new CongresoModel();
        $this->actividadModel = new ActividadProgramaModel();
        $this->patrocinadorModel = new PatrocinadorModel();
        $this->convocatoriaModel = new ConvocatoriaModel();
        $this->registroPaqueteModel = new RegistroPaqueteModel();
        $this->participanteModel = new ParticipantesModel();
    }

    // Método general para obtener congreso
    private function getCongreso($slug)
    {
        $congreso = $this->congresoModel->where('slug', $slug)->first();
        if (!$congreso) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Congreso no encontrado.");
        }
        return $congreso;
    }

    public function lista()
    {
        $congresos = $this->congresoModel->obtenerCongresosOrdenados();
        return view('website/congresos/lista', [
            'title' => 'Lista de Congresos',
            'congresos' => $congresos
        ]);
    }

    public function detalle($slug)
    {
        helper('text');
        // Obtener congreso
        $congreso = $this->getCongreso($slug);

        if (!$congreso) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Congreso no encontrado');
        }

        // Obtener actividades agrupadas por fecha
        $actividadesPorFecha = $this->actividadModel->obtenerActividadesAgrupadasPorFecha($congreso['id']);

        // Obtener patrocinadores asociados al congreso
        $congresoPatrocinadorModel = new \App\Models\CongresoPatrocinadorModel();
        $patrocinadores = $congresoPatrocinadorModel->obtenerPatrocinadoresPorCongreso($congreso['id']);

        // Obtener paquetes con beneficios
        $paqueteModel = new \App\Models\PaqueteModel();
        $paquetes = $paqueteModel->obtenerPaquetesConBeneficios($congreso['id']);
        // Obtener noticias relacionadas
        $noticiaModel = new \App\Models\NoticiaModel();
        $noticias = $noticiaModel->obtenerNoticiasPorCongreso($congreso['id']);
        // Pasar datos a la vista
        return view('website/congresos/detalle', [
            'congreso' => $congreso,
            'actividadesPorFecha' => $actividadesPorFecha,
            'patrocinadores' => $patrocinadores,
            'paquetes' => $paquetes,
            'noticias' => $noticias
        ]);
    }

    public function convocatoria($slug)
    {
        $data['congreso'] = $this->getCongreso($slug);
        $data['convocatoria'] = $this->convocatoriaModel->where('congreso_id', $data['congreso']['id'])->first();

        return view('website/congresos/convocatoria', $data);
    }

    public function registro($slug)
    {
        $userId = session()->get('wlp_id');
        $progresoModel = new \App\Models\RegistroProgresoModel();
        $congresoModel = new \App\Models\CongresoModel();

        // Validar si el usuario está autenticado
        if (!$userId) {
            return redirect()->to("congreso/$slug/registro/paso/1")->with('alert', 'Debes iniciar sesión para continuar.');
        }
        // Obtener congreso por slug
        $congreso = $congresoModel->where('slug', $slug)->first();
        if (!$congreso) {
            return redirect()->to('/')->with('error', 'El congreso no existe.');
        }
        // Guardar congreso_id y slug en la sesión si aún no están
        session()->set('wss_congreso_id', session()->get('wss_congreso_id') ?? $congreso['id']);
        session()->set('wss_congreso_slug', session()->get('wss_congreso_slug') ?? $slug);
        $congresoId = $congreso['id'];
        // Buscar progreso registrado del participante
        $progresoExistente = $progresoModel
            ->where('participante_id', $userId)
            ->where('congreso_id', $congresoId)
            ->first();
        if ($progresoExistente) {
            // Actualizar el paso si es menor a 2
            if ($progresoExistente['paso_actual'] < 2) {
                $progresoModel->update($progresoExistente['id'], ['paso_actual' => 2]);
            }
            // Redirigir al paso actual del usuario
            return redirect()->to("congreso/$slug/registro/paso/" . $progresoExistente['paso_actual']);
        }
        // Si no existe progreso, crear uno nuevo
        $progresoModel->insert([
            'participante_id' => $userId,
            'congreso_id' => $congresoId,
            'paso_actual' => 2
        ]);
        // Redirigir al paso 2 del registro
        return redirect()->to("congreso/$slug/registro/paso/2");
    }

    public function programa($slug)
    {
        $congreso = $this->getCongreso($slug);

        // Obtener las actividades
        $actividades = $this->actividadModel->obtenerActividadesPorCongreso($congreso['id']);

        if (empty($actividades)) {
            session()->setFlashdata('warning', 'No hay actividades programadas aún.');
        }

        // Agrupar actividades por fecha
        $actividadesPorFecha = [];
        foreach ($actividades as $actividad) {
            $fecha = $actividad['fecha_actividad'];
            $actividadesPorFecha[$fecha][] = $actividad;
        }

        return view('website/congresos/detalle', [
            'congreso' => $congreso,
            'actividadesPorFecha' => $actividadesPorFecha
        ]);
    }


    public function finalizado($slug)
    {
        $data['congreso'] = $this->getCongreso($slug);
        $data['actividades'] = $this->actividadModel->where('congreso_id', $data['congreso']['id'])->findAll();
        $data['resultados'] = [
            'total_actividades' => count($data['actividades']),
            'total_asistentes' => $this->participanteModel->countAllResults()
        ];

        return view('website/congresos/finalizado', $data);
    }

    public function registroPaso($slug, $paso = 1)
    {
        $session = session();
        $progresoModel = new \App\Models\RegistroProgresoModel();
        $congresoModel = new \App\Models\CongresoModel();

        // Verificar si el usuario está autenticado
        $userId = $session->get('wlp_id');
        if (!$userId) {
            //return redirect()->to("congreso/$slug/registro/paso/1")->with('alert', 'Debes iniciar sesión o registrarte para continuar.');
        }

        // Obtener detalles del congreso
        $congreso = $congresoModel->where('slug', $slug)->first();
        if (!$congreso) {
            return redirect()->to('/')->with('error', 'Congreso no encontrado.');
        }

        // Obtener el progreso actual del usuario en este congreso
        $progreso = $progresoModel
            ->where('participante_id', $userId)
            ->where('congreso_id', $congreso['id'])
            ->first();

        $pasoActualUsuario = $progreso ? (int) $progreso['paso_actual'] : 1;

        // Redirigir si el paso solicitado es mayor al paso actual
        if ($paso > $pasoActualUsuario) {
            return redirect()->to("congreso/$slug/registro/paso/$pasoActualUsuario");
        }

        // Definir las etapas del proceso
        $etapas = [
            'identificate' => 'Inicia sesión con tu cuenta o regístrate si eres nuevo.',
            'seleccion_plan' => 'Elige el plan que mejor se adapte a tu participación.',
            'pago' => 'Realiza el pago correspondiente para confirmar tu registro.',
            'finalizar' => 'Revisa los detalles y completa tu registro exitosamente.',
        ];

        // Preparar datos para la vista
        $data = [
            'slug' => $slug,
            'congreso' => $congreso,
            'paso' => $paso,
            'etapas' => $etapas,
            'pasoActualUsuario' => $pasoActualUsuario,
            'nextStepUrl' => ($paso < count($etapas))
                ? site_url("congreso/$slug/registro/paso/" . ($paso + 1)) : null,
            'prevStepUrl' => ($paso > 1)
                ? site_url("congreso/$slug/registro/paso/" . ($paso - 1)) : null,
        ];

        // Manejar lógica específica de cada paso
        switch ($paso) {
            case 1:
                // Datos para el login o registro
                $data['formUrl'] = site_url("registro/set_congreso/{$slug}/1");
                break;

            case 2:
                // Mostrar detalles del congreso
                $data['congresoSeleccionado'] = $congreso;
                $paqueteModel = new \App\Models\PaqueteModel();
                $data['paquetes'] = $paqueteModel->obtenerPaquetesConBeneficios($congreso['id']);
                break;

            case 3:
                // Obtener la inscripción del usuario
                $inscripcionModel = new \App\Models\InscripcionCongresoModel();
                $inscripcion = $inscripcionModel
                    ->where('congreso_id', $congreso['id'])
                    ->where('participante_id', $userId)
                    ->first();

                if (!$inscripcion) {
                    return redirect()->to("congreso/$slug/registro/paso/2")
                        ->with('error', 'Debes seleccionar un plan antes de continuar.');
                }

                // Obtener detalles del plan
                $paqueteModel = new \App\Models\PaqueteModel();
                $plan = $paqueteModel->find($inscripcion['paquete_id']);

                if (!$plan) {
                    return redirect()->to("congreso/$slug/registro/paso/2")
                        ->with('error', 'El plan seleccionado no existe.');
                }

                // Pasar datos a la vista
                $data['plan'] = $plan;
                $data['inscripcion'] = $inscripcion;
                break;

            case 4:
                // Obtener resumen del registro
                $data['resumen'] = [
                    'usuario' => $session->get(),
                    'congreso' => $congreso,
                    'planSeleccionado' => $progreso['paquete_id'] ?? null
                ];
                break;

            default:
                return redirect()->to("congreso/$slug/registro/paso/1")
                    ->with('error', 'Paso no válido.');
        }
        // Renderizar la vista correspondiente
        return view('website/congresos/registro/index', $data);
    }

    /**
     * Finaliza el registro.
     */
    public function finalizarRegistro($slug)
    {
        $session = session();
        // Lógica de finalización del registro
        $session->set("registro_paso_$slug", 4);

        return redirect()->to("congreso/$slug/registro/completado");
    }

    /**
     * Vista de registro completado.
     */
    public function registroCompletado($slug)
    {
        return view('website/registro/completado', ['slug' => $slug]);
    }
}
