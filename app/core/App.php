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

	public $router;

	/**
	 * Запуск головного класу
	 *
	 * @param array $config
	 *
	 * @throws Exception
	 */
	public function run( $config = [] ) {
		$this->router = new Url();
		$this->router->router( $config['routes'] );
	}
}