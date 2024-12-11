<?= $this->extend('admin/layouts/main'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid py-4">
    <h1 class="text-primary mb-4 text-center">Dashboard Administrativo</h1>

    <!-- Indicadores Clave -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center p-3 shadow-sm" style="background-color: var(--clr-primary-lightest);">
                <h5 style="color: var(--clr-text-darkest);">Total Usuarios</h5>
                <h3 style="color: var(--clr-primary-dark);"><?= $totalUsuarios ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 shadow-sm" style="background-color: var(--clr-secondary-lightest);">
                <h5 style="color: var(--clr-text-darkest);">Intentos Fallidos</h5>
                <h3 style="color: var(--clr-secondary-darkest);"><?= $intentosFallidos ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 shadow-sm" style="background-color: var(--clr-primary-lightest);">
                <h5 style="color: var(--clr-text-darkest);">Congresos Activos</h5>
                <h3 style="color: var(--clr-primary-dark);"><?= $congresosActivos ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3 shadow-sm" style="background-color: var(--clr-secondary-lightest);">
                <h5 style="color: var(--clr-text-darkest);">Artículos Subidos</h5>
                <h3 style="color: var(--clr-secondary-dark);"><?= $totalArticulos ?></h3>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <h5 class="text-center mb-3">Artículos por Estado</h5>
                <canvas id="articulosChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4 shadow-sm">
                <h5 class="text-center mb-3">Distribución de Roles</h5>
                <canvas id="rolesChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card p-4 shadow-sm">
                <h5 class="text-center mb-3">Historial de Intentos de Login</h5>
                <canvas id="loginChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Paleta de colores personalizada
    const colors = {
        primary: '#1976d2',
        secondary: '#ffb300',
        success: '#2e8540',
        danger: '#ef5350',
        info: '#26c6da',
        warning: '#ffbf47',
        light: '#90caf9',
        dark: '#37474f',
    };

    // Artículos por Estado
    const articulosPorEstado = <?= json_encode($articulosPorEstado) ?>;
    new Chart(document.getElementById('articulosChart'), {
        type: 'bar',
        data: {
            labels: articulosPorEstado.map(e => e.estado),
            datasets: [{
                label: 'Cantidad de Artículos',
                data: articulosPorEstado.map(e => e.total),
                backgroundColor: [
                    colors.primary, colors.secondary, colors.success, 
                    colors.danger, colors.warning
                ],
                borderColor: colors.dark,
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Número de Artículos' } },
                x: { title: { display: true, text: 'Estado' } }
            }
        }
    });

    // Distribución de Roles
    const rolesUsuarios = <?= json_encode($rolesUsuarios) ?>;
    new Chart(document.getElementById('rolesChart'), {
        type: 'pie',
        data: {
            labels: rolesUsuarios.map(r => r.nombre),
            datasets: [{
                data: rolesUsuarios.map(r => r.total),
                backgroundColor: [
                    colors.primary, colors.secondary, colors.info, 
                    colors.warning, colors.danger
                ]
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom', labels: { color: colors.dark } },
                tooltip: { enabled: true }
            }
        }
    });

    // Historial de Intentos de Login
    const loginAttempts = <?= json_encode($loginAttempts) ?>;
    new Chart(document.getElementById('loginChart'), {
        type: 'line',
        data: {
            labels: loginAttempts.dates,
            datasets: [
                {
                    label: 'Logins Exitosos',
                    data: loginAttempts.success,
                    borderColor: colors.primary,
                    backgroundColor: 'rgba(25, 118, 210, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Logins Fallidos',
                    data: loginAttempts.failed,
                    borderColor: colors.danger,
                    backgroundColor: 'rgba(239, 83, 80, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            plugins: {
                legend: { position: 'top', labels: { color: colors.dark } }
            },
            scales: {
                x: { title: { display: true, text: 'Fecha' }, ticks: { color: colors.dark } },
                y: { title: { display: true, text: 'Número de Intentos' }, ticks: { color: colors.dark } }
            }
        }
    });
</script>

<?= $this->endSection(); ?>
