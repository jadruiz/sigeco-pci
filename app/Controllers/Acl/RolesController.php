<?php
// app/Controllers/Admin/RolesController.php
namespace App\Controllers\Admin;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Services\UserValidationService;
use App\Models\Admin\RolesModel;
use App\Models\Admin\ModulosModel;
use App\Models\Admin\PermisosModel;

class RolesController extends AdminBaseController
{
    protected $moduloId = 9;
    protected $rolesModel;
    protected $modulosModel;
    protected $permisosModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->rolesModel = new RolesModel();
        $this->modulosModel = new ModulosModel();
        $this->permisosModel = new PermisosModel();
    }

    public function index()
    {
        return $this->renderModuleListView('admin/' . $this->moduloDetalles['clave'] . '/index');
    }

    public function lista_json()
    {
        return $this->generarListaJson('id_usuario');
    }

    public function agregar()
    {
        if ($this->request->getMethod() === 'POST') {
            return $this->saveRole();
        }

        $data = [
            'modulosRoles' => $this->modulosModel->getModulesWithPermissions(),
            'permisosAsignados' => []
        ];
        return $this->renderModuleView('admin/' . $this->moduloDetalles['clave'] . '/form_guardar', $data);
    }

    public function editar($id)
    {
        $role = $this->rolesModel->find($id);
        if (!$role) {
            return redirect()->to('/admin/' . $this->moduloDetalles['clave'])->with('error', 'Rol no encontrado.');
        }
        if ($this->request->getMethod() === 'POST') {
            return $this->saveRole($role);
        }
        $assignedPermissions = $this->rolesModel->getAssignedPermissions($id);
        $data = [
            'modulosRoles' => $this->modulosModel->getModulesWithPermissions(), // Cambiado a 'modulosRoles'
            'role' => $role,
            'permisosAsignados' => array_column($assignedPermissions, 'id'), // Obtener solo los IDs de permisos asignados
        ];
        return $this->renderModuleView('admin/' . $this->moduloDetalles['clave'] . '/form_guardar', $data);
    }

    private function saveRole($role = null)
    {
        $data = $this->request->getPost();
        $isEdit = $role !== null;
        // Validación de datos
        if (!$this->validate(['nombre' => 'required|max_length[50]'])) {
            return redirect()->back()->withInput()->with('validationErrors', $this->validator->getErrors());
        }
        try {
            if ($isEdit) {
                $this->rolesModel->update($role['id'], $data);
                $roleId = $role['id'];
                $message = 'Rol actualizado exitosamente.';
            } else {
                $this->rolesModel->insert($data);
                $roleId = $this->rolesModel->getInsertID();
                $message = 'Rol agregado exitosamente.';
            }
            // Guardar permisos asignados
            $this->saveRolePermissions($roleId, $data['permissions'] ?? []);

            return redirect()->to('/admin/' . $this->moduloDetalles['clave'])->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'No se pudo guardar el rol. Inténtalo de nuevo.');
        }
    }

    private function saveRolePermissions($roleId, $permissions)
    {
        $this->rolesModel->removePermissions($roleId);
        foreach ($permissions as $permissionId) {
            $this->rolesModel->assignPermission($roleId, $permissionId);
        }
    }

    public function eliminar($id)
    {
        $role = $this->rolesModel->find($id);

        if (!$role) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Rol no encontrado']);
        }

        $data = ['eliminado' => 1];
        if ($this->rolesModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Rol eliminado correctamente']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar el registro']);
        }
    }
}
