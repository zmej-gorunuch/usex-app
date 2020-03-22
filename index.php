<?php

use core\App;

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );
error_reporting( E_ALL );

/*** Configuration ***/
require_once 'app/config.php';

/*** Autoload classes ***/
//require_once 'app/autoload.php';
require_once( __DIR__ . '/vendor/autoload.php' );

$config = array_merge(
	require( __DIR__ . '/app/config.php' ),
	require( __DIR__ . '/app/routs.php' )
);

/*** Run application ***/
$application = new App();
$application->run( $config );
