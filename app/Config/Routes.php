<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Página de login
// Rutas públicas (sin autenticación)
$routes->get('/', 'ProcesoController::index');
$routes->get('login', 'LoginController::index');
$routes->post('login/autenticar', 'LoginController::autenticar');
$routes->get('logout', 'LoginController::logout');
$routes->get('proceso/iniciar/(:num)', 'ProcesoController::iniciar/$1');
$routes->post('login/validarUsuario', 'LoginController::validarUsuario');

$routes->get('auth/secret/(:any)', 'AuthController::secret/$1',['namespace' => 'App\Controllers\Acl']);

// Rutas del proceso (requieren autenticación)
$routes->group('proceso', ['filter' => 'authUser'], function ($routes) {
    $routes->get('paso/(:num)', 'ProcesoController::paso/$1');
    $routes->post('he-leido', 'ProcesoController::heLeido');
    $routes->post('he-escuchado', 'ProcesoController::marcarPruebaAudioHecha');
    $routes->get('imprimirFicha', 'ProcesoController::imprimirFicha');
});

// Grupo de rutas de estudiantes con filtro 'authUser'
$routes->group('', ['filter' => 'authUser'], function ($routes) {
    $routes->get('dashboard', 'Home::index');
    // Rutas de exámenes
    $routes->group('examen', function ($routes) {
        $routes->get('(:num)/seccion/(:num)', 'ExamenController::mostrarSeccion/$1/$2');
        $routes->post('guardar_respuestas', 'ExamenController::guardarRespuestas');
        $routes->get('(:num)/resultados', 'ExamenController::mostrarResultados/$1');
        $routes->post('registra_audio_escuchado', 'ExamenController::guardarAudioEscuchado');
    });
});

$routes->group('admin', ['namespace' => 'App\Controllers\Acl'], function ($routes) {
    // --- RUTAS PÚBLICAS: Autenticación ---
    $routes->get('', 'AuthController::login');
    $routes->match(['get', 'post'], 'login', 'AuthController::login');
    $routes->get('logout', 'AuthController::logout');
});

