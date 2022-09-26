<?php

if (!function_exists('view')) {
    /**
     * @param string $view without file ending
     * @param array $data
     * @return string
     */
    function view(string $view, array $data = [], $status = 200): string
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