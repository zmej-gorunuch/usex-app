<?php

namespace app\controller;

/**
 * Class MainController
 *
 * @package app\controller
 * @author Mazuryk Eugene
 */
class MainController {
	/**
	 * Головна сторінка
	 */
	public function index() {
		require_once 'app/view/home.php';
	}

	/**
	 * Відправлення пошти
	 */
	public function sendMail() {

	}
}
