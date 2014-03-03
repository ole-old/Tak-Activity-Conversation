<?php defined('SYSPATH') or die('No direct access allowed.');

if (Kohana::$environment == 1)
{
	return array
	(
	// Prod
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'database'   => 'inoma',
				'username'   => 'playa',
				'password'   => 'delcarmen',
				'persistent' => FALSE,
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		),
	);
} 
else 
{
	// Dev
	return array
	(
		'default' => array
		(
			'type'       => 'mysql',
			'connection' => array(
				'hostname'   => 'localhost',
				'database'   => 'inoma',
				'username'   => 'root',
				'password'   => 'kawabunga',
				'persistent' => FALSE,
			),
			'table_prefix' => '',
			'charset'      => 'utf8',
			'caching'      => FALSE,
			'profiling'    => TRUE,
		),
	);
}
