<?php

namespace App\Controllers;

use App\Models\ProcesoModel;
use App\Models\ExamenModel;

class Home extends BaseController
{
    protected $procesoModel;
    protected $examenModel;

    public function __construct()
    {
        $this->procesoModel = new ProcesoModel();
        $this->examenModel = new ExamenModel();
    }

    // Método para mostrar la página principal del proceso
    public function index()
    {
        $session = session();
        $proceso_id = (int)$session->get('proceso_id');
        $usuario_id = $session->get('id');

        if ($proceso_id === 0) {
            return redirect()->to('/');
        }

        $proceso = $this->procesoModel->obtenerDetallesProceso($proceso_id);
        if (!$proceso) {
            return redirect()->to('/')->with('error', 'Proceso no encontrado o inactivo.');
        }

        $procesoDetalle = $this->procesoModel->obtenerOIniciarProcesoDetalle($proceso_id, $usuario_id);
        $step = $procesoDetalle['step'];

        $data = [
            'proceso' => $proceso,
            'proceso_id' => $proceso_id,
            'step' => $step
        ];

        switch ($step) {
            case 3:
                // Obtener los exámenes disponibles con su estado y resultados
                $examenes = $this->procesoModel->obtenerExamenesConEstado($proceso_id, $usuario_id);
                foreach ($examenes as &$examen) {
                    $resultado = $this->examenModel->obtenerResultadoExamenUsuario($examen['examen_id'], $usuario_id);
                    $examen['hasResult'] = !empty($resultado);
                }
                $data['examenes'] = $examenes;
                break;

            case 4:
                $data['resultados'] = $this->procesoModel->obtenerResultadosPorProceso($proceso_id, $usuario_id);
                break;

            default:
                return redirect()->to('/')->with('error', 'Paso inválido.');
        }

        return view('proceso/index', $data);
    }
}
