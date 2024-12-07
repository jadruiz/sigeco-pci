<?php
// app/Controllers/Admin/UserSeeder.php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\UsuarioModel;

class UserSeeder extends BaseController
{
    public function createAdminUser()
    {
        $model = new UsuarioModel();

        // Crear el hash de la contraseña
        $passwordHash = password_hash('admin123', PASSWORD_DEFAULT);

        // Datos del usuario
        $userData = [
            'username' => 'admin',
            'password_hash' => $passwordHash,
            'email' => 'admin@example.com',
            'activo' => 1
        ];

        // Insertar el usuario en la base de datos
        $model->save($userData);

        echo "Usuario administrador creado con éxito.";
    }
}
