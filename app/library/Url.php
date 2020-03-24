<?php

namespace library;

/**
 * Class Url
 * Бібліотека для роботи з url
 *
 * @package library
 * @author Mazuryk Eugene
 */
class Url {

	/**
	 * Url на головну сторінку
	 *
	 * @return string
	 */
	public static function home() {
		if ( isset( $_SERVER['HTTPS'] ) ) {
			$protocol = ( $_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off" ) ? "https" : "http";
		} else {
			$protocol = 'http';
		}

		return $protocol . "://" . $_SERVER['HTTP_HOST'];
	}

	/**
	 * Формування url адреси
	 *
	 * @param null $url
	 *
	 * @return string
	 */
	public static function link( $url = null) {
		$home = self::home();

		return $home . '/' . $url;
	}

	/**
	 * Перенаправлення
	 *
	 * @param $url
	 * @param bool $permanent
	 */
	public static function redirect( $url = false, $permanent = false ) {
		if ( $url ) {
			header( 'Location: ' . self::link( $url ), true, $permanent ? 301 : 302 );
			exit();
		} else {
			header( 'Location: ' . self::home(), true, $permanent ? 301 : 302 );
			exit();
		}
	}
}