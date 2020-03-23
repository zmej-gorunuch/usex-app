<?php

namespace core;

use Exception;

/**
 * Class App
 *
 * @package app\core
 * @author Mazuryk Eugene
 */
class App {

	public $config = [];

	/**
	 * Запуск головного класу
	 *
	 * @param array $config
	 *
	 * @throws Exception
	 */
	public static function run( $config = [] ) {
		$router = new Url();
		$router->router( $config['routes'] );
	}
}