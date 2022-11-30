<?php
// https://github.com/miladrahimi/phprouter

use app\controllers\AktuellesController;
use app\controllers\PGPController;
use app\controllers\APIController;
use framework\Router;

$router = Router::create();


$router->view('/', 'index', 'home');
$router->view('/impressum', 'impressum');

$router->get('/aktuelles', [AktuellesController::class, 'index']);

$router->get('/pgp/?', [PGPController::class, 'index']);
$router->get('/pgp/key/{fingerprint}', [PGPController::class, 'key']);
$router->get('/pgp/{email}', [PGPController::class, 'mail']);

$router->group(['prefix' => '/api'], function (Router $router) {
    $router->any('/git/pull', [APIController::class, 'git_pull']);
});

try {
    $router->dispatch();
} catch (\MiladRahimi\PhpRouter\Exceptions\InvalidCallableException|\MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException $e) {
    echo view('404', status: 404);
}