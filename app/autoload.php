<?php
spl_autoload_register(function ($className) {
    if (strpos($className, 'Controller') !== false) {
        if (strpos($className, '\\') == false) {
            $file = dirname(__DIR__).'\\app\\controller\\'.$className.'.php';
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        } else {
            $file = dirname(__DIR__).'\\'.$className.'.php';
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        }
    } else {
        if (strpos($className, '\\') == false) {
            $file = dirname(__DIR__).'\\app\\core\\'.$className.'.php';
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        } else {
            $file = dirname(__DIR__).'\\'.$className.'.php';
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        }
    }

    if (file_exists($file)) {
        include_once $file;
    }
});
