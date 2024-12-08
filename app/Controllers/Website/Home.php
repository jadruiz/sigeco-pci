<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use App\Models\CongresoModel;
use App\Models\PaqueteModel;
use App\Models\PatrocinadorModel;
use App\Models\ParticipanteModel;

class Home extends BaseController
{

    protected $congresoModel;
    protected $paqueteModel;
    protected $patrocinadorModel;
    protected $participanteModel;

    public function __construct()
    {
        // Cargar los modelos
        $this->congresoModel = new CongresoModel();
        $this->paqueteModel = new PaqueteModel();
        $this->patrocinadorModel = new PatrocinadorModel();
        $this->participanteModel = new ParticipanteModel();
    }

    public function index()
    {
        
        // Obtener los últimos 10 congresos activos
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
        // Verificar si el congreso existe y está activo
        $congreso = $this->congresoModel->obtenerCongresoPorId($congreso_id);
        if ($congreso && $congreso['activo'] == 1) {
            // Actualizar el congreso activo en la sesión
            session()->set('active_congreso_id', $congreso_id);
        }

        // Redirigir a la página de inicio
        return redirect()->to('/');
    }
}
