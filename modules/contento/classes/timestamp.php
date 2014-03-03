<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Timestamp helper. 
 *
 * @package    Contento
 * @category   Helpers
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Timestamp extends Kohana_Date {
	
	public static function format($time = NULL, $format = '%Y-%m-%d %H:%M:%S')
	{
		if ( ! $time)
			return NULL;
		
		if ( ! (string) ctype_digit($time))
			return $time;
		
		$formatted = strftime($format, $time);	
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
			
			$formatted = str_replace("Jan", "Ene", $formatted);
			$formatted = str_replace("Apr", "Abr", $formatted);
			$formatted = str_replace("Aug", "Ago", $formatted);
			$formatted = str_replace("Dec", "Dic", $formatted);
		}
		
		return $formatted;
	}
	
}