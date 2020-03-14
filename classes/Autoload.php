<?php

class inWidgetAutoloader
{
	private static $_lastLoadedFilename;
	public static function loadPackages($className)
	{
		$className = str_replace("\\", "/", $className);
		$pathParts = explode('_', $className);
		self::$_lastLoadedFilename = implode('/', $pathParts) . '.php';
		require_once(__DIR__.'/'.self::$_lastLoadedFilename);
	}
}
spl_autoload_register(array('inWidgetAutoloader', 'loadPackages'));