<?php

namespace Config;

// Importar la clase RouteCollection
use CodeIgniter\Router\RouteCollection;

// Crear una instancia del servicio de rutas
$routes = Services::routes();

// Cargar el sistema de rutas por defecto
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// Configuraciones generales de rutas
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// Deshabilitar Auto Routing (mejor seguridad)
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Rutas Públicas (sin autenticación)
 * --------------------------------------------------------------------
 */

// Página de inicio
$routes->get('/', 'Website\Home::index', ['as' => 'home']);

// Rutas de autenticación 
$routes->match(['get', 'post'], 'admin/login', 'Acl\AuthController::login', ['as' => 'admin.login']);
$routes->get('admin/logout', 'Acl\AuthController::logout', ['as' => 'admin.logout']);

// Rutas adicionales públicas
$routes->get('auth/secret/(:any)', 'AuthController::secret/$1', [
    'namespace' => 'App\Controllers\Acl',
    'as' => 'auth.secret'
]);

/*
 * --------------------------------------------------------------------
 * Rutas de Administración (requieren autenticación y permisos)
 * --------------------------------------------------------------------
 */
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => ['aclAuth', 'aclPermissions']], function ($routes) {
    
    // Dashboard
    $routes->get('dashboard', 'DashboardController::index', ['as' => 'admin.dashboard']);

    // Congresos
    $routes->group('congresos', function ($routes) {
        $routes->get('/', 'CongresosController::index', ['as' => 'admin.congresos.index']);
        $routes->get('crear', 'CongresosController::crear', ['as' => 'admin.congresos.crear']);
        $routes->post('guardar', 'CongresosController::guardar', ['as' => 'admin.congresos.guardar']);
        $routes->get('editar/(:num)', 'CongresosController::editar/$1', ['as' => 'admin.congresos.editar']);
        $routes->post('actualizar/(:num)', 'CongresosController::actualizar/$1', ['as' => 'admin.congresos.actualizar']);
        $routes->post('eliminar/(:num)', 'CongresosController::eliminar/$1', ['as' => 'admin.congresos.eliminar']);
    });

    // Artículos
    $routes->group('articulos', function ($routes) {
        $routes->get('/', 'ArticulosController::index', ['as' => 'admin.articulos.index']);
        $routes->get('crear', 'ArticulosController::crear', ['as' => 'admin.articulos.crear']);
        $routes->post('guardar', 'ArticulosController::guardar', ['as' => 'admin.articulos.guardar']);
        $routes->get('editar/(:num)', 'ArticulosController::editar/$1', ['as' => 'admin.articulos.editar']);
        $routes->post('actualizar/(:num)', 'ArticulosController::actualizar/$1', ['as' => 'admin.articulos.actualizar']);
        $routes->post('eliminar/(:num)', 'ArticulosController::eliminar/$1', ['as' => 'admin.articulos.eliminar']);
    });

    // Participación
    $routes->group('participacion', function ($routes) {
        $routes->get('/', 'ParticipacionController::index', ['as' => 'admin.participacion.index']);
        $routes->get('crear', 'ParticipacionController::crear', ['as' => 'admin.participacion.crear']);
        $routes->post('guardar', 'ParticipacionController::guardar', ['as' => 'admin.participacion.guardar']);
        $routes->get('editar/(:num)', 'ParticipacionController::editar/$1', ['as' => 'admin.participacion.editar']);
        $routes->post('actualizar/(:num)', 'ParticipacionController::actualizar/$1', ['as' => 'admin.participacion.actualizar']);
        $routes->post('eliminar/(:num)', 'ParticipacionController::eliminar/$1', ['as' => 'admin.participacion.eliminar']);
    });

    // Evaluaciones
    $routes->group('evaluaciones', function ($routes) {
        $routes->get('/', 'EvaluacionesController::index', ['as' => 'admin.evaluaciones.index']);
        $routes->get('evaluar/(:num)', 'EvaluacionesController::evaluar/$1', ['as' => 'admin.evaluaciones.evaluar']);
        $routes->post('guardar_evaluacion', 'EvaluacionesController::guardarEvaluacion', ['as' => 'admin.evaluaciones.guardar']);
        $routes->get('resultados', 'EvaluacionesController::resultados', ['as' => 'admin.evaluaciones.resultados']);
    });

    // Pagos
    $routes->group('pagos', function ($routes) {
        $routes->get('/', 'PagosController::index', ['as' => 'admin.pagos.index']);
        $routes->get('crear', 'PagosController::crear', ['as' => 'admin.pagos.crear']);
        $routes->post('guardar', 'PagosController::guardar', ['as' => 'admin.pagos.guardar']);
        $routes->get('editar/(:num)', 'PagosController::editar/$1', ['as' => 'admin.pagos.editar']);
        $routes->post('actualizar/(:num)', 'PagosController::actualizar/$1', ['as' => 'admin.pagos.actualizar']);
        $routes->post('eliminar/(:num)', 'PagosController::eliminar/$1', ['as' => 'admin.pagos.eliminar']);
    });

    // Inteligencia Artificial (IA)
    $routes->group('ia', function ($routes) {
        $routes->get('/', 'IAController::index', ['as' => 'admin.ia.index']);
        $routes->get('configurar', 'IAController::configurar', ['as' => 'admin.ia.configurar']);
        $routes->post('guardar_configuracion', 'IAController::guardarConfiguracion', ['as' => 'admin.ia.guardar_configuracion']);
        $routes->get('supervisar', 'IAController::supervisar', ['as' => 'admin.ia.supervisar']);
    });

});

/*
 * --------------------------------------------------------------------
 * Rutas No Encontradas (404 Override)
 * --------------------------------------------------------------------
 
$routes->set404Override(function(){
    return view('errors/html/error_404');
});*/

/*
 * --------------------------------------------------------------------
 * Finalización del Archivo de Rutas
 * --------------------------------------------------------------------
 */

// Cargar rutas adicionales si existen
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
