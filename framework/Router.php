<?php

namespace framework;

// https://github.com/phprouter/main/blob/main/router.php

class Router
{
    static function get(string $route, $function): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            self::route($route, $function);
        }
    }

    static function route(string $route, $function): void
    {
        $request_url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);
        $request_url = rtrim($request_url, '/');
        $request_url = strtok($request_url, '?');
        $route_parts = explode('/', $route);
        $request_url_parts = explode('/', $request_url);
        array_shift($route_parts);
        array_shift($request_url_parts);

        if ($route_parts[0] == '' && count($request_url_parts) == 0) {
            call_user_func($function);
            exit();
        }
        if (count($route_parts) != count($request_url_parts)) {
            return;
        }
        $parameters = [];
        for ($i = 0; $i < count($route_parts); $i++) {
            $route_part = $route_parts[$i];
            if (preg_match("/^[$]/", $route_part)) {
                $route_part = ltrim($route_part, '$');
                $parameters[] = $request_url_parts[$i];
                $$route_part = $request_url_parts[$i];
            } elseif ($route_parts[$i] != $request_url_parts[$i])
                return;
        }
        if (is_callable($function)) {
            call_user_func($function);
            exit();
        }
    }

}