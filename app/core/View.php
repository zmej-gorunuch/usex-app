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

	/** @var string назва головного шаблону */
	public $layout = 'main';
	/** @var string назва шаблону помилки */
	public $error = '404';
	/** @var string Шлях до папки з шаблонами */
	public $templatePath = 'app/view/';
	/** @var string Розширення файлів шаблонів */
	public $templateExtension = '.php';
	/** Вміст рендеру шаблону */
	public $content;
	/** Підключення скриптів в head */
	public $topAssets;
	/** Підключення скриптів перед закриттям body */
	public $bottomAssets;

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
		$path = 'app/view/layout/' . $this->layout . $this->templateExtension;
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
			$template = $this->templatePath . $template . $this->templateExtension;
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

	public function getError() {
		return $this->error;
	}

	/**
	 * Вивід сторінки 404
	 *
	 * @throws Exception
	 */
	public static function errorPage() {
		$path = 'app/view/404.php';
		if ( ! file_exists( $path ) ) {
			throw new Exception( 'Не знайдено файл сторінки помилки "' . $path . '"' );
		}
		header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found' );
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