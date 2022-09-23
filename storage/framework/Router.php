<?php

namespace framework;

use MiladRahimi\PhpContainer\Container;
use MiladRahimi\PhpRouter\Publisher\HttpPublisher;
use MiladRahimi\PhpRouter\Publisher\Publisher;
use MiladRahimi\PhpRouter\Routing\Repository;
use Psr\Container\ContainerInterface;

// extends Router class to add custom methods
class Router extends \MiladRahimi\PhpRouter\Router
{
    public function view(string $path, string $view): void
    {
        $this->get($path, function () use ($view) {
            return view($view);
        });
    }

    public static function create(): self
    {
        $container = new Container();
        $container->singleton(Container::class, $container);
        $container->singleton(ContainerInterface::class, $container);
        $container->singleton(Repository::class, new Repository());
        $container->singleton(Publisher::class, HttpPublisher::class);

        return $container->instantiate(Router::class);
    }
}