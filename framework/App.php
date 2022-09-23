<?php

namespace framework;

class App
{
    public function __construct()
    {
        define('ENVIRONMENT', parse_ini_file(ROOT . '/.env'));
    }

    public function configureRouting(): void
    {
        include_once ROOT . '/src/routes.php';
    }
}