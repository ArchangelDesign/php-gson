<?php

/**
 * PHPGson Library
 * Simple entity mapper for PHP applications
 * with minimum requirements and dependencies
 *
 * @author Rafal Martinez-Marjanski
 * @package PHPGson
 * @license MIT
 */

spl_autoload_register(function ($class) {
    if (class_exists($class))
        return;
    $directory = __DIR__ . '/';
    $path = $directory . str_replace("\\", '/', $class) . '.php';
    if (file_exists($path))
        return include $path;
});