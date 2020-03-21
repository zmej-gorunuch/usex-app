<?php

namespace app\core;

use Exception;
use Traversable;

/**
 * Class Url
 * Клас для роботи з url
 *
 * @package app\core
 * @author Mazuryk Eugene
 */
class Url {
	public $controllerSeparator = 'Controller';
	public $actionSeparator = '@';
	protected $className;
	protected $classAction;
	protected $routes = [];
	protected $namedRoutes = [];
	protected $basePath = '';
	protected $matchTypes = [
		'i'  => '[0-9]++',
		'a'  => '[0-9A-Za-z]++',
		'h'  => '[0-9A-Fa-f]++',
		'*'  => '.+?',
		'**' => '.++',
		''   => '[^/\.]++',
	];

	/**
	 * Створення маршрутизатора за один виклик з конфігурації
	 *
	 * @param array $routes
	 * @param string $basePath
	 * @param array $matchTypes
	 *
	 * @throws Exception
	 */
	public function __construct( $routes = [], $basePath = '', $matchTypes = [] ) {
		$this->addRoutes( $routes );
		$this->setBasePath( $basePath );
		$this->addMatchTypes( $matchTypes );
	}

	/**
	 * Додавання маршрутів із масиву
	 *
	 * Формат:
	 *   $routes = array(
	 *      array($method, $route, $target, $name)
	 *   );
	 *
	 * @param array $routes
	 *
	 * @return void
	 * @throws Exception
	 */
	public function addRoutes( $routes ) {
		if ( ! is_array( $routes ) && ! $routes instanceof Traversable ) {
			throw new Exception( 'Маршрути повинні бути масивом або екземпляром Traversable' );
		}
		foreach ( $routes as $route ) {
			call_user_func_array( [ $this, 'map' ], $route );
		}
	}

	/**
	 * Встановити базовий шлях
	 * Якщо програма запускається з підкаталогу
	 *
	 * @param $basePath
	 */
	public function setBasePath( $basePath ) {
		$this->basePath = $basePath;
	}

	/**
	 * Додати названі типи відповідності. Він використовує array_merge, тому ключі можна перезаписати
	 *
	 * @param array $matchTypes
	 */
	public function addMatchTypes( $matchTypes ) {
		$this->matchTypes = array_merge( $this->matchTypes, $matchTypes );
	}

	/**
	 * Спрямування маршрут до цілі
	 *
	 * @param string $method
	 * @param string $route
	 * @param mixed $target
	 * @param string $name
	 *
	 * @throws Exception
	 */
	public function map( $method, $route, $target, $name = null ) {

		$this->routes[] = [ $method, $route, $target, $name ];

		if ( $name ) {
			if ( isset( $this->namedRoutes[ $name ] ) ) {
				throw new Exception( "Неможливо змінити маршрут '{$name}'" );
			} else {
				$this->namedRoutes[ $name ] = $route;
			}

		}

		return;
	}

	/**
	 * Url сайту
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
	 * Зворотна маршрутизація
	 *
	 * @param string $routeName
	 * @param array $params
	 *
	 * @return string
	 * @throws Exception
	 */
	public function generate( $routeName, array $params = [] ) {

		// Перевірка чи існує названий маршрут
		if ( ! isset( $this->namedRoutes[ $routeName ] ) ) {
			throw new Exception( "Route '{$routeName}' does not exist." );
		}

		// Заміна названих параметрів
		$route = $this->namedRoutes[ $routeName ];

		// додаємо базовий шлях до URL-адреси маршруту
		$url = $this->basePath . $route;

		if ( preg_match_all( '`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?](\?|)`', $route, $matches, PREG_SET_ORDER ) ) {

			foreach ( $matches as $match ) {
				list( $block, $pre, $param, $optional ) = $match;

				if ( $pre ) {
					$block = substr( $block, 1 );
				}

				if ( isset( $params[ $param ] ) ) {
					$url = str_replace( $block, $params[ $param ], $url );
				} elseif ( $optional ) {
					$url = str_replace( $pre . $block, '', $url );
				}
			}

		}

		return $url;
	}

