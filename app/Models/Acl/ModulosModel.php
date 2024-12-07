<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ModulosModel extends Model
{
    protected $table = 'acl_modulos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'clave',
        'icono',
        'path',
        'nombre',
        'descripcion',
        'activo',
        'orden',
        'created_at',
        'updated_at'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nombre' => 'required|is_unique[acl_modulos.nombre]|max_length[50]',
        'clave' => 'required|is_unique[acl_modulos.clave]|max_length[30]',
        'activo' => 'in_list[0,1]',
        'icono' => 'permit_empty|max_length[100]',
        'path' => 'permit_empty|max_length[255]',
        'orden' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre del módulo es obligatorio.',
            'is_unique' => 'El nombre del módulo ya existe en el sistema.',
            'max_length' => 'El nombre del módulo no debe superar los 50 caracteres.'
        ],
        'clave' => [
            'required' => 'La clave del módulo es obligatoria.',
            'is_unique' => 'La clave del módulo ya existe en el sistema.',
            'max_length' => 'La clave del módulo no debe superar los 30 caracteres.'
        ],
        'activo' => [
            'in_list' => 'El valor de activo debe ser 0 o 1.'
        ]
    ];

    /**
     * Obtener módulos activos
     */
    public function getActiveModules()
    {
        return $this->where('activo', 1)->findAll();
    }

    /**
     * Activar un módulo
     */
    public function activateModule($id)
    {
        return $this->update($id, ['activo' => 1]);
    }

    /**
     * Desactivar un módulo
     */
    public function deactivateModule($id)
    {
        return $this->update($id, ['activo' => 0]);
    }

    /**
     * Obtener permisos asignados a un módulo específico
     */
    public function getPermissionsForModule($moduleId)
    {
        return $this->db->table('acl_permisos')
            ->select('acl_permisos.id, acl_permisos.nombre, acl_permisos.descripcion')
            ->join('acl_permisos_modulos', 'acl_permisos.id = acl_permisos_modulos.permiso_id')
            ->where('acl_permisos_modulos.modulo_id', $moduleId)
            ->where('acl_permisos.activo', 1)
            ->get()
            ->getResultArray();
    }

    /**
     * Asignar un permiso a un módulo
     */
    public function assignPermissionToModule($permissionId, $moduleId)
    {
        return $this->db->table('acl_permisos_modulos')->insert([
            'permiso_id' => $permissionId,
            'modulo_id' => $moduleId
        ]);
    }

    /**
     * Remover un permiso de un módulo
     */
    public function removePermissionFromModule($permissionId, $moduleId)
    {
        return $this->db->table('acl_permisos_modulos')
            ->where('permiso_id', $permissionId)
            ->where('modulo_id', $moduleId)
            ->delete();
    }

    /**
     * Obtener todos los módulos con los permisos asignados
     */
    public function getModulesWithPermissions()
    {
        // Obtener todos los módulos
        $modules = $this->db->table('acl_modulos')
            ->select('id, clave, icono, path, nombre, descripcion, activo, orden, created_at, updated_at')
            ->where('activo', 1)
            ->orderBy('orden')
            ->get()
            ->getResultArray();

        // Obtener permisos asociados a cada módulo
        $permissions = $this->db->table('acl_permisos')
            ->select('acl_permisos.id AS permiso_id, acl_permisos.nombre AS permiso_nombre, acl_permisos.descripcion AS permiso_descripcion, acl_permisos_modulos.modulo_id')
            ->join('acl_permisos_modulos', 'acl_permisos.id = acl_permisos_modulos.permiso_id', 'left')
            ->where('acl_permisos.activo', 1)
            ->get()
            ->getResultArray();

        // Estructurar permisos dentro de cada módulo
        $modulesWithPermissions = [];
        foreach ($modules as $module) {
            $moduleId = $module['id'];
            $module['permisos'] = array_filter($permissions, function ($permission) use ($moduleId) {
                return $permission['modulo_id'] == $moduleId;
            });
            // Simplificar estructura de permisos
            $module['permisos'] = array_map(function ($permission) {
                return [
                    'id' => $permission['permiso_id'],
                    'nombre' => $permission['permiso_nombre'],
                    'descripcion' => $permission['permiso_descripcion']
                ];
            }, $module['permisos']);

            $modulesWithPermissions[] = $module;
        }

        return $modulesWithPermissions;
    }
}
