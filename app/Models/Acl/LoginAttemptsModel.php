<?php

namespace App\Models\Acl;

use CodeIgniter\Model;

class LoginAttemptsModel extends Model
{
    protected $table = 'acl_login_attempts';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'ip_address',
        'attempted_at',
        'success'
    ];

    protected $useTimestamps = false;

    /**
     * Registrar un intento de inicio de sesión
     *
     * @param string $username
     * @param string $ipAddress
     * @param bool $success
     * @return int|bool ID del intento insertado o false si falla
     */
    public function registrarIntento($username, $ipAddress, $success)
    {
        $data = [
            'username'    => $username,
            'ip_address'  => $ipAddress,
            'success'     => $success ? 1 : 0,
            'attempted_at'=> date('Y-m-d H:i:s'),
        ];

        return $this->insert($data);
    }

    /**
     * Contar intentos fallidos por IP en un período de tiempo
     *
     * @param string $ipAddress
     * @param string $startTime
     * @return int
     */
    public function contarIntentosFallidosPorIP($ipAddress, $startTime)
    {
        return $this->where('ip_address', $ipAddress)
                    ->where('success', 0)
                    ->where('attempted_at >=', $startTime)
                    ->countAllResults();
    }

    /**
     * Contar intentos fallidos por usuario en un período de tiempo
     *
     * @param string $username
     * @param string $startTime
     * @return int
     */
    public function contarIntentosFallidosPorUsuario($username, $startTime)
    {
        return $this->where('username', $username)
                    ->where('success', 0)
                    ->where('attempted_at >=', $startTime)
                    ->countAllResults();
    }

    /**
     * Obtener los intentos de inicio de sesión más recientes
     *
     * @param int $limit
     * @return array
     */
    public function obtenerIntentosRecientes($limit = 10)
    {
        return $this->orderBy('attempted_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Obtener estadísticas de intentos agrupadas por fecha
     *
     * @param int $dias Número de días anteriores para agrupar
     * @return array
     */
    public function obtenerEstadisticasIntentos($dias = 7)
    {
        $fechaInicio = date('Y-m-d', strtotime("-$dias days"));
        return $this->select("DATE(attempted_at) as fecha, 
                             SUM(success = 1) as exitosos, 
                             SUM(success = 0) as fallidos")
                    ->where('attempted_at >=', $fechaInicio)
                    ->groupBy('DATE(attempted_at)')
                    ->orderBy('fecha', 'ASC')
                    ->findAll();
    }
}
