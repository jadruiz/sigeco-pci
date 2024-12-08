<?php

namespace App\Controllers;

use App\Models\ConvocatoriaModel;
use CodeIgniter\Controller;

class DashboardController extends BaseController
{
    protected $convocatoriaModel;

    public function __construct()
    {
        $this->convocatoriaModel = new ConvocatoriaModel();
        helper(['form', 'session']);
    }

    public function index()
    {
        // Verificar si el usuario está logueado
        if (!session()->has('wlp_isLoggedIn')) {
            return redirect()->to('/iniciar-sesion')->with('alert', 'Debe iniciar sesión.');
        }

        // Obtener convocatorias filtradas
        $filter = $this->request->getGet('estado'); // Filtro de estado
        $convocatorias = $this->convocatoriaModel->getConvocatoriasByFilter($filter);

        // Enviar datos a la vista
        return view('website/profile/dashboard', [
            'convocatorias' => $convocatorias,
            'filter' => $filter
        ]);
    }
}
