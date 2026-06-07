<?php

declare(strict_types=1);

session_start();

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', ROOT_PATH . '/app');

require_once APP_PATH . '/Config/Database.php';
require_once APP_PATH . '/Core/Router.php';
require_once APP_PATH . '/Core/Controller.php';
require_once APP_PATH . '/Core/Model.php';
require_once APP_PATH . '/Core/Pagination.php';

spl_autoload_register(static function (string $class): void {
    $paths = [
        APP_PATH . '/Controllers/' . $class . '.php',
        APP_PATH . '/Models/' . $class . '.php',
        APP_PATH . '/Services/' . $class . '.php',
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

$router = new Router();

$router->get('/', 'HomeController', 'index');
$router->get('/instructeurs', 'InstructeurController', 'index');
$router->get('/instructeurs/voertuigen', 'InstructeurController', 'voertuigen');
$router->post('/instructeurs/voertuigen/verwijder', 'InstructeurController', 'verwijderVoertuig');
$router->get('/voertuigen', 'VoertuigController', 'index');
$router->post('/voertuigen/verwijder', 'VoertuigController', 'verwijder');

$router->dispatch();
