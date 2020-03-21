<?php

use app\core\Url;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*** Configuration ***/
require_once 'app/config.php';

/*** Autoload classes ***/
require_once 'app/autoload.php';
require_once 'vendor/autoload.php';

/*** Routing ***/
$router = new Url();
require 'app/routs.php';
$router->router( $routes );
