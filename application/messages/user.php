<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'first_name' => array(
		'not_empty' => 'First name can\'t be empty',
	),
	'last_name' => array(
		'not_empty' => 'First name can\'t be empty',
	),
	'email' => array(
		'not_empty' => 'Email can\'t be empty',
	),
	'email' => array(
		'email' => 'Email must be a valid address',
	),
	'email' => array(
		'Model_Sys_User::unique_email' => 'Email is already registered',
	),
	'status' => array(
		'not_empty' => 'Status can\'t be empty',
	),
	'status' => array(
		'in_array' => 'Status should be active or inactive',
	),
	'password' => array(
		'not_empty' => 'Password can\'t be empty',
	),
	'password' => array(
		'min_length' => 'Password must be at least 8 chars length',
	),
);