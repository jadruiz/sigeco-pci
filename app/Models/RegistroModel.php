<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistroModel extends Model
{
    protected $table = 'sgc_participantes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'password',
        'email',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'telefono',
        'activo',
        'eliminado',
        'creado_en',
        'actualizado_en'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'creado_en';
    protected $updatedField = 'actualizado_en';

    protected $validationRules = [
        'username' => 'required|min_length[5]|is_unique[sgc_participantes.username]',
        'email'    => 'required|valid_email|is_unique[sgc_participantes.email]',
        'password' => 'required|min_length[8]',
        'nombre'   => 'required',
        'apellido_paterno' => 'required',
        'telefono' => 'required|regex_match[/^[0-9]{10}$/]'
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'El nombre de usuario es obligatorio.',
            'is_unique' => 'Este nombre de usuario ya existe.'
        ],
        'email' => [
            'required' => 'El correo electrónico es obligatorio.',
            'valid_email' => 'El correo no es válido.',
            'is_unique' => 'Este correo ya está registrado.'
        ],
        'password' => [
            'required' => 'La contraseña es obligatoria.',
            'min_length' => 'La contraseña debe tener al menos 8 caracteres.'
        ],
        'telefono' => [
            'required' => 'El número de teléfono es obligatorio.',
            'regex_match' => 'El número de teléfono debe contener exactamente 10 dígitos numéricos.'
        ]
    ];

    /**
     * Inserta un participante después de limpiar campos no permitidos
     */
    public function createParticipant(array $data)
    {
        unset($data['confirm_password']);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['activo'] = 1;
        $data['eliminado'] = 0;
        return $this->insert($data);
    }
    
    public function obtenerRolesParticipante($participanteId)
    {
        return $this->db->table('sgc_participantes_roles')
            ->select('sgc_roles.nombre')
            ->join('sgc_roles', 'sgc_roles.id = sgc_participantes_roles.rol_id')
            ->where('sgc_participantes_roles.participante_id', $participanteId)
            ->get()
            ->getResultArray();
    }
}
