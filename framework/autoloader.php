<?php

require ROOT . '/framework/helpers.php';

function autoloader($class_name): void
{
    $file = ROOT . '/' . $class_name . '.php';
    if (file_exists($file))
        require_once $file;
}

spl_autoload_register('autoloader');