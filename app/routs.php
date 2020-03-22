<?php
return [
	'routes' => [
		[ 'GET', '/', 'MainController@index', 'index' ],
		[ 'POST', '/mail', 'MainController@mail', 'mail' ],
	],
];
