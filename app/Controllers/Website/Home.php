<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\CongresoModel;
use App\Models\PaqueteModel;
use App\Models\PatrocinadorModel;
use App\Models\ParticipantesModel;
use App\Models\InscripcionCongresoModel;
use App\Models\ArticuloModel;

class Home extends BaseController
{

    protected $congresoModel;
    protected $paqueteModel;
    protected $patrocinadorModel;
    protected $participantesModel;
    protected $inscripcionModel;
    protected $articuloModel;

    public function __construct()
    {
        $this->congresoModel = new CongresoModel();
        $this->paqueteModel = new PaqueteModel();
        $this->articuloModel = new ArticuloModel();
        $this->patrocinadorModel = new PatrocinadorModel();
        $this->participantesModel = new ParticipantesModel();
        $this->inscripcionModel = new InscripcionCongresoModel();
    }

    public function index()
    {
        $data['congresos'] = $this->congresoModel->getUltimosCongresos(10);
        return view('website/home', $data);
    }

    /**
     * Cambiar el congreso activo
     *
     * @param int $congreso_id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function cambiarCongreso($congreso_id)
    {
        $congreso = $this->congresoModel->obtenerCongresoPorId($congreso_id);
        if ($congreso && $congreso['activo'] == 1) {
            session()->set('active_congreso_id', $congreso_id);
        }
        return redirect()->to('/');
    }

    public function ayuda()
    {
        echo 'Sección en mantenimiento...';
    }

    public function misCongresos()
    {
        $userId = session()->get('wlp_id');

        // Obtener inscripciones del usuario
        $inscripciones = $this->inscripcionModel->obtenerInscripcionesPorUsuario($userId);

        // Obtener artículos subidos por el usuario
        $articulos = $this->articuloModel
            ->where('participante_id', $userId)
            ->findAll();

        return view('website/panel/mis_congresos', [
            'inscripciones' => $inscripciones,
            'articulos' => $articulos,
        ]);
    }
}
