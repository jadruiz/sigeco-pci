<?php
// app/Controllers/Admin/UsuariosController.php
namespace App\Controllers\Admin;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Services\UserValidationService;
use App\Models\Admin\UsuarioModel;

class UsuariosController extends AdminBaseController
{
    protected $moduloId = 5;
    protected $usuarioModel;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        // Renderiza la vista principal
        return $this->renderModuleListView('admin/' . $this->moduloDetalles['clave'] . '/index');
    }

    public function lista_json()
    {
        // Genera respuesta JSON para DataTables usando configuración y vista del módulo
        return $this->generarListaJson('id_usuario');
    }

    public function agregar()
    {
        if ($this->request->getMethod() === 'POST') {
            return $this->saveUser();
        }
        return view('admin/' . $this->moduloDetalles['clave'] . '/form_usuario', $this->getFormData());
    }

    public function editar($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to('/admin/' . $this->moduloDetalles['clave'])->with('error', 'Usuario no encontrado.');
        }
        if ($this->request->getMethod() === 'POST') {
            return $this->saveUser($usuario);
        }
        $genericModel = new \App\Models\Admin\GenericDataModel();
        $carreraDetalles = null;
        if ($usuario['carrera_id']) {
            $carreraDetalles = $genericModel->obtenerCarreraDetalles($usuario['carrera_id']);
        }
        // Preparar los datos para la vista
        $data = $this->getFormData();
        $data['usuario'] = $usuario;
        $data['carreraDetalles'] = $carreraDetalles;
        return view('admin/' . $this->moduloDetalles['clave'] . '/form_usuario', $data);
    }

    private function saveUser($usuario = null)
    {
        $data = $this->request->getPost();
        // Configurar validaciones dinámicas para edición o creación
        $isEdit = $usuario !== null;
        $validateUsername = $isEdit ? $data['username'] !== $usuario['username'] : true;
        $validateEmail = $isEdit ? $data['email'] !== $usuario['email'] : true;
        $errors = UserValidationService::validateUserData($data, false, $isEdit, $validateUsername, $validateEmail);
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('validationErrors', $errors);
        }
        // Encriptar contraseña solo si es nueva o cambiada
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        // Convertir checks a valores booleanos
        $data['es_prueba'] = $this->request->getPost('es_prueba') ? 1 : 0;
        $data['es_observador'] = $this->request->getPost('es_observador') ? 1 : 0;
        // Guardar usuario en base de datos
        try {
            if ($isEdit) {
                $this->usuarioModel->update($usuario['id'], $data);
                return redirect()->to('/admin/' . $this->moduloDetalles['clave'])->with('success', 'Usuario actualizado exitosamente.');
            } else {
                $this->usuarioModel->insertarUsuario($data);
                return redirect()->to('/admin/' . $this->moduloDetalles['clave'])->with('success', 'Usuario agregado exitosamente.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'No se pudo guardar el usuario. Inténtalo de nuevo.');
        }
    }

    // Método privado para preparar los datos adicionales para la vista
    private function getFormData()
    {
        $genericModel = new \App\Models\Admin\GenericDataModel();
        return [
            'modalidades' => ['Escolarizado'],
            'divisiones'  => $genericModel->obtenerOpciones('esc_division', 'id', 'nombre'),
            'campus'      => $genericModel->obtenerOpciones('esc_campus', 'id', 'nombre'),
        ];
    }

    // Eliminar un usuario
    public function eliminar($id)
    {
        // Verifica si el usuario existe
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Usuario no encontrado']);
        }
        $data = ['eliminado' => 1];
        if ($this->usuarioModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Usuario eliminado correctamente']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'No se pudo actualizar el registro']);
        }
    }
}
