<?php

namespace App\Controllers\Admin;

use App\Models\Admin\CongresoModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\Acl\AclBaseController;
//use App\Services\Acl\AuthService;

class CongresosController extends AclBaseController
{
    protected $congresoModel;
    protected $moduloId = 2; // congresos
    protected $examenModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->congresoModel = new CongresoModel();
    }

    public function index()
    {
        return $this->renderModuleListView('admin/' . $this->moduloDetalles['clave'] . '/index');
    }

    public function lista_json()
    {
        return $this->generarListaJson('id_usuario');
    }


    public function crear()
    {
        return view('admin/congresos/crear');
    }

    public function guardar()
    {
        if (!$this->validate([
            'nombre' => 'required|max_length[255]',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|valid_date',
            'fecha_fin' => 'required|valid_date',
            'estado' => 'required|in_list[convocatoria,registro,activo,finalizado,edición]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->congresoModel->save($this->request->getPost());
        return redirect()->to('/admin/congresos')->with('success', 'Congreso creado correctamente.');
    }

    public function editar($id)
    {
        $congreso = $this->congresoModel->find($id);
        if (!$congreso) {
            return redirect()->to('/admin/congresos')->with('error', 'Congreso no encontrado.');
        }
        return view('admin/congresos/editar', ['congreso' => $congreso]);
    }

    public function actualizar($id)
    {
        if (!$this->validate([
            'nombre' => 'required|max_length[255]',
            'descripcion' => 'required',
            'fecha_inicio' => 'required|valid_date',
            'fecha_fin' => 'required|valid_date',
            'estado' => 'required|in_list[convocatoria,registro,activo,finalizado,edición]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->congresoModel->update($id, $this->request->getPost());
        return redirect()->to('/admin/congresos')->with('success', 'Congreso actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->congresoModel->delete($id);
        return redirect()->to('/admin/congresos')->with('success', 'Congreso eliminado correctamente.');
    }
}
