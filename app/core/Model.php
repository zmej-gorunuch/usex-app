<?php

namespace core;

/**
 * Class Model
 * Головний клас моделей
 *
 * @package core
 * @author Mazuryk Eugene
 */
class Model {

	/** @var array Налаштування сайту */
	protected $config = [];

	public function __construct( $config ) {
		$this->config = $config;
	}

}