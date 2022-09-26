<?php

if (!function_exists('run_script')) {
    /**
     * @param string $name
     * @param ...$params
     * @return bool|string|null
     */
    function run_script(string $name, ...$params): bool|string|null
    {
        $script_location = realpath(ROOT . "/storage/scripts/$name.sh");
        if (!file_exists(realpath($script_location))) return false;
        $params = implode(" ", $params);
        return shell_exec("sh $script_location $params");
    }
}

if (!function_exists('view')) {
    /**
     * @param string $view without file ending
     * @param array $data
     * @param int $status
     * @return string
     */
    function view(string $view, array $data = [], int $status = 200): string
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT . '/src/views');
        $twig = new \Twig\Environment($loader, [
//            'cache' => ROOT . '/twig_cache',
        ]);
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);
        if (!str_ends_with($view, '.twig'))
            $view .= '.twig';

        http_response_code($status);

        try {
            return $twig->render($view, $data);
        } catch (\Twig\Error\LoaderError|\Twig\Error\RuntimeError|\Twig\Error\SyntaxError $e) {
            return view('404', status: 404);
        }
    }
}