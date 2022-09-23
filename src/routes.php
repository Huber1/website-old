<?php

$router = \MiladRahimi\PhpRouter\Router::create();

$router->get('/', function () {
    return view('index');
});

try {
    $router->dispatch();
} catch (\MiladRahimi\PhpRouter\Exceptions\InvalidCallableException|\MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException $e) {
    echo view('404');
}