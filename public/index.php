<?php
$exp = explode(DIRECTORY_SEPARATOR, getcwd());
array_pop($exp);
define("ROOT", implode(DIRECTORY_SEPARATOR, $exp));

require_once ROOT . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader(ROOT . '/src/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => ROOT . '/twig_cache',
]);

echo $twig->render('index.twig', ['name' => 'Moritz']);