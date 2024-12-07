<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $tablePrefix = config('KACL')->tablePrefix;
        $tablePermissionRoleFieldsPrefix = config('KACL')->tablePermissionRoleFieldsPrefix;
        $data = [
            [
                $tablePermissionRoleFieldsPrefix . 'role_id' => 1, // ID del rol "Master Admin"
                $tablePermissionRoleFieldsPrefix . 'permission_id' => 1, // ID del permiso "Agregar usuario"
            ],
            [
                $tablePermissionRoleFieldsPrefix . 'role_id' => 1, // ID del rol "Master Admin"
                $tablePermissionRoleFieldsPrefix . 'permission_id' => 2, // ID del permiso "Eliminar usuario"
            ],
            [
                $tablePermissionRoleFieldsPrefix . 'role_id' => 1, // ID del rol "Master Admin"
                $tablePermissionRoleFieldsPrefix . 'permission_id' => 3, // ID del permiso "Modificar usuario"
            ],
            [
                $tablePermissionRoleFieldsPrefix . 'role_id' => 2, // ID del rol "Invitado"
                $tablePermissionRoleFieldsPrefix . 'permission_id' => 3, // ID del permiso "Modificar usuario"
            ],
        ];

        $tableName = $tablePrefix . 'permission_role';
        $this->db->table($tableName)->insertBatch($data);
    }
}
