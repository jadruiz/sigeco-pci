<?php
namespace App\Helpers;

class ConektaHelper
{
    protected $privateKey;

    public function __construct()
    {
        // Cargar clave privada desde el archivo .env
        $this->privateKey = env('app.sgc.paymentGateway.conekta.privateKey');
    }

    /**
     * Crear una orden de pago en Conekta.
     * @param string $token_id Token generado en el frontend.
     * @param int $amount Monto total en centavos.
     * @param array $customerInfo Datos del cliente.
     * @param string $description Descripción del pago.
     * @return array
     */
    public function crearOrden($token_id, $amount, $customerInfo, $description = 'Pago de paquete')
    {
        $url = "https://api.conekta.io/orders";
        $headers = [
            "Content-Type: application/json",
            "Accept: application/vnd.conekta-v2.0.0+json",
            "Authorization: Basic " . base64_encode($this->privateKey . ":")
        ];

        $data = [
            "currency" => "MXN",
            "customer_info" => [
                "name" => $customerInfo['name'],
                "email" => $customerInfo['email'],
                "phone" => $customerInfo['phone']
            ],
            "line_items" => [
                [
                    "name" => $description,
                    "unit_price" => $amount, // En centavos
                    "quantity" => 1
                ]
            ],
            "charges" => [
                [
                    "payment_method" => [
                        "type" => "card",
                        "token_id" => $token_id
                    ]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 || $httpCode === 201) {
            return json_decode($response, true);
        } else {
            return ["error" => json_decode($response, true)];
        }
    }
}
