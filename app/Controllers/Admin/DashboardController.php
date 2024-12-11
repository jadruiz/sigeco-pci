<?php

namespace App\Controllers\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\Acl\AclBaseController;
use App\Models\Acl\UsuarioModel;
use App\Models\Acl\LoginAttemptsModel;
use App\Models\CongresoModel;
use App\Models\ArticuloModel;
use App\Models\Acl\RolesModel;

class DashboardController extends AclBaseController
{
    protected $moduloId = 1;
    protected $usuarioModel;
    protected $loginAttemptsModel;
    protected $congresoModel;
    protected $articuloModel;
    protected $rolModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->usuarioModel = new UsuarioModel();
        $this->loginAttemptsModel = new LoginAttemptsModel();
        $this->congresoModel = new CongresoModel();
        $this->articuloModel = new ArticuloModel();
        $this->rolModel = new RolesModel();
    }

    public function index()
    {
        // Datos de métricas y estadísticas
        $articulosPorEstado = $this->articuloModel
            ->select('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->findAll();

        $rolesUsuarios = $this->rolModel
            ->select('nombre, COUNT(acl_usuarios_roles.usuario_id) as total')
            ->join('acl_usuarios_roles', 'acl_roles.id = acl_usuarios_roles.rol_id')
            ->groupBy('nombre')
            ->findAll();

        $loginAttempts = $this->loginAttemptsModel
            ->select("DATE_FORMAT(attempted_at, '%Y-%m-%d') as fecha, 
                     SUM(CASE WHEN success = 1 THEN 1 ELSE 0 END) as success, 
                     SUM(CASE WHEN success = 0 THEN 1 ELSE 0 END) as failed")
            ->groupBy('fecha')
            ->findAll();

        // Transformación para Chart.js
        $dates = array_column($loginAttempts, 'fecha');
        $success = array_column($loginAttempts, 'success');
        $failed = array_column($loginAttempts, 'failed');

        $data = [
            'totalUsuarios' => $this->usuarioModel->countAllResults(),
            'intentosFallidos' => $this->loginAttemptsModel->where('success', 0)->countAllResults(),
            'congresosActivos' => $this->congresoModel->where('estado', 'activo')->countAllResults(),
            'totalArticulos' => $this->articuloModel->countAllResults(),
            'articulosPorEstado' => $articulosPorEstado,
            'rolesUsuarios' => $rolesUsuarios,
            'loginAttempts' => [
                'dates' => $dates,
                'success' => $success,
                'failed' => $failed,
            ],
        ];
        return $this->renderModuleView('admin/dashboard/index', $data);
    }
}
