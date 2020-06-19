<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, Content-Disposition');
header('Access-Control-Expose-Headers: Content-Disposition');
/**
 * CORE IMPORTS
 */
include_once __DIR__ . '../../core/request.php';
include_once __DIR__ . '../../core/router.php';

/**
 * API IMPORTS
 */
include_once __DIR__ . '../../api/usersapi.php';

$router = new \Router(new Request);

$headers = apache_request_headers();
if (isset($headers['Authorization'])) {
    $usersAPI = new \UsersAPI();
    $verify = $usersAPI->verifyAuthorization($headers['Authorization']);
    if ($verify == true) {
        //----- USERS API -----/

        $router->get('/proiect2/users', function ($request) {
            $usersAPI = new \UsersAPI();
            return($usersAPI->getAll());
        });

        $router->post('/proiect2/users', function ($request) {
            $usersAPI = new \UsersAPI();
            return json_encode("{test}");
        });
    }
}

//----- LOGIN & REGISTER -----/
$router->post('/proiect2/register', function ($request) {
    $usersAPI = new \UsersAPI();
    return($usersAPI->register());
});

$router->post('/proiect2/login', function ($request) {
    $usersAPI = new \UsersAPI();
    return($usersAPI->login());
});

/**
 * ROUTE DISABLED IF NOT USED
 */
/* include_once __DIR__ . '../../database/999_start_migrations.php';

$router->get('/proiect2/migrate', function ($request) {
    $migration = new \RunMigrations();
    $migration->migrate();
});
 */
