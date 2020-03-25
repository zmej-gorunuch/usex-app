<?php

use core\Router;

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

require_once( __DIR__ . '/app/debug.php' );

/*** Configuration ***/
require_once './app/config.php';

/*** Autoload classes ***/
require_once( __DIR__ . '/vendor/autoload.php' );

//$config = array_merge(
//	require( __DIR__ . '/app/config.php' )
//);

session_start();

/*** Run application ***/
$router = new Router();
try {
	$router->run();
} catch ( Exception $e ) {
	echo $e;
}
