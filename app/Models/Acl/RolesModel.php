<?php

namespace App\Models\Acl;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = 'acl_roles';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'activo',
        'eliminado',
        'created_at',
        'updated_at'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $defaultValues = [
        'activo' => 1,
        'eliminado' => 0,
    ];

    protected $validationRules = [
        'nombre' => 'required|is_unique[acl_roles.nombre]|max_length[50]',
        'descripcion' => 'permit_empty|string',
        'activo' => 'in_list[0,1]',
        'eliminado' => 'in_list[0,1]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre del rol es obligatorio.',
            'is_unique' => 'El nombre del rol ya existe en el sistema.',
            'max_length' => 'El nombre del rol no debe superar los 50 caracteres.',
        ],
        'activo' => [
            'in_list' => 'El valor de activo debe ser 0 o 1.',
        ],
        'eliminado' => [
            'in_list' => 'El valor de eliminado debe ser 0 o 1.',
        ],
    ];

    protected $useSoftDeletes = false;

    /**
     * Obtener roles activos
     */
    public function getActiveRoles()
    {
        return $this->where('activo', 1)->where('eliminado', 0)->findAll();
    }

    /**
     * Inactivar un rol por ID
     */
    public function deactivateRole($id)
    {
        return $this->update($id, ['activo' => 0]);
    }

    /**
     * Eliminar un rol de forma lógica (soft delete)
     */
    public function softDeleteRole($id)
    {
        return $this->update($id, ['eliminado' => 1]);
    }

    /**
     * Obtener permisos asignados a un rol
     */
    public function getAssignedPermissions($roleId)
    {
        return $this->db->table('acl_roles_permisos')
            ->select('acl_permisos.id, acl_permisos.nombre, acl_permisos.descripcion')
            ->join('acl_permisos', 'acl_roles_permisos.permiso_id = acl_permisos.id')
            ->where('acl_roles_permisos.rol_id', $roleId)
            ->get()
            ->getResultArray();
    }

    /**
     * Asignar un permiso a un rol
     */
    public function assignPermission($roleId, $permissionId)
    {
        return $this->db->table('acl_roles_permisos')->insert([
            'rol_id' => $roleId,
            'permiso_id' => $permissionId
        ]);
    }

    /**
     * Remover todos los permisos de un rol
     */
    public function removePermissions($roleId)
    {
        return $this->db->table('acl_roles_permisos')
            ->where('rol_id', $roleId)
            ->delete();
    }

    /**
     * Obtener módulos y permisos disponibles para asignación
     */
    public function getModulesWithPermissions()
    {
        $modules = $this->db->table('acl_modulos')
            ->select('acl_modulos.id, acl_modulos.nombre, acl_modulos.descripcion, acl_permisos.id AS permiso_id, acl_permisos.nombre AS permiso_nombre')
            ->join('acl_permisos_modulos', 'acl_permisos_modulos.modulo_id = acl_modulos.id', 'left')
            ->join('acl_permisos', 'acl_permisos_modulos.permiso_id = acl_permisos.id', 'left')
            ->where('acl_modulos.activo', 1)
            ->orderBy('acl_modulos.orden')
            ->get()
            ->getResultArray();

        $modulesWithPermissions = [];
        foreach ($modules as $module) {
            $moduleId = $module['id'];
            if (!isset($modulesWithPermissions[$moduleId])) {
                $modulesWithPermissions[$moduleId] = [
                    'id' => $moduleId,
                    'nombre' => $module['nombre'],
                    'descripcion' => $module['descripcion'],
                    'permisos' => []
                ];
            }
            if ($module['permiso_id']) {
                $modulesWithPermissions[$moduleId]['permisos'][] = [
                    'id' => $module['permiso_id'],
                    'nombre' => $module['permiso_nombre']
                ];
            }
        }

        return array_values($modulesWithPermissions);
    }
}
