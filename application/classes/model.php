<?php defined('SYSPATH') or die('No direct script access.');

class Model extends Kohana_Model {
	
	const INSERT = 1;
	const UPDATE = 2;
	const DELETE = 3;
	
	const DELETED  = 0;
	const ACTIVE   = 1;
	const INACTIVE = 2;
	
	protected function _log_transaction($module_id, $object_id, $object_name, $data, $action)
	{
		$session     = Session::instance();
		$identity    = $session->get('identity');
		$object_name = Text::limit_chars($object_name, 20);
		$data        = json_encode($data);
		
		list($activity_log_id) = DB::insert('sys_activity_log', array('user_id', 'module_id', 'object_id', 'object_name', 'data', 'action', 'timestamp'))
			->values(array($identity['id'], $module_id, $object_id, $object_name, $data, $action, time()))
			->execute();
		
		$session->set('activity_log_id', $activity_log_id);
	}
	
}