<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sys_Session_Log extends Model {
	
	const LOGIN    = 1;
	const LOGOUT   = 2;
	const COOKIE   = 3;
	const PASSWORD = 4;
	
	public function latest($num, $user_id)
	{
		return DB::select('user_agent', 'remote_address', 'timestamp', 'action')
			->from('sys_session_log')
			->where('user_id', '=', $user_id)
			->order_by('timestamp', 'DESC')
			->limit($num)
			->offset(0)
			->execute();
	}
	
	public function log($user_id, $action)
	{
		DB::insert('sys_session_log', array('user_id', 'timestamp', 'remote_address', 'user_agent', 'action'))
			->values(array($user_id, time(), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $action))
			->execute();
	}
	
}