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
$routes->get('setCongresoSession/(:num)', 'Home::setCongresoSession/$1');
$routes->get('home/cambiarCongreso/(:num)', 'Website\Home::cambiarCongreso/$1');

$routes->get('congresos', 'Website\CongresoController::lista');
$routes->get('congreso/(:segment)', 'Website\CongresoController::detalle/$1');
$routes->get('congreso/(:segment)/convocatoria', 'Website\CongresoController::convocatoria/$1');
$routes->get('congreso/(:segment)/registro', 'Website\CongresoController::registro/$1');
$routes->get('congreso/(:segment)/programa', 'Website\CongresoController::programa/$1');
$routes->get('congreso/(:segment)/finalizado', 'Website\CongresoController::finalizado/$1');

$routes->group('congreso', function ($routes) {
    $routes->get('(:segment)/registro', 'Website\CongresoController::registro/$1');
    $routes->get('(:segment)/registro/paso/(:num)', 'Website\CongresoController::registroPaso/$1/$2');
    $routes->post('(:segment)/registro/finalizar', 'Website\CongresoController::finalizarRegistro/$1');
    $routes->get('(:segment)/registro/completado', 'Website\CongresoController::registroCompletado/$1');
});

$routes->get('registro/set_congreso/(:segment)/(:num)', 'RegistroController::setCongreso/$1/$2');


/*
$routes->group('congreso', function ($routes) {
    // Ruta para registro de participantes
    $routes->get('(:alphanum)/registro', 'RegistroController::index/$1', ['as' => 'congreso_registro']);
    $routes->post('(:alphanum)/registro', 'RegistroController::store/$1');
    
    // Ruta para ver detalles del congreso
    $routes->get('(:alphanum)', 'CongresoController::index/$1', ['as' => 'congreso_detalle']);
    
    // Ruta para listar todos los eventos de un congreso
    $routes->get('(:alphanum)/eventos', 'EventoController::index/$1', ['as' => 'congreso_eventos']);
    
    // Ruta para ver un evento específico
    $routes->get('(:alphanum)/eventos/(:num)', 'EventoController::show/$1/$2', ['as' => 'congreso_evento_detalle']);
    
    // Ruta para editar un perfil relacionado al congreso
    $routes->get('(:alphanum)/perfil', 'PerfilController::index/$1', ['filter' => 'auth', 'as' => 'congreso_perfil']);
    $routes->post('(:alphanum)/perfil', 'PerfilController::update/$1', ['filter' => 'auth']);
});*/

/*
 * --------------------------------------------------------------------
 * Rutas Públicas (sin autenticación)
 * --------------------------------------------------------------------
 */

// Página de inicio
$routes->get('/', 'Website\Home::index', ['as' => 'home']);
//$routes->get('login', 'LoginController::index');

/*$routes->get('/login', 'AuthController::login');
$routes->post('/auth/login', 'AuthController::doLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register');
$routes->post('/auth/register', 'AuthController::doRegister');*/

// Rutas de acceso
// Rutas amigables para usuarios pero estandarizadas
$routes->get('/iniciar-sesion', 'AuthController::login');
$routes->post('/iniciar-sesion/procesar', 'AuthController::doLogin');
$routes->get('/cerrar-sesion', 'AuthController::logout');
$routes->get('/registro', 'AuthController::register');
$routes->post('/registro/procesar', 'AuthController::doRegister');
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'authUser']);



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
