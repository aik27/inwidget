<?php

class InWidgetAutoloader
{
    private static $lastLoadedFilename;

    public static function loadPackages($className)
    {
        $className = str_replace("\\", "/", $className);
        $pathParts = explode('_', $className);
        self::$lastLoadedFilename = implode('/', $pathParts) . '.php';
        require_once(__DIR__ . '/' . self::$lastLoadedFilename);
    }
}

spl_autoload_register(array('InWidgetAutoloader', 'loadPackages'));
