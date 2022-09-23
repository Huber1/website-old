<?php


if (!function_exists('view')) {
    /**
     * @param string $view
     * @param array $data
     * @return string
     */
    function view(string $view, array $data = []): string
    {
        $loader = new \Twig\Loader\FilesystemLoader(ROOT . '/src/templates');
        $twig = new \Twig\Environment($loader, [
//            'cache' => ROOT . '/twig_cache',
        ]);
        if (!str_ends_with($view, '.twig'))
            $view .= '.twig';

        try {
            return $twig->render($view, $data);
        } catch (\Twig\Error\LoaderError|\Twig\Error\RuntimeError|\Twig\Error\SyntaxError $e) {
            return view('404');
        }
    }
}