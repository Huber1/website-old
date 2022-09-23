<?php
$exp = explode(DIRECTORY_SEPARATOR, getcwd());
array_pop($exp);
define("ROOT", implode(DIRECTORY_SEPARATOR, $exp));

require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/storage/framework/helpers.php';

$app = new \framework\App();
$app->configureRouting();


//echo view('index.twig', ['name' => 'Moritz']);
