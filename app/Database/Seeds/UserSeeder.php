<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Obtener el prefijo de tabla desde la configuración KACL
        $tablePrefix = config('KACL')->tablePrefix;
        $tableUsersFieldsPrefix = config('KACL')->tableUsersFieldsPrefix;

        // Definir los datos de los usuarios con los prefijos adecuados
        $data = [
            [
                $tableUsersFieldsPrefix . 'name' => 'Admin',
                $tableUsersFieldsPrefix . 'email' => 'admin@example.com',
                $tableUsersFieldsPrefix . 'password' => password_hash('admin123', PASSWORD_DEFAULT),
            ],
            [
                $tableUsersFieldsPrefix . 'name' => 'User',
                $tableUsersFieldsPrefix . 'email' => 'user@example.com',
                $tableUsersFieldsPrefix . 'password' => password_hash('user123', PASSWORD_DEFAULT),
            ],
        ];

        // Agregar el prefijo al nombre de la tabla
        $tableName = $tablePrefix . 'users';

        // Insertar los datos en la tabla con el prefijo
        $this->db->table($tableName)->insertBatch($data);
    }
}
