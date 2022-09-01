<?php
$exp = explode(DIRECTORY_SEPARATOR, getcwd());
array_pop($exp);
define("ROOT", implode(DIRECTORY_SEPARATOR, $exp));

require ROOT . '/framework/autoloader.php';

view('index');