<?php
// https://github.com/miladrahimi/phprouter

use app\controllers\PGPController;

$router = \framework\Router::create();


$router->view('/', 'index', 'home');
$router->view('/impressum', 'impressum');

$router->get('/pgp/?', [PGPController::class, 'index']);
$router->get('/pgp/{email}', [PGPController::class, 'mail']);


try {
    $router->dispatch();
} catch (\MiladRahimi\PhpRouter\Exceptions\InvalidCallableException|\MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException $e) {
    echo view('404');
}