	/**
	 * Звіряємо URL-адресу запиту із збереженими маршрутами
	 *
	 * @param string $requestUrl
	 * @param string $requestMethod
	 *
	 * @return array|boolean
	 */
	public function match( $requestUrl = null, $requestMethod = null ) {

		$params = [];

		// Встановити Request URL, якщо він не переданий як параметр
		if ( $requestUrl === null ) {
			$requestUrl = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '/';
		}

		// Базовий шлях URL-адреси запиту
		$requestUrl = substr( $requestUrl, strlen( $this->basePath ) );

		// Отримання параметрів (? A = b) з URL-адреси запиту
		if ( ( $strpos = strpos( $requestUrl, '?' ) ) !== false ) {
			$requestUrl = substr( $requestUrl, 0, $strpos );
		}

		// Встановити метод запиту, якщо він не передається як параметр
		if ( $requestMethod === null ) {
			$requestMethod = isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		}

		// Привести запит до Guiding Principles
		$_REQUEST = array_merge( $_GET, $_POST );

		foreach ( $this->routes as $handler ) {
			list( $method, $_route, $target, $name ) = $handler;

			$methods      = explode( '|', $method );
			$method_match = false;

			// Перевірка чи збігається метод запиту. Якщо ні, то відмінити (CHEAP)
			foreach ( $methods as $method ) {
				if ( strcasecmp( $requestMethod, $method ) === 0 ) {
					$method_match = true;
					break;
				}
			}

			// Метод не збігся, продовжуєм наступний маршрут
			if ( ! $method_match ) {
				continue;
			}

			// Перевірка наявності підстановки (matches all)
			if ( $_route === '*' ) {
				$match = true;
			} elseif ( isset( $_route[0] ) && $_route[0] === '@' ) {
				$match = preg_match( '`' . substr( $_route, 1 ) . '`u', $requestUrl, $params );
			} else {
				$route = null;
				$regex = false;
				$j     = 0;
				$n     = isset( $_route[0] ) ? $_route[0] : null;
				$i     = 0;

				// Знаходимо найдовшу non-regex і порівняйте її з URI
				while ( true ) {
					if ( ! isset( $_route[ $i ] ) ) {
						break;
					} elseif ( false === $regex ) {
						$c     = $n;
						$regex = $c === '[' || $c === '(' || $c === '.';
						if ( false === $regex && false !== isset( $_route[ $i + 1 ] ) ) {
							$n     = $_route[ $i + 1 ];
							$regex = $n === '?' || $n === '+' || $n === '*' || $n === '{';
						}
						if ( false === $regex && $c !== '/' && ( ! isset( $requestUrl[ $j ] ) || $c !== $requestUrl[ $j ] ) ) {
							continue 2;
						}
						$j ++;
					}
					$route .= $_route[ $i ++ ];
				}

				$regex = $this->compileRoute( $route );
				$match = preg_match( $regex, $requestUrl, $params );
			}

			if ( ( $match == true || $match > 0 ) ) {

				if ( $params ) {
					foreach ( $params as $key => $value ) {
						if ( is_numeric( $key ) ) {
							unset( $params[ $key ] );
						}
					}
				}

				return [
					'target' => $target,
					'params' => $params,
					'name'   => $name,
				];
			}
		}

		return false;
	}

	/**
	 * Компілювання регулярного виразу для заданого маршруту (EXPENSIVE)
	 *
	 * @param $route
	 *
	 * @return string
	 */
	private function compileRoute( $route ) {
		if ( preg_match_all( '`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?](\?|)`', $route, $matches, PREG_SET_ORDER ) ) {

			$matchTypes = $this->matchTypes;
			foreach ( $matches as $match ) {
				list( $block, $pre, $type, $param, $optional ) = $match;

				if ( isset( $matchTypes[ $type ] ) ) {
					$type = $matchTypes[ $type ];
				}
				if ( $pre === '.' ) {
					$pre = '\.';
				}

				// Стара версія PCRE параметр 'P' (?P<named>)
				$pattern = '(?:'
				           . ( $pre !== '' ? $pre : null )
				           . '('
				           . ( $param !== '' ? "?P<$param>" : null )
				           . $type
				           . '))'
				           . ( $optional !== '' ? '?' : null );

				$route = str_replace( $block, $pattern, $route );
			}

		}

		return "`^$route$`u";
	}

	/**
	 * Підключення роутів
	 *
	 * @param array $routes 'app/routs.php'
	 *
	 * @throws Exception
	 */
	public function router( array $routes ) {
		// Додаю всі створені роути
		$this->addRoutes( $routes );

		// Отримую контролери та методи
		$match = $this->match();

		if ( is_array( $match )
		     && strpos( $match['target'], $this->controllerSeparator ) !== false
		) {
			$this->className   = strstr( $match['target'], $this->actionSeparator,
				true );
			$this->classAction = substr( strrchr( $match['target'],
				$this->actionSeparator ), 1 );
		}
		// Перевірка на namespace
		if ( method_exists( '\\app\\controller\\' . $this->className,
			$this->classAction )
		) {
			$this->className = '\\app\\controller\\' . $this->className;
			$this->className = str_replace( '\\', DIRECTORY_SEPARATOR,
				$this->className );
		}

		// Спрямовую на відповідний контролер
		if ( method_exists( $this->className, $this->classAction ) ) {
			call_user_func_array( [
				new $this->className,
				$this->classAction,
			], $match['params'] );
		} else {
			// 404
			header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found' );
			require( 'app/view/404.php' );
		}
	}
}
