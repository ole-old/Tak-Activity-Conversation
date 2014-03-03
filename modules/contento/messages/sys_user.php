<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'first_name' => array(
		'not_empty' => utf8_encode('El nombre no puede estar vacío.'),
	),
	'last_name' => array(
		'not_empty' => utf8_encode('El apellido no puede estar vacío.'),
	),
	'email' => array(
		'not_empty' => utf8_encode('El correo electrónico no puede estar vacío.'),
	),
	'email' => array(
		'email' => utf8_encode('El correo electrónico debe ser válido.'),
	),
	'email' => array(
		'Model_Sys_User::unique_email' => utf8_encode('Ya existe un usuario registrado con la cuenta de correo electrónico proporcionada.'),
	),
	'status' => array(
		'not_empty' => utf8_encode('Debe especificar el estatus.'),
	),
	'status' => array(
		'in_array' => utf8_encode('El estatus es inválido.'),
	),
	'password' => array(
		'not_empty' => utf8_encode('La contraseña no puede estar vacía.'),
	),
	'password' => array(
		'min_length' => utf8_encode('La contraseña debe ser de al menos 8 caracteres de longitud.'),
	),
);