<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Obtener los prefijos de tabla y de campo desde la configuración KACL
        $tablePrefix = config('KACL')->tablePrefix;
        $tableRolesFieldsPrefix = config('KACL')->tableRolesFieldsPrefix;

        // Definir los datos de los roles
        $roles = [
            [
                'name' => 'Master Admin',
                'description' => 'Has all permissions',
            ],
            [
                'name' => 'Guest',
                'description' => 'Read only permissions',
            ],
        ];

        // Agregar el prefijo al nombre de la tabla
        $tableName = $tablePrefix . 'roles';

        // Agregar el prefijo de campo a cada entrada de datos
        foreach ($roles as &$role) {
            foreach ($role as $key => $value) {
                $role[$tableRolesFieldsPrefix . $key] = $value;
                unset($role[$key]);
            }
        }

        // Insertar los datos en la tabla con el prefijo
        $this->db->table($tableName)->insertBatch($roles);
    }
}
