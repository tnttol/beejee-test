<?php

use App\Component\Auth;
use App\Component\Config;
use App\Component\Model;
use App\Component\Router;

error_reporting(E_ALL);
set_error_handler('App\Component\Error::errorHandler');
set_exception_handler('App\Component\Error::exceptionHandler');

Config::$ROOT_DIR = dirname(__DIR__);

$users = include(Config::$ROOT_DIR . '/config/users.php');
Auth::setUsers($users);

$config = include(Config::$ROOT_DIR . '/config/db.php');
Model::setConfig($config);

$routes = include(Config::$ROOT_DIR . '/config/routes.php');
(new Router($routes))->run();
