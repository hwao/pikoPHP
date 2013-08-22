<?php


spl_autoload_register(function ($className) {
    $fileName = str_replace('_', '/', $className);
    $filePath = __DIR__ . '/' . $fileName . '.php';

    if (file_exists($filePath)) {
        include $filePath;

        return true;
    }
    return false;
});