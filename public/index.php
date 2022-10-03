<?php
$exp = explode(DIRECTORY_SEPARATOR, getcwd());
array_pop($exp);
define("ROOT", realpath(implode(DIRECTORY_SEPARATOR, $exp)));

require_once ROOT . '/vendor/autoload.php';
require_once ROOT . '/storage/framework/helpers.php';

$app = new \framework\App();
$app->configureRouting();