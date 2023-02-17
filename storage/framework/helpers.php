<?php

function env(string $key): string|null
{
    return \framework\Env::get($key);
}

function run_script(string $name, ...$params): bool|string|null
{
    $script_location = realpath(ROOT . "/storage/scripts/$name.sh");
    if (!file_exists(realpath($script_location))) return false;
    $params = implode(" ", $params);
    return shell_exec("sh $script_location $params");
}

function getClassName(string $class): string
{
    $exp = explode("\\", $class);
    return end($exp);
}

function isAssociativeArray(array $array): bool
{
    if ([] == $array) {
        return false;
    }
    return array_keys($array) !== range(0, count($array) - 1);
}

function view(string $view, array $data = [], int $status = 200): string
{
    $loader = new \Twig\Loader\FilesystemLoader(ROOT . '/src/views');
    if (env('MODE') == 'DEVELOPMENT')
        $twig = new \Twig\Environment($loader);
    else
        $twig = new \Twig\Environment($loader, [
            'cache' => ROOT . '/storage/cache/twig'
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

function clear_cache(): void
{
    $dir = realpath(ROOT . "/storage/cache");

    $it = new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS);
    $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        if ($file->isDir())
            rmdir($file->getRealPath());
        else
            unlink($file->getRealPath());
    }
    rmdir($dir);
}