<?php
/**
 * Set up all the required files that need to be loaded when Fizz
 * is loaded as a bundle.
 */
Laravel\Autoloader::namespaces(array(
	'Fizz' => __DIR__. DS . 'library'
));