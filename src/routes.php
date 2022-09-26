<?php
// https://github.com/miladrahimi/phprouter

use app\controllers\PGPController;
use app\controllers\ScriptController;
use framework\Router;

$router = Router::create();


$router->view('/', 'index', 'home');
$router->view('/impressum', 'impressum');

$router->get('/pgp/?', [PGPController::class, 'index']);
$router->get('/pgp/{email}', [PGPController::class, 'mail']);

$router->group(['prefix' => '/api'], function (Router $router) {
    $router->any('/git/pull', [ScriptController::class, 'git_pull']);
});

try {
    $router->dispatch();
} catch (\MiladRahimi\PhpRouter\Exceptions\InvalidCallableException|\MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException $e) {
    header("HTTP/1.0 404 Not Found");
    echo view('404');
}