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

	public function __construct() {
		$this->view = new View();
	}
}