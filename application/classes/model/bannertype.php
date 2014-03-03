<?php defined('SYSPATH') or die('No direct script access.');

class Model_BannerType extends Model {
	
	protected $_module_id = 9;
	
	public function fetch_all()
	{
		$level1 = DB::select('id', 'title', 'status')
			->from('banner_type')
			->where('is_deleted', '=', 0)
			->order_by('id', 'ASC')
			->execute()
			->as_array();
		
		return $level1;
			
	}
	
	public function fetch($id)
	{
		$data = DB::select('id', 'title', 'status')
			->from('banner_type')
			->where('id', '=', $id)
			->execute()
			->current();
			
		if ($data)
		{
			$log = Model::factory('Sys_Activity_Log')->last_modified($this->_module_id, $id);
			$data['log_timestamp'] = $log['timestamp'];
			$data['log_user'] = $log['name'];
		}
		
		return $data;
	}

	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('title', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
		
		return $data;
	}
	
}