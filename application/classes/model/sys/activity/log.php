<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sys_Activity_Log extends Model {
	
	public function last_modified($module_id, $object_id)
	{	
		return DB::select('sal.timestamp', 'su.name')
			->from(array('sys_activity_log', 'sal'))
			->join(array('sys_user', 'su'))
			->on('su.id', '=', 'sal.user_id')
			->where('sal.module_id', '=', $module_id)
			->where('sal.object_id', '=', $object_id)
			->order_by('sal.timestamp', 'DESC')
			->limit(1)
			->offset(0)
			->execute()
			->current();
	}
	
	public function get_flash_msg($session_var)
	{
		$session = Session::instance();
		
		if ( ! ($id = $session->get($session_var)))
			return '';
		
		$result = DB::select('sm.flash', 'sal.object_name', 'sal.action')
			->from(array('sys_activity_log', 'sal'))
			->join(array('sys_module', 'sm'))
			->on('sm.id', '=', 'sal.module_id')
			->where('sal.id', '=', $id)
			->execute()
			->current();
		
		$action = Model::factory('Sys_Lookup')->get_name('activity', $result['action']);
		$action = str_replace("ar", "ad", strtolower($action));
		
		$flash = $result['flash'];
		$flash = str_replace("{object_name}", $result['object_name'], $flash);
		$flash = str_replace("{action}", $action, $flash);
		
		if ($result['action'] == 3)
		{
			$qs = (strpos($_SERVER['REQUEST_URI'], '?') !== FALSE) ? '&' : '?';
			$flash .= '<a href="'.$_SERVER['REQUEST_URI'].$qs.'undo=true" class="undo">Undo</a>';
			$session->set('undo', $id);
		}
		
		$session->delete($session_var);
		
		return $flash;
	}
	
	public function latest($num, $user_id)
	{
		return DB::select(array('sm.name', 'module_name'), 'sal.object_name', 'sal.timestamp', 'sal.action')
			->from(array('sys_activity_log', 'sal'))
			->join(array('sys_module', 'sm'))
			->on('sm.id', '=', 'sal.module_id')
			->where('sal.user_id', '=', $user_id)
			->order_by('sal.timestamp', 'DESC')
			->limit($num)
			->offset(0)
			->execute();
	}
	
	public function check_undo()
	{
		$session = Session::instance();
		$undo = Arr::get($_GET, 'undo', '');
		$id = (int) $session->get('undo');
		
		if ($id AND $undo)
		{
			$result = DB::select('sal.object_id', 'sm.table', 'sal.data')
				->from(array('sys_activity_log', 'sal'))
				->join(array('sys_module', 'sm'))
				->on('sm.id', '=', 'sal.module_id')
				->where('sal.id', '=', $id)
				->execute()
				->current();
				
			DB::delete('sys_activity_log')->where('id', '=', $id)->execute();
			
			DB::update($result['table'])->set(array('is_deleted' => 0))->where('id', '=', $result['object_id'])->execute();
			
			$session->delete('undo');
		}
	}
	
}