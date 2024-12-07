<?php

namespace App\Controllers\Acl;

use App\Controllers\BaseController;
use App\Models\Acl\ModuloModel;
use App\Services\Acl\AuthService;
use App\Libraries\ColumnConfig;
use App\Models\Admin\DatatableModel;
use App\Models\Acl\UsuarioModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use RuntimeException;

class AclBaseController extends BaseController
{
    protected $userId;
    protected $moduloId;
    protected $moduloDetalles = [];
    protected $authService;
    protected $session;
    protected $modulos = [];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();
        $this->loadModulosPermitidos();
        // Inicia AuthService para obtener los datos de usuario y permisos
        $this->authService = new AuthService();
        $this->userId = $this->authService->getUserId();

        if ($this->userId) {
            ColumnConfig::init($this->authService);
            $this->loadUserModulesAndPermissions();
            $this->loadModuleDetails();
        }
    }

    /**
     * Carga los detalles del módulo actual usando el ID del módulo.
     */
    private function loadModuleDetails()
    {
        if ($this->moduloId) {
            $moduloModel = new ModuloModel();
            $modulo = $moduloModel->find($this->moduloId);

            if ($modulo) {
                $this->moduloDetalles = [
                    'clave' => $modulo['clave'],
                    'nombre' => $modulo['nombre'],
                    'icono' => $modulo['icono']
                ];
            } else {
                throw new RuntimeException("Detalles del módulo no encontrados para moduloId: {$this->moduloId}");
            }
        } else {
            throw new RuntimeException("moduloId no está configurado en el controlador.");
        }
    }
    /**
     * Construye los datos comunes para las vistas del módulo.
     */
    private function buildModuleViewData(array $additionalData = []): array
    {
        return array_merge($additionalData, [
            'title' => 'EDL | ' . $this->moduloDetalles['nombre'],
            'moduleName' => $this->moduloDetalles['nombre'],
            'moduleIcon' => $this->moduloDetalles['icono'],
            'moduleKey' => $this->moduloDetalles['clave'],
            'modulos' => session()->get('modulos_permitidos') ?? [],
        ]);
    }

    /**
     * Renderiza la vista del módulo sin el panel de filtros.
     */
    protected function renderModuleView(string $view, array $additionalData = []): string
    {
        $data = $this->buildModuleViewData($additionalData);
        return view($view, $data);
    }

    /**
     * Renderiza la vista del módulo con el panel de filtros.
     */
    protected function renderModuleListView(string $view, array $additionalData = []): string
    {
        $data = $this->buildModuleViewData($additionalData);
        $data['panel_filtros'] = $this->prepareFilterPanel($this->moduloDetalles['clave'], true);
        return view($view, $data);
    }

    /**
     * Configura y renderiza el panel de filtros.
     */
    protected function prepareFilterPanel(string $moduleKey, bool $collapsible = true): string
    {
        $configData = ColumnConfig::getColumnAndFilterConfig($moduleKey);
        return view('admin/partials/panel_filtros', [
            'filter_tabs' => $configData['filter_tabs'] ?? [],
            'columns' => $configData['columns'] ?? [],
            'collapsible' => $collapsible
        ]);
    }

    /**
     * Verifica si el usuario tiene el permiso especificado.
     */
    protected function checkPermission(string $permiso): bool
    {
        if ($this->authService->hasPermission($permiso)) {
            return true;
        }
        throw new RuntimeException("No tienes permiso para acceder a esta sección.");
    }

    /**
     * Genera una respuesta JSON para DataTables a partir de la configuración del módulo.
     */
    protected function generarListaJson(string $primaryKey)
    {
        $requestData = $this->request->getPost() ?: $this->request->getGet();
        $config = ColumnConfig::getConfiguration($this->moduloDetalles['clave']);
        $columns = $config['columns'] ?? [];
        $datatableModel = new DatatableModel();
        $data = $datatableModel->simple(
            $requestData,
            'vista_' . $this->moduloDetalles['clave'],
            $primaryKey,
            $columns
        );
        return $this->response->setJSON($data);
    }

    /**
     * Carga los módulos y permisos del usuario y los guarda en la sesión.
     */
    private function loadUserModulesAndPermissions()
    {
        // Guarda en sesión los módulos permitidos
        session()->set('modulos_permitidos', $this->authService->getModulosPermitidos($this->userId));
        // Guarda en sesión los permisos del módulo actual
        if ($this->moduloId) {
            session()->set("permisos_modulo_{$this->moduloId}", $this->authService->getPermisosModulo($this->userId, $this->moduloId));
        }
    }

    protected function loadModulosPermitidos()
    {
        if ($this->session->has('adm_usuario_id')) {
            $usuarioModel = new UsuarioModel();
            $this->modulos = $usuarioModel->getModulosPermitidos($this->session->get('adm_usuario_id'));
            $this->session->set('modulos_permitidos', $this->modulos);
        }
    }

    protected function render(string $view, array $data = []): string
    {
        $data['modulos'] = $this->modulos;
        return view($view, $data);
    }
}
