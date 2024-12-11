<?php

namespace App\Controllers\Admin;

use App\Models\Admin\CongresoModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\Acl\AclBaseController;

class ArticulosController extends AclBaseController
{
    protected $congresoModel;
    protected $moduloId = 3;
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
}