// Grupo de rutas para la administración
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => ['aclAuth', 'aclPermissions']], function ($routes) {
    // --- RUTAS PROTEGIDAS: Requieren autenticación ---
    $routes->get('dashboard', 'DashboardController::index', ['filter' => 'aclAuth', 'aclPermissions']);
    //$routes->get('dashboard', 'DashboardController::index');
    $routes->get('calificarexamen/(:num)', 'CalificacionController::mostrarCalificacion/$1');
    $routes->post('calificarexamen/guardar', 'CalificacionController::guardarCalificacion');

    $routes->get('calificaciones/lista', 'CalificacionController::lista', ['as' => 'admin.calificaciones.lista']);
    $routes->post('calificaciones/lista', 'CalificacionController::lista', ['as' => 'admin.calificaciones.lista.post']);

    $routes->post('obtener-opciones-carreras', 'CatalogosController::obtenerOpcionesCarreras');
    $routes->post('obtener-opciones-examenes', 'CatalogosController::obtenerOpcionesExamenes');

    $routes->get('resultados', 'ResultadosController::index');
    $routes->post('resultados', 'ResultadosController::index');
    $routes->post('resultados/obtenerCarrerasDinamicas', 'ResultadosController::obtenerCarrerasDinamicas'); 
    $routes->post('resultados/exportar', 'ResultadosController::exportar');

    $routes->get('informacion', 'InformacionController::index');  // Información/Ayuda
    $routes->get('procesos', 'ProcesosController::index');        // Procesos
    $routes->get('examenes', 'ExamenController::index');          // Exámenes
    $routes->get('examen/ver/(:num)', 'ExamenController::verExamen/$1');
    $routes->get('reportes-resultados', 'ReportesResultadosController::index'); // Reportes y Resultados
    // Calificaciones
    $routes->group('calificaciones', function ($routes) {
        //$routes->get('', 'CalificacionController::index');$routes->post('', 'CalificacionesController::index');
        $routes->match(['get', 'post'], '/', 'CalificacionController::index');
        $routes->post('lista_json', 'CalificacionController::lista_json');  // Listado en formato JSON

        // Submódulos específicos de calificaciones
        $routes->post('cargarCarreras', 'CalificacionController::cargarCarreras');
        $routes->post('cargarProcesos', 'CalificacionController::cargarProcesos');
        $routes->post('cargarExamenes', 'CalificacionController::cargarExamenes');
    });

    // --- RUTAS PROTEGIDAS: CRUD de sustentantes ---
    $routes->group('sustentantes', function ($routes) {
        $routes->get('', 'SustentantesController::index');
        $routes->match(['get', 'post'], 'importar', 'SustentantesController::importar', ['filter' => 'aclPermissions:admin_importar_sustentantes']);
        $routes->match(['get', 'post'], 'agregar', 'SustentantesController::agregar', ['filter' => 'aclPermissions:admin_agregar_sustentantes']);
        $routes->match(['get', 'post'], '(:num)/editar', 'SustentantesController::editar/$1', ['filter' => 'aclPermissions:admin_editar_sustentantes']);
        $routes->post('(:num)/eliminar', 'SustentantesController::eliminar/$1', ['filter' => 'aclPermissions:admin_eliminar_sustentantes']);
        $routes->post('lista_json', 'SustentantesController::lista_json');
    });

    // --- RUTAS PROTEGIDAS: CRUD de usuarios del sistema ---
    $routes->group('usuarios', function ($routes) {
        $routes->get('', 'UsuariosController::index');
        $routes->match(['get', 'post'], 'importar', 'UsuariosController::importar', ['filter' => 'aclPermissions:admin_importar_usuarios']);
        $routes->match(['get', 'post'], 'agregar', 'UsuariosController::agregar', ['filter' => 'aclPermissions:admin_agregar_usuarios']);
        $routes->match(['get', 'post'], '(:num)/editar', 'UsuariosController::editar/$1', ['filter' => 'aclPermissions:admin_editar_usuarios']);
        $routes->post('(:num)/eliminar', 'UsuariosController::eliminar/$1', ['filter' => 'aclPermissions:admin_eliminar_usuarios']);
        $routes->post('lista_json', 'UsuariosController::lista_json');
    });

    // --- RUTAS PROTEGIDAS: CRUD de roles del sistema ---
    $routes->group('roles', function ($routes) {
        $routes->get('', 'RolesController::index');
        $routes->match(['get', 'post'], 'importar', 'RolesController::importar', ['filter' => 'aclPermissions:admin_importar_roles']);
        $routes->match(['get', 'post'], 'agregar', 'RolesController::agregar', ['filter' => 'aclPermissions:admin_agregar_roles']);
        $routes->match(['get', 'post'], '(:num)/editar', 'RolesController::editar/$1', ['filter' => 'aclPermissions:admin_editar_roles']);
        $routes->post('(:num)/eliminar', 'RolesController::eliminar/$1', ['filter' => 'aclPermissions:admin_eliminar_roles']);
        $routes->post('lista_json', 'RolesController::lista_json');
    });

    // --- RUTAS PROTEGIDAS: CRUD de exámenes ---
    $routes->group('examenes', function ($routes) {
        $routes->get('', 'ExamenController::index');
        $routes->get('importar', 'ExamenController::mostrarVistaImportacion');
        $routes->post('importar', 'ExamenController::importar');
        //$routes->match(['get', 'post'], 'importar', 'ExamenController::importar', ['filter' => 'aclPermissions:admin_importar_examenes']);
        $routes->match(['get', 'post'], 'agregar', 'ExamenController::agregar', ['filter' => 'aclPermissions:admin_agregar_examenes']);
        $routes->match(['get', 'post'], '(:num)/editar', 'ExamenController::editar/$1', ['filter' => 'aclPermissions:admin_editar_examenes']);
        $routes->post('(:num)/eliminar', 'ExamenController::eliminar/$1', ['filter' => 'aclPermissions:admin_eliminar_examenes']);
        $routes->post('lista_json', 'ExamenController::lista_json');
    });

    // --- RUTAS PROTEGIDAS: CRUD de procesos ---
    $routes->group('procesos', function ($routes) {
        $routes->get('', 'ProcesosController::index');
        $routes->match(['get', 'post'], 'importar', 'ProcesosController::importar', ['filter' => 'aclPermissions:admin_importar_procesos']);
        $routes->match(['get', 'post'], 'agregar', 'ProcesosController::agregar', ['filter' => 'aclPermissions:admin_agregar_procesos']);
        $routes->match(['get', 'post'], '(:num)/editar', 'ProcesosController::editar/$1', ['filter' => 'aclPermissions:admin_editar_procesos']);
        $routes->post('(:num)/eliminar', 'ProcesosController::eliminar/$1', ['filter' => 'aclPermissions:admin_eliminar_procesos']);
        $routes->post('lista_json', 'ProcesosController::lista_json');
    });
});


//$routes->get('/admin/userseeder/createadminuser', 'Admin\UserSeeder::createAdminUser');
