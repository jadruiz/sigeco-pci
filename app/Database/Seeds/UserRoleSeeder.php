<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        $tablePrefix = config('KACL')->tablePrefix;
        $tableRoleUserFieldsPrefix = config('KACL')->tableRoleUserFieldsPrefix;
        $data = [
            [
                $tableRoleUserFieldsPrefix . 'user_id' => 1, // ID del usuario
                $tableRoleUserFieldsPrefix . 'role_id' => 1, // ID del rol "Master Admin"
            ],
            [
                $tableRoleUserFieldsPrefix . 'user_id' => 2, // ID del usuario
                $tableRoleUserFieldsPrefix . 'role_id' => 2, // ID del rol "Invitado"
            ],
        ];
        $tableName = $tablePrefix . 'role_user';
        $this->db->table($tableName)->insertBatch($data);
    }
}
