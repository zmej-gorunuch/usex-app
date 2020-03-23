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
	/** @var string Головний файл шаблону */
	public $templateLayout = 'app/view/layout/main.php';
	/** @var string Шлях до папки з шаблонами */
	public $templatePath = 'app/view/';
	/** @var string Розширення файлів шаблонів */
	public $templateExtension = '.php';
	/** @var array Вміст рендеру шаблону */
	public $content = [];

	/**
	 * Парсинг каркасу шаблону
	 *
	 * @return false|string
	 */
	public function parseLayout() {
		ob_start();
		include( $this->templateLayout );
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
	public function parseTemplate( $template, $values ) {
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

	/**
	 * Загальний рендер сторінки
	 *
	 * @param $template
	 * @param $values
	 *
	 * @throws Exception
	 */
	public function render( $template, $values ) {
		$this->content = $this->parseTemplate( $template, $values );
		echo $this->parseLayout();
	}
}