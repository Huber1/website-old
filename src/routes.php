<?php
// https://github.com/miladrahimi/phprouter

use app\controllers\NewsController;
use app\controllers\PGPController;
use app\controllers\APIController;
use framework\Router;

$router = new Router();
$router->setNamespace("\\app\\controllers");


$router->view('/', 'index', 'home');
$router->view('/impressum', 'impressum');

$router->get('/aktuelles', "NewsController@index");

$router->get('/pgp', "PGPController@index");
$router->get('/pgp/key/{fingerprint}', "PGPController@key");
$router->get('/pgp/{email}', "PGPController@mail");


$router->mount('/api', function() use ($router) {
    $router->all('/git/pull', "APIController@git_pull");
});

$router->set404(function () {
    echo view("404", status: 404);
});

$router->run();