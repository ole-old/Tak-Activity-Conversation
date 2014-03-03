<?php defined('SYSPATH') or die('No direct script access.');

class Time extends Kohana_Date {
	
	public static function format($format = '%Y-%m-%d', $timestamp)
	{
		if ( ! $timestamp)
			return '';
		
		if (strpos($timestamp, '-'))
			return $timestamp;
		
		$formatted = strftime($format, $timestamp);
		
		$lang = current(explode('-', I18n::lang()));
		if ($lang=='es')
		{
			$formatted = str_replace("January", "Enero", $formatted);
			$formatted = str_replace("February", "Febrero", $formatted);
			$formatted = str_replace("March", "Marzo", $formatted);
			$formatted = str_replace("April", "Abril", $formatted);
			$formatted = str_replace("May", "Mayo", $formatted);
			$formatted = str_replace("June", "Junio", $formatted);
			$formatted = str_replace("July", "Julio", $formatted);
			$formatted = str_replace("August", "Agosto", $formatted);
			$formatted = str_replace("September", "Septiembre", $formatted);
			$formatted = str_replace("October", "Octubre", $formatted);
			$formatted = str_replace("November", "Noviembre", $formatted);
			$formatted = str_replace("December", "Diciembre", $formatted);
		}
		
		return $formatted;
	}
	
}