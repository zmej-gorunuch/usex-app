<?php
function debug( $value, $exit = true ) {
	echo '<pre>';
	var_dump( $value );
	echo '</pre>';
	if ( $exit ) {
		exit();
	}
}
