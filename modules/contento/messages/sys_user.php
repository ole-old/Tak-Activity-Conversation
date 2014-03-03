<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'first_name' => array(
		'not_empty' => utf8_encode('El nombre no puede estar vac�o.'),
	),
	'last_name' => array(
		'not_empty' => utf8_encode('El apellido no puede estar vac�o.'),
	),
	'email' => array(
		'not_empty' => utf8_encode('El correo electr�nico no puede estar vac�o.'),
	),
	'email' => array(
		'email' => utf8_encode('El correo electr�nico debe ser v�lido.'),
	),
	'email' => array(
		'Model_Sys_User::unique_email' => utf8_encode('Ya existe un usuario registrado con la cuenta de correo electr�nico proporcionada.'),
	),
	'status' => array(
		'not_empty' => utf8_encode('Debe especificar el estatus.'),
	),
	'status' => array(
		'in_array' => utf8_encode('El estatus es inv�lido.'),
	),
	'password' => array(
		'not_empty' => utf8_encode('La contrase�a no puede estar vac�a.'),
	),
	'password' => array(
		'min_length' => utf8_encode('La contrase�a debe ser de al menos 8 caracteres de longitud.'),
	),
);