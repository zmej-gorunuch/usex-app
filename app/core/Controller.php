<?php

namespace core;

use Exception;

/**
 * Class Controller
 * Головний клас контроллерів
 *
 * @package core
 * @author Mazuryk Eugene
 */
class Controller extends App {

	private $view;
	private $model;

	/**
	 * Рендеринг сторінки
	 *
	 * @param $template
	 * @param $values
	 *
	 * @throws Exception
	 */
	public function render( $template, $values ) {
		$this->view  = new View();
		$this->view->render( $template, $values );
	}
}