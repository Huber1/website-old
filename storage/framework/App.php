<?php

namespace framework;

class App
{
    public function __construct()
    {
        Env::parse();
    }

    public function configureRouting(): void
    {
        include_once ROOT . '/src/routes.php';
    }
}