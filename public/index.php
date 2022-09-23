<?php
$exp = explode(DIRECTORY_SEPARATOR, getcwd());
array_pop($exp);
define("ROOT", implode(DIRECTORY_SEPARATOR, $exp));

require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/framework/helpers.php';

$loader = new \Twig\Loader\FilesystemLoader(ROOT . '/src/templates');
$twig = new \Twig\Environment($loader, [
//    'cache' => ROOT . '/twig_cache',
]);

$app = new \framework\App();
$app->configureRouting();


//echo view('index.twig', ['name' => 'Moritz']);
