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
	public $rout;
	public $config;

	public function __construct() {
		$this->view = new View();
		$this->model = new Model();
	}
}