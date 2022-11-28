<?php

namespace framework;

class App
{
    public function __construct()
    {
        Env::parse();
        header("X-Robots-Tag: noindex");
    }

    public function configureRouting(): void
    {
        include_once ROOT . '/src/routes.php';
    }
}