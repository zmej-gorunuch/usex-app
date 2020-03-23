<?php
/**
 * Формат:
 *   $routes = [
 *      ['GET|POST|PATCH|PUT|DELETE', 'url шлях', 'контролер@метод', 'назва']
 *   ];
 */
return [
	'routes' => [
		[ 'GET', '/', 'MainController@index', 'index' ],
		[ 'POST', '/mail', 'MainController@mail', 'mail' ],
	],
];
