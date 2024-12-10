<?php

namespace App\Controllers;

use App\Models\PagoModel;
use App\Helpers\ConektaHelper;
use CodeIgniter\RESTful\ResourceController;

class PaymentController extends ResourceController
{
    protected $pagoModel;
    protected $conektaHelper;

    public function __construct()
    {
        $this->pagoModel = new PagoModel();
        $this->conektaHelper = new ConektaHelper();
        helper(['form', 'url', 'session']);
    }

    public function realizarPago($congreso_id)
    {
        // Obtén y decodifica el JSON manualmente
        $rawBody = $this->request->getBody();
        $input = json_decode($rawBody);

        // Depuración: verifica el cuerpo crudo
        log_message('debug', 'Cuerpo recibido: ' . $rawBody);

        // Validación de parámetros opcionales
        $metodo = $input->metodo ?? 'oxxo'; // Por defecto OXXO
        $plan_id = $input->plan_id ?? null; // Si no llega, se ignora
        $token_id = $input->token_id ?? null; // Opcional para OXXO y SPEI
        $monto = $input->monto ?? 0.0; // Si no hay monto, usar 0

        // Obtener el ID del participante desde la sesión
        $userId = session()->get('wlp_id');
        if (!$userId) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Usuario no autenticado.'
            ], 401);
        }

        // Obtener datos del participante desde la base de datos
        $participanteModel = new \App\Models\ParticipantesModel();
        $participante = $participanteModel->find($userId);

        if (!$participante) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Participante no encontrado.'
            ], 404);
        }

        // Datos del cliente
        $customerInfo = [
            'name' => "{$participante['nombre']} {$participante['apellido_paterno']} {$participante['apellido_materno']}",
            'email' => $participante['email'],
            'phone' => $participante['telefono'] ?? '0000000000'
        ];

        // Generar referencia única
        $referencia = uniqid("PAY-");

        // Procesar pago solo si es tarjeta (requiere token)
        if ($metodo === 'tarjeta' && $token_id) {
            // Crear orden con Conekta
            /*$resultado = $this->conektaHelper->crearOrden(
                $token_id,           // Token de la tarjeta
                intval($monto * 100), // Monto en centavos
                $customerInfo,
                'Pago de paquete seleccionado'
            );

            // Verificar respuesta de Conekta
            if (isset($resultado['error'])) {
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Error en el pago: ' . $resultado['error']['message_to_purchaser']
                ], 500);
            }
            $referencia = $resultado['id'];*/
        }

        // Insertar pago en la base de datos
        $this->pagoModel->insert([
            'participante_id' => $userId,
            'congreso_id'     => $congreso_id,
            'monto'           => $monto,
            'moneda'          => 'MXN',
            'estado_pago'     => ($metodo === 'tarjeta') ? 'completado' : 'pendiente',
            'metodo_pago'     => ucfirst($metodo),
            'referencia'      => $referencia,
        ]);

        // Actualizar progreso del participante al paso 4
        $progresoModel = new \App\Models\RegistroProgresoModel();

        $progreso = $progresoModel
            ->where('participante_id', $userId)
            ->where('congreso_id', $congreso_id)
            ->first();

        if ($progreso) {
            $progresoModel->update($progreso['id'], ['paso_actual' => 4]);
        } else {
            $progresoModel->insert([
                'participante_id' => $userId,
                'congreso_id'     => $congreso_id,
                'paso_actual'     => 4
            ]);
        }

        // Respuesta de éxito
        return $this->respond([
            'status' => 'success',
            'message' => 'Pago registrado correctamente.',
            'referencia' => $referencia,
            'monto' => $monto,
            'metodo' => ucfirst($metodo),
            'paso_actualizado' => 4
        ], 200);
    }
}
