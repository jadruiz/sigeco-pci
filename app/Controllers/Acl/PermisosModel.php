<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class PermisosModel extends Model
{
    protected $table = 'acl_permisos';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre',
        'descripcion',
        'activo',
        'created_at',
        'updated_at'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'nombre' => 'required|is_unique[acl_permisos.nombre]|max_length[50]',
        'descripcion' => 'permit_empty|string|max_length[255]',
        'activo' => 'in_list[0,1]'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required' => 'El nombre del permiso es obligatorio.',
            'is_unique' => 'El nombre del permiso ya existe en el sistema.',
            'max_length' => 'El nombre del permiso no debe superar los 50 caracteres.'
        ],
        'activo' => [
            'in_list' => 'El valor de activo debe ser 0 o 1.'
        ]
    ];

    /**
     * Obtener permisos activos
     */
    public function getActivePermissions()
    {
        return $this->where('activo', 1)->findAll();
    }

    /**
     * Activar un permiso
     */
    public function activatePermission($id)
    {
        return $this->update($id, ['activo' => 1]);
    }

    /**
     * Desactivar un permiso
     */
    public function deactivatePermission($id)
    {
        return $this->update($id, ['activo' => 0]);
    }

    /**
     * Obtener permisos asignados a un módulo específico
     */
    public function getPermissionsByModule($moduleId)
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
     * Obtener todos los módulos con sus permisos asignados
     */
    public function getModulesWithPermissions()
    {
        return $this->db->table('acl_modulos')
            ->select('acl_modulos.id AS module_id, acl_modulos.nombre AS module_name, acl_permisos.id AS permiso_id, acl_permisos.nombre AS permiso_nombre')
            ->join('acl_permisos_modulos', 'acl_modulos.id = acl_permisos_modulos.modulo_id', 'left')
            ->join('acl_permisos', 'acl_permisos_modulos.permiso_id = acl_permisos.id', 'left')
            ->where('acl_modulos.activo', 1)
            ->get()
            ->getResultArray();
    }
}
