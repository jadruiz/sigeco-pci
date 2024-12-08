<?php

namespace App\Models;

use CodeIgniter\Model;

class ParticipanteModel extends Model
{
    protected $table = 'sgc_participantes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'password',
        'email',
        'telefono',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'activo',
        'eliminado',
        'creado_en',
        'actualizado_en'
    ];

    protected $useTimestamps = false;

    /**
     * Obtener ponentes por ID de congreso
     *
     * @param int $congreso_id
     * @return array
     */
    public function obtenerPonentesPorCongreso($congreso_id)
    {
        $builder = $this->db->table('sgc_participantes p');
        $builder->select('p.*');
        $builder->join('sgc_inscripciones_congreso ic', 'p.id = ic.participante_id');
        $builder->join('sgc_participantes_roles pr', 'p.id = pr.participante_id');
        $builder->where('ic.congreso_id', $congreso_id);
        $builder->where('pr.rol_id', 2); // Asumiendo que 2 es el ID para Ponente
        $builder->where('p.activo', 1);
        $builder->where('p.eliminado', 0);
        $builder->groupBy('p.id');
        return $builder->get()->getResultArray();
    }
}
