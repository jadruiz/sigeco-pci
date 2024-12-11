<h2 class="text-primary">Realiza el pago</h2>
<div class="row">
    <!-- Detalle del Plan -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Detalle del Plan</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Congreso</th>
                            <th class="text-end">Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= esc($plan['nombre']) ?></td>
                            <td><?= esc($congreso['nombre']) ?></td>
                            <td class="text-end">$<?= number_format($plan['costo_registro'], 2) ?> MXN</td>
                        </tr>
                    </tbody>
                </table>
                <h5 class="text-end mt-3">Total: $<?= number_format($plan['costo_registro'], 2) ?> MXN</h5>
            </div>
        </div>
    </div>

    <!-- Métodos de Pago -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5>Métodos de Pago</h5>
            </div>
            <div class="card-body">
                <!-- Pago con Tarjeta: Abierto por defecto -->
                <h6><i class="fas fa-credit-card"></i> Pago con Tarjeta</h6>
                <form id="tarjeta-form" class="card card-body">
                    <input type="hidden" id="plan_id" value="<?= esc($plan['id']) ?>">
                    <input type="hidden" id="congreso_id" value="<?= esc($congreso['id']) ?>">

                    <div class="mb-2">
                        <label for="card-name" class="form-label">Nombre en la Tarjeta</label>
                        <input type="text" class="form-control" id="card-name" placeholder="Nombre completo" required>
                    </div>
                    <div class="mb-2">
                        <label for="card-number" class="form-label">Número de Tarjeta</label>
                        <input type="text" class="form-control" id="card-number" maxlength="16" placeholder="4242 4242 4242 4242" required>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="exp-month" class="form-label">Mes</label>
                            <input type="text" class="form-control" id="exp-month" maxlength="2" placeholder="MM" required>
                        </div>
                        <div class="col-md-4">
                            <label for="exp-year" class="form-label">Año</label>
                            <input type="text" class="form-control" id="exp-year" maxlength="2" placeholder="YY" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cvc" class="form-label">CVC</label>
                            <input type="text" class="form-control" id="cvc" maxlength="4" placeholder="123" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-3 w-100" id="pagarTarjetaBtn">Pagar</button>
                </form>

                <!-- Botones para OXXO y SPEI -->
                <div class="mt-3">
                    <button class="btn btn-outline-secondary w-100" id="oxxoBtn">
                        <i class="fas fa-store"></i> Pagar en OXXO
                    </button>
                </div>
                <div class="mt-2">
                    <button class="btn btn-outline-secondary w-100" id="speiBtn">
                        <i class="fas fa-university"></i> Pagar con SPEI
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Respuesta -->
<div id="payment-response" class="mt-4 text-center"></div>

<!-- Scripts -->
<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
<script>
    // Configurar llave pública de Conekta
    Conekta.setPublicKey('<?= env('app.sgc.paymentGateway.conekta.publicKey', '') ?>');

    // Pago con Tarjeta
    document.getElementById('pagarTarjetaBtn').addEventListener('click', function(event) {
        event.preventDefault();
        const cardData = {
            "card": {
                "name": document.getElementById("card-name").value,
                "number": document.getElementById("card-number").value,
                "exp_month": document.getElementById("exp-month").value,
                "exp_year": document.getElementById("exp-year").value,
                "cvc": document.getElementById("cvc").value
            }
        };
        enviarPago('tarjeta', 'asdasd7837353');
       /* Conekta.Token.create(cardData, function(token) {
            enviarPago('tarjeta', token.id);
        }, function(error) {
            mostrarRespuesta(error.message_to_purchaser, 'danger');
        });*/
    });

    // Pago en OXXO
    document.getElementById('oxxoBtn').addEventListener('click', function() {
        enviarPago('oxxo');
    });

    // Pago con SPEI
    document.getElementById('speiBtn').addEventListener('click', function() {
        enviarPago('spei');
    });

    // Función para enviar pagos
    function enviarPago(metodo, token_id = null) {
        const data = {
            metodo: metodo,
            plan_id: document.getElementById("plan_id").value,
            congreso_id: document.getElementById("congreso_id").value,
            token_id: token_id
        };

        fetch("<?= site_url('congreso/' . $congreso['id'] . '/pago') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                mostrarRespuesta(data.message, 'success');
                window.location.href ='<?= base_url('congreso/' . $congreso['slug'] . '/registro/paso/4') ?>';
            } else {
                mostrarRespuesta(data.message, 'danger');
            }
        })
        .catch(err => {
            mostrarRespuesta("Error inesperado: " + err.message, 'danger');
        });
    }

    function mostrarRespuesta(mensaje, tipo) {
        document.getElementById('payment-response').innerHTML = `<div class="alert alert-${tipo}">${mensaje}</div>`;
    }
</script>
