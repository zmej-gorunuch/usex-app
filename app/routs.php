<?php
/**
 * Формат:
 *  ['GET|POST|PATCH|PUT|DELETE', 'url шлях', 'контролер@метод', 'назва']
 */
return [
	[ 'GET', '/', 'MainController@index', 'index' ],
	[ 'POST', '/mail', 'MainController@mail', 'mail' ],
];
