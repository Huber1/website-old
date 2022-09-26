<?php
// https://github.com/miladrahimi/phprouter

use app\controllers\ScriptController;
use app\controllers\PGPController;
use framework\Router;

$router = Router::create();


$router->view('/', 'index', 'home');
$router->view('/impressum', 'impressum');

$router->get('/pgp/?', [PGPController::class, 'index']);
$router->get('/pgp/{email}', [PGPController::class, 'mail']);

$router->group(['prefix' => '/api'], function (Router $router) {
    $router->get('/git/update', [ScriptController::class, 'git_update']);
});

try {
    $router->dispatch();
} catch (\MiladRahimi\PhpRouter\Exceptions\InvalidCallableException|\MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException $e) {
    echo view('404');
}