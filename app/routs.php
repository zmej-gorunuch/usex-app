<?php
$routes = [
	[ 'GET', '/', 'MainController@index', 'index' ],
	[ 'GET', '/form', 'MainController@form', 'form' ],
	[ 'GET', '/privacy', 'MainController@privacy', 'privacy' ],
	[ 'POST', '/mail', 'MainController@mail', 'mail' ],
];
