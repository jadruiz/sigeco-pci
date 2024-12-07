<?php
// app/Controllers/Admin/Dashboard.php
namespace App\Controllers\Admin;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Controllers\Acl\AclBaseController;

class DashboardController extends AclBaseController
{
    protected $moduloId = 1;
    protected $dashboardModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    public function index()
    {
        return $this->renderModuleView('admin/dashboard/index');
    }
}
