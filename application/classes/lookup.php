<?php defined('SYSPATH') or die('No direct script access.');

class Lookup {
	
	public static function name($type, $code)
	{
		return Model::factory('Sys_Lookup')->get_name($type, $code);
	}
	
}