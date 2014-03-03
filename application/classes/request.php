<?php defined('SYSPATH') or die('No direct script access.');

class Request extends Kohana_Request {
	
	public static function browser($user_agent)
	{
		$browsers = Kohana::config('user_agents')->browser;
		
		foreach ($browsers as $search => $name)
		{
			if (stripos($user_agent, $search) !== FALSE)
				return $name;
		}
	}
	
}