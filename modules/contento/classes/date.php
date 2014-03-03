<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date helper. 
 *
 * @package    Contento
 * @category   Helpers
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Date extends Kohana_Date {
	
	public static function fuzzy_span($timestamp, $local_timestamp = NULL)
	{
		$local_timestamp = ($local_timestamp === NULL) ? time() : (int) $local_timestamp;

		// Determine the difference in seconds
		$offset = abs($local_timestamp - $timestamp);

		if ($offset <= Date::MINUTE)
		{
			$span = 'momentos';
		}
		elseif ($offset < (Date::MINUTE * 20))
		{
			$span = 'unos pocos minutos';
		}
		elseif ($offset < Date::HOUR)
		{
			$span = 'menos de una hora';
		}
		elseif ($offset < (Date::HOUR * 4))
		{
			$span = 'un par de horas';
		}
		elseif ($offset < Date::DAY)
		{
			$span = utf8_encode('menos de un día');
		}
		elseif ($offset < (Date::DAY * 2))
		{
			$span = utf8_encode('un día');
		}
		elseif ($offset < (Date::DAY * 4))
		{
			$span = utf8_encode('un par de días');
		}
		elseif ($offset < Date::WEEK)
		{
			$span = 'menos de una semana';
		}
		elseif ($offset < (Date::WEEK * 2))
		{
			$span = 'una semana';
		}
		elseif ($offset < Date::MONTH)
		{
			$span = 'menos de un mes';
		}
		elseif ($offset < (Date::MONTH * 2))
		{
			$span = 'un mes';
		}
		elseif ($offset < (Date::MONTH * 4))
		{
			$span = 'un par de meses';
		}
		elseif ($offset < Date::YEAR)
		{
			$span = utf8_encode('menos de un año');
		}
		elseif ($offset < (Date::YEAR * 2))
		{
			$span = utf8_encode('un año');
		}
		elseif ($offset < (Date::YEAR * 4))
		{
			$span = utf8_encode('un par de años');
		}
		elseif ($offset < (Date::YEAR * 8))
		{
			$span = utf8_encode('algunos años');
		}
		elseif ($offset < (Date::YEAR * 12))
		{
			$span = utf8_encode('una década');
		}
		elseif ($offset < (Date::YEAR * 24))
		{
			$span = utf8_encode('un par de décadas');
		}
		elseif ($offset < (Date::YEAR * 64))
		{
			$span = 'several decades';
		}
		else
		{
			$span = 'a long time';
		}

		if ($timestamp <= $local_timestamp)
		{
			// This is in the past
			return 'hace '.$span;
		}
		else
		{
			// This in the future
			return 'in '.$span;
		}
	}
	
}