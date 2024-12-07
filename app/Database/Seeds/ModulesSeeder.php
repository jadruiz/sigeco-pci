<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModulesSeeder extends Seeder
{

    public function run()
    {
        $data = [
            [
                (config('KACL')->tableModulesFieldsPrefix) . 'name' => 'Users',
                (config('KACL')->tableModulesFieldsPrefix) . 'description' => 'Module to manage users',
                (config('KACL')->tableModulesFieldsPrefix) . 'created_at' => date('Y-m-d H:i:s'),
                (config('KACL')->tableModulesFieldsPrefix) . 'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                (config('KACL')->tableModulesFieldsPrefix) . 'name' => 'About',
                (config('KACL')->tableModulesFieldsPrefix) . 'description' => 'About',
                (config('KACL')->tableModulesFieldsPrefix) . 'created_at' => date('Y-m-d H:i:s'),
                (config('KACL')->tableModulesFieldsPrefix) . 'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insertar los datos en la tabla de módulos
        $this->db->table(config('KACL')->tablePrefix . 'modules')->insertBatch($data);
    }
}
