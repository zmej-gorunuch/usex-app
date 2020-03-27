<?php

namespace core;

use Exception;

/**
 * Class View
 * Головний клас виводу
 *
 * @package core
 * @author Mazuryk Eugene
 */
class View {

	protected static $config = []; // Налаштування сайту
	public $layout = 'main'; // Назва головного шаблону
	public $templateExtension = '.php'; // Розширення файлів шаблонів
	public $content; // Вміст рендеру шаблону
	public $topAssets; // Підключення скриптів в head
	public $bottomAssets; // Підключення скриптів перед закриттям body
	public $title; // Заголовок сторінки
	public $description = ''; // Опис сторінки

	public function __construct( $config ) {
		self::$config = $config;
		$this->title  = $config['siteName'];
	}

	public function addTopAssets() {
		$values = [];
		ob_start();
		foreach ( $values as $key => $value ) {
			if ( $key == 'css' ) {
				foreach ( $value as $item ) {
					echo PHP_EOL . '<link rel="stylesheet" href="' . $item . '">';
				}
			}
		}
		foreach ( $values as $key => $value ) {
			if ( $key == 'js' ) {
				foreach ( $value as $item ) {
					echo PHP_EOL . '<script type="text/javascript" src="' . $item . '"></script>';
				}
			}
		}
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Парсинг каркасу шаблону
	 *
	 * @return false|string
	 * @throws Exception
	 */
	private function parseLayout() {
		$path = self::$config['templatePath'] . '/layout/' . $this->layout . $this->templateExtension;
		if ( ! file_exists( $path ) ) {
			throw new Exception( 'Не знайдено головний шаблон ' . $path );
		}

		ob_start();
		include( $path );
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Парсинг шаблону сторінки
	 *
	 * @param $template
	 * @param $values
	 *
	 * @return false|string
	 * @throws Exception
	 */
	private function parseTemplate( $template, $values ) {
		// Формування змінних в шаблоні
		if ( is_array( $values ) && ! empty( $values ) ) {
			extract( $values );
		}
		ob_start();
		// Отримання шаблону сторінки
		if ( $template ) {
			$template = self::$config['templatePath'] . '/' . $template . $this->templateExtension;
			if ( ! file_exists( $template ) ) {
				throw new Exception( 'Файл шаблону "' . $template . '" не знайдено!' );
			}
		} else {
			throw new Exception( 'Не вказано назву шаблону!' );
		}

		include( $template );
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}

	/**
	 * Вивід сторінки 404
	 *
	 * @param string $title
	 * @throws Exception
	 */
	public static function errorPage($title = '404 Not Found') {
		$path = './app/view/404.php';
		if ( ! file_exists( $path ) ) {
			throw new Exception( 'Не знайдено файл сторінки помилки "' . $path . '"' );
		}
		header( $_SERVER["SERVER_PROTOCOL"] . ' ' . $title );
		require $path;
		exit;
	}

	/**
	 * Загальний рендер сторінки
	 *
	 * @param $template
	 * @param $values
	 *
	 * @throws Exception
	 */
	public function render( $template, $values ) {
		$this->content      = $this->parseTemplate( $template, $values );
		$this->topAssets    = $this->addTopAssets();
		$this->bottomAssets = $this->addTopAssets();
		echo $this->parseLayout();
	}
}