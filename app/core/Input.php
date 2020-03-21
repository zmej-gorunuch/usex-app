<?php

namespace app\core;

/**
 * Class Input
 * Клас очистки даних з форм
 *
 * @package app\core
 * @author Mazuryk Eugene
 */
class Input {
	/**
	 * Попередня обробка
	 *
	 * @param $value
	 *
	 * @return string|string[]
	 */
	private static function _prepare( $value ) {
		$value = strval( $value );
		$value = stripslashes( $value );
		$value = str_ireplace( [ "\0", "\a", "\b", "\v", "\e", "\f" ], ' ', $value );
		$value = htmlspecialchars_decode( $value, ENT_QUOTES );

		return $value;
	}

	/**
	 * Логічний тип (false = 0 true = 1)
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return int
	 */
	public static function bool( $value, $default = 0 ) {
		$value = self::_prepare( $value );
		$value = mb_ereg_replace( '[\s]', '', $value );
		$value = str_ireplace( [ '-', '+', 'false', 'null', 'off' ], '', $value );

		return ( empty( $value ) ) ? $default : 1;
	}

	/**
	 * Логічний тип для масиву
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return array
	 */
	public static function boolArray( $value, $default = 0 ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::bool( $row, $default );
		}

		return $res;
	}

	/**
	 * Логічний тип для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param int $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function boolList( $value, $default = 0, $separator = ',' ) {
		return implode( $separator, self::boolArray( $value, $default ) );
	}

	/**
	 * Ціле позитивне число
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return float|int
	 */
	public static function int( $value, $default = 0 ) {
		$value = self::_prepare( $value );
		$value = mb_ereg_replace( '[\s]', '', $value );
		$value = abs( intval( $value ) );

		return ( empty( $value ) ) ? $default : $value;
	}

	/**
	 * Ціле позитивне число для масиву
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return array
	 */
	public static function intArray( $value, $default = 0 ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::int( $row, $default );
		}

		return $res;
	}

	/**
	 * Ціле позитивне число для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param int $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function intList( $value, $default = 0, $separator = ',' ) {
		return implode( $separator, self::intArray( $value, $default ) );
	}

	/**
	 * Число з плаваючою точкою. Може бути негативним
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return float|int
	 */
	public static function float( $value, $default = 0 ) {
		$value = self::_prepare( $value );
		$value = mb_ereg_replace( '[\s]', '', $value );
		$value = str_replace( ',', '.', $value );
		$value = floatval( $value );

		return ( empty( $value ) ) ? $default : $value;
	}

	/**
	 * Число з плаваючою точкою для масиву
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return array
	 */
	public static function floatArray( $value, $default = 0 ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::float( $row, $default );
		}

		return $res;
	}

	/**
	 * Число з плаваючою точкою для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param int $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function floatList( $value, $default = 0, $separator = ',' ) {
		return implode( $separator, self::floatArray( $value, $default ) );
	}

	/**
	 * Ціна
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return int|string|string[]
	 */
	public static function price( $value, $default = 0 ) {
		$value = self::_prepare( $value );
		$value = mb_ereg_replace( '[^0-9\.,]', '', $value );
		$value = mb_ereg_replace( '[,]+', ',', $value );
		$value = mb_ereg_replace( '[.]+', '.', $value );
		$pos_1 = mb_strpos( $value, '.' );
		$pos_2 = mb_strpos( $value, ',' );
		if ( $pos_1 && $pos_2 ) {
			$value = mb_substr( $value . '00', 0, $pos_1 + 3 );
			$value = str_replace( ',', '', $value );
		} elseif ( $pos_1 ) {
			$value = mb_substr( $value . '00', 0, $pos_1 + 3 );
		} elseif ( $pos_2 ) {
			if ( ( mb_strlen( $value ) - $pos_2 ) == 3 ) {
				$value = str_replace( ',', '.', $value );
			} else {
				$value = str_replace( ',', '', $value ) . '.00';
			}
		} elseif ( mb_strlen( $value ) == 0 ) {
			return $default;
		} else {
			$value = $value . '.00';
		}

		return ( $value == '0.00' ) ? 0 : $value;
	}

	/**
	 * Ціна для масиву
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return array
	 */
	public static function priceArray( $value, $default = 0 ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::price( $row, $default );
		}

		return $res;
	}

	/**
	 * Ціна для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param int $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function priceList( $value, $default = 0, $separator = ',' ) {
		return implode( $separator, self::priceArray( $value, $default ) );
	}

	/**
	 * Текст
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return string
	 */
	public static function text( $value, $default = '' ) {
		$value = self::_prepare( $value );
		$value = str_ireplace( [ "\t" ], ' ', $value );
		$value = preg_replace( [
			'@<!--.*?-->@s',
			'@/\*(.*?)\*/@sm',
			'@<([?%]) .*? \\1>@sx',
			'@<!\[CDATA\[.*?]]>@sx',
			'@<!\[.*?]>.*?<!\[.*?]>@sx',
			'@\s--.*@',
			'@<script[^>]*?>.*?</script>@si',
			'@<style[^>]*?>.*?</style>@siU',
			'@<[/!]*?[^<>]*?>@si',
		], ' ', $value );
		$value = strip_tags( $value );
		$value = str_replace( [ '/*', '*/', ' --', '#__' ], ' ', $value );
		$value = mb_ereg_replace( '[ ]+', ' ', $value );
		$value = trim( $value );
		$value = htmlspecialchars( $value, ENT_QUOTES );

		return ( mb_strlen( $value ) == 0 ) ? $default : $value;
	}

	/**
	 * Текст для масиву
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return array
	 */
	public static function textArray( $value, $default = '' ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::text( $row, $default );
		}

		return $res;
	}

	/**
	 * Текст для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param string $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function textList( $value, $default = '', $separator = ',' ) {
		return implode( $separator, self::textArray( $value, $default ) );
	}

	/**
	 * Рядок
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return string
	 */
	public static function str( $value, $default = '' ) {
		$value = self::text( $value );
		$value = str_ireplace( [ "\r", "\n" ], ' ', $value );
		$value = mb_ereg_replace( '[\s]+', ' ', $value );
		$value = trim( $value );

		return ( mb_strlen( $value ) == 0 ) ? $default : $value;
	}

	/**
	 * Рядок для масиву
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return array
	 */
	public static function strArray( $value, $default = '' ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::str( $row, $default );
		}

		return $res;
	}

	/**
	 * Рядок для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param string $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function strList( $value, $default = '', $separator = ',' ) {
		return implode( $separator, self::strArray( $value, $default ) );
	}

	/**
	 * HTML
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return string
	 */
	public static function html( $value, $default = '' ) {
		$value = self::_prepare( $value );
		$value = mb_ereg_replace( '[ ]+', ' ', $value );
		$value = trim( $value );
		$value = addslashes( $value );

		return ( mb_strlen( $value ) == 0 ) ? $default : $value;
	}

	/**
	 * HTML для масиву
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return array
	 */
	public static function htmlArray( $value, $default = '' ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::html( $row, $default );
		}

		return $res;
	}

	/**
	 * Транслітерація
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return false|string
	 */
	public static function transliteration( $value, $default = '' ) {
		$value = self::str( $value, '' );
		if ( empty( $value ) ) {
			$value = $default;
		}
		$value     = mb_strtolower( $value );
		$converter = [
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'h',
			'ґ' => 'g',
			'д' => 'd',
			'е' => 'e',
			'є' => 'ie',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'y',
			'і' => 'i',
			'ї' => 'i',
			'й' => 'i',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'kh',
			'ц' => 'ts',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'shch',
			'ь' => '',
			'ю' => 'іu',
			'я' => 'ia',
		];
		$value     = strtr( $value, $converter );
		$value     = mb_ereg_replace( '[^-0-9a-z]', '-', $value );
		$value     = mb_ereg_replace( '[-]+', '-', $value );
		$value     = trim( $value, '-' );

		return $value;
	}

	/**
	 * Транслітерація для масиву
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return array
	 */
	public static function transliterationArray( $value, $default = '' ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::transliteration( $row, $default );
		}

		return $res;
	}

	/**
	 * Транслітерація для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param string $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function sefList( $value, $default = '', $separator = ',' ) {
		return implode( $separator, self::transliterationArray( $value, $default ) );
	}

	/**
	 * Назва файлу
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return false|string
	 */
	public static function filename( $value, $default = '' ) {
		$value = self::str( $value, $default );
		$value = str_replace( [ '/', '|', '\\', '?', ':', ';', '\'', '"', '<', '>', '*' ], '', $value );
		$value = mb_ereg_replace( '[.]+', '.', $value );

		return ( mb_strlen( $value ) == 0 ) ? $default : $value;
	}

	/**
	 * Назва файлу для масиву
	 *
	 * @param $value
	 * @param string $default
	 *
	 * @return array
	 */
	public static function filenameArray( $value, $default = '' ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::filename( $row, $default );
		}

		return $res;
	}

	/**
	 * Назва файлу для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param string $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function filenameList( $value, $default = '', $separator = ',' ) {
		return implode( $separator, self::filenameArray( $value, $default ) );
	}

	/**
	 * Unix timestamp
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return false|int
	 */
	public static function time( $value, $default = 0 ) {
		$value = self::str( $value, $default );
		$value = strtotime( $value );

		return ( empty( $value ) ) ? $default : $value;
	}

	/**
	 * Unix timestamp для масиву
	 *
	 * @param $value
	 * @param int $default
	 *
	 * @return array
	 */
	public static function timeArray( $value, $default = 0 ) {
		$res = [];
		foreach ( (array) $value as $row ) {
			$res[] = self::time( $row, $default );
		}

		return $res;
	}

	/**
	 * Unix timestamp для масиву, результат об'єднаний в рядок
	 *
	 * @param $value
	 * @param int $default
	 * @param string $separator
	 *
	 * @return string
	 */
	public static function timeList( $value, $default = 0, $separator = ',' ) {
		return implode( $separator, self::timeArray( $value, $default ) );
	}
}
