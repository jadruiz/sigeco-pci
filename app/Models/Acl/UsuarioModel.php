<?php

namespace App\Models\Acl;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'acl_usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'password_hash',
        'email',
        'activo',
        'fecha_creacion',
    ];

    /**
     * Obtiene los módulos permitidos para un usuario en función de su rol y permisos.
     *
     * @param int $userId ID del usuario
     * @return array Módulos permitidos para el usuario
     */
    public function getModulosPermitidos(int $userId): array
    {
        return $this->db->table('acl_modulos as m')
            ->select('m.id, m.path, m.nombre, m.descripcion, m.icono, m.orden')
            ->distinct()
            ->join('acl_permisos_modulos as pm', 'pm.modulo_id = m.id', 'inner')
            ->join('acl_roles_permisos as rp', 'rp.permiso_id = pm.permiso_id', 'inner')
            ->join('acl_usuarios_roles as ur', 'ur.rol_id = rp.rol_id', 'inner')
            ->where('ur.usuario_id', $userId)
            ->where('m.activo', 1)
            ->orderBy('m.orden')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene los permisos específicos de un módulo para un usuario en función de su rol.
     *
     * @param int $userId ID del usuario
     * @param int $moduloId ID del módulo
     * @return array Permisos específicos para el módulo
     */
    public function getPermisosModulo(int $userId, int $moduloId): array
    {
        return $this->db->table('acl_roles_permisos as rp')
            ->select('p.nombre as permiso')
            ->join('acl_permisos as p', 'p.id = rp.permiso_id', 'inner')
            ->join('acl_usuarios_roles as ur', 'ur.rol_id = rp.rol_id', 'inner')
            ->join('acl_permisos_modulos as pm', 'pm.permiso_id = rp.permiso_id', 'inner')
            ->where('ur.usuario_id', $userId)
            ->where('pm.modulo_id', $moduloId)
            ->get()
            ->getResultArray();
    }

    public function getRolesPorUsuario(int $userId): array
    {
        return $this->db->table('acl_roles as r')
            ->select('r.nombre')
            ->join('acl_usuarios_roles as ur', 'ur.rol_id = r.id', 'inner')
            ->where('ur.usuario_id', $userId)
            ->get()
            ->getResultArray();
    }

    public function getPermisosPorUsuario(int $userId): array
    {
        return $this->db->table('acl_permisos as p')
            ->select('p.nombre')
            ->join('acl_roles_permisos as rp', 'rp.permiso_id = p.id', 'inner')
            ->join('acl_usuarios_roles as ur', 'ur.rol_id = rp.rol_id', 'inner')
            ->where('ur.usuario_id', $userId)
            ->get()
            ->getResultArray();
    }
}
