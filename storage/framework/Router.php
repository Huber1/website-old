<?php

namespace framework;

// extends Router class to add custom methods
class Router extends \Bramus\Router\Router
{
    public function view(string $path, string $view, string $activeTab = null): void
    {
        $this->get($path, function () use ($activeTab, $view) {
            echo view($view, ['tab' => $activeTab]);
        });
    }
}