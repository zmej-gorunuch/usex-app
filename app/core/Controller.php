<?php

namespace core;

/**
 * Class Controller
 * Головний клас контроллерів
 *
 * @package core
 * @author Mazuryk Eugene
 */
class Controller {

	public $view;
	public $model;
	protected $config = []; // Налаштування сайту

	public function __construct() {
		$this->config = require( './app/config.php' );
		$this->view = new View($this->config);
		$this->model = new Model($this->config);
	}
}