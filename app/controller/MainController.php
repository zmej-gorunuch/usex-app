<?php

namespace controller;

use core\Controller;
use Exception;

/**
 * Class MainController
 *
 * @package app\controller
 * @author Mazuryk Eugene
 */
class MainController extends Controller {
	/**
	 * Головна сторінка
	 *
	 * @throws Exception
	 */
	public function indexAction() {
		$text = 'Це початковий PHP каркас, призначений для створення веб-ресурсів.';
		$this->view->render( 'home', compact( 'text' ) );
	}

	/**
	 * Відправлення пошти
	 */
	public function sendMail() {

	}
}
