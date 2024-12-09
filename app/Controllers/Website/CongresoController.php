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
        // Obtener ID del usuario de la sesión
        $userId = session()->get('wlp_id');
        $progresoModel = new \App\Models\RegistroProgresoModel(); // Asegúrate de tener este modelo creado
        if ($userId) {
            // Actualiza la variable de sesión 'wss_congreso_slug' si no existe
            if (!session()->get('wss_congreso_slug')) {
                session()->set('wss_congreso_slug', $slug);
            }

            // Verificar si ya existe un progreso registrado
            $progresoExistente = $progresoModel->where('participante_id', $userId)->first();
            if ($progresoExistente) {
                // Actualizar paso_actual a 2 si ya existe el registro
                $progresoModel->update($progresoExistente['id'], ['paso_actual' => 2]);
            } else {
                // Crear un nuevo registro en la tabla de progreso
                $progresoModel->insert([
                    'participante_id' => $userId,
                    'paso_actual' => 2
                ]);
            }
            // Redirigir al paso 2 del registro
            return redirect()->to("congreso/$slug/registro/paso/2");
        }
        // Si no está autenticado, redirigir al paso 1 (crear cuenta/iniciar sesión)
        return redirect()->to("congreso/$slug/registro/paso/1");
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
        helper('form');

        // Obtener progreso actual
        $pasoActualUsuario = $session->get("registro_paso_$slug") ?? 1;

        if ($paso > $pasoActualUsuario) {
            return redirect()->to("congreso/$slug/registro/paso/$pasoActualUsuario");
        }

        // Obtener los detalles del congreso
        $congresoModel = new \App\Models\CongresoModel();
        $congreso = $congresoModel->where('slug', $slug)->first();

        if (!$congreso) {
            // Si el congreso no existe, redirigir a una página de error
            return redirect()->to('/')->with('error', 'Congreso no encontrado.');
        }

        // Etapas del proceso
        $etapas = ['crear cuenta o iniciar sesión', 'seleccionar congreso', 'seleccionar plan de pago', 'finalizar'];

        // Datos para la vista
        $data = [
            'slug' => $slug,
            'congreso' => $congreso,
            'paso' => $paso,
            'etapas' => $etapas,
            'pasoActualUsuario' => $pasoActualUsuario,
            'nextStepUrl' => ($paso < count($etapas)) ? site_url("congreso/$slug/registro/paso/" . ($paso + 1)) : null,
            'prevStepUrl' => ($paso > 1) ? site_url("congreso/$slug/registro/paso/" . ($paso - 1)) : null,
        ];

        // Manejo de datos según el paso
        switch ($paso) {
            case 1:
                // Login o registro
                break;
            case 2:
                // $data['congresos'] = $this->registroModel->obtenerCongresosActivos();
                break;
            case 3:
                // $data['planes'] = $this->registroModel->obtenerPlanesPorCongreso($slug);
                break;
            case 4:
                /*$data['resumen'] = [
                    'usuario' => $session->get(),
                    'congreso' => $this->registroModel->obtenerCongresoPorSlug($slug),
                ];*/
                break;
        }

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
