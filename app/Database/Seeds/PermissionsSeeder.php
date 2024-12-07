<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $tablePrefix = config('KACL')->tablePrefix;
        $tablePermissionsFieldsPrefix = config('KACL')->tablePermissionsFieldsPrefix;

        $data = [
            [
                $tablePermissionsFieldsPrefix . 'name' => 'Crear usuario',
                $tablePermissionsFieldsPrefix . 'description' => 'Permite crear un nuevo usuario en el sistema.',
                $tablePermissionsFieldsPrefix . 'module_id' => 1,
            ],
            [
                $tablePermissionsFieldsPrefix . 'name' => 'Modificar usuario',
                $tablePermissionsFieldsPrefix . 'description' => 'Permite modificar un usuario del sistema.',
                $tablePermissionsFieldsPrefix . 'module_id' => 1,
            ],
            [
                $tablePermissionsFieldsPrefix . 'name' => 'Eliminar usuario',
                $tablePermissionsFieldsPrefix . 'description' => 'Permiter eliminar un usuario del sistema.',
                $tablePermissionsFieldsPrefix . 'module_id' => 1,
            ],
        ];
        $tableName = $tablePrefix . 'permissions';
        $this->db->table($tableName)->insertBatch($data);
    }
}
