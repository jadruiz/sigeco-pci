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
        $data['congreso'] = $this->getCongreso($slug);
        $data['paquetes'] = $this->registroPaqueteModel->where('congreso_id', $data['congreso']['id'])->findAll();

        return view('website/congresos/registro', $data);
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
}
