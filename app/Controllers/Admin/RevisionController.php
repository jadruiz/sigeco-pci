<?php

namespace App\Controllers\Admin;
use App\Controllers\Acl\AclBaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Admin\RevisionModel;
use App\Models\Admin\CongresoModel;
use App\Models\Admin\HistorialModel;
use App\Models\ArticuloModel;

class RevisionController extends AclBaseController
{
    protected $moduloId = 3;
    protected $examenModel;
    protected $revisionModel;
    protected $historialModel;
    protected $articuloModel;
    protected $congresoModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->congresoModel = new CongresoModel();
        $this->revisionModel = new RevisionModel();
        $this->historialModel = new HistorialModel();
        $this->articuloModel = new ArticuloModel();
    }

    public function guardar()
    {
        $articulo_id = $this->request->getPost('articulo_id');
        $comentarios = $this->request->getPost('comentarios');
        $calificacion = $this->request->getPost('calificacion');
        $estado_revision = $this->request->getPost('estado_revision');
        $revisor_id = session()->get('adm_usuario_id');
        $data = [
            'articulo_id' => $articulo_id,
            'revisor_id' => $revisor_id,
            'comentarios' => $comentarios,
            'calificacion' => $calificacion,
            'estado_evaluacion' => $estado_revision,
            'fecha_evaluacion' => date('Y-m-d H:i:s')
        ];
        $this->revisionModel->save($data);
        $historialData = [
            'articulo_id' => $articulo_id,
            'estado_anterior' => $this->articuloModel->find($articulo_id)['estado'],
            'estado_nuevo' => $estado_revision,
            'usuario_id' => $revisor_id,
            'fecha_cambio' => date('Y-m-d H:i:s')
        ];
        $this->historialModel->save($historialData);
        $this->articuloModel->update($articulo_id, ['estado' => $estado_revision]);
        return redirect()->to('admin/articulos')->with('success', 'Revisión guardada exitosamente.');
    }

    public function formulario($articulo_id)
    {
        $articulo = $this->articuloModel->find($articulo_id);
        $revisores = $this->revisionModel
            ->where('articulo_id', $articulo_id)
            ->findAll();
        if (!$articulo) {
            return redirect()->to('articulos')->with('error', 'Artículo no encontrado.');
        }
        $data = [
            'articulo' => $articulo,
            'revisores' => $revisores,
            'titulo_pagina' => 'Revisión de Artículo'
        ];
        return $this->renderModuleListView('admin/articulos/revision_articulo_detalle', $data);
    }
}
