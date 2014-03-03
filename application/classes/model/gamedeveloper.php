<?php defined('SYSPATH') or die('No direct script access.');

class Model_GameDeveloper extends Model {
	
	protected $_module_id = 10;
	
	public function fetch_all()
	{
		$level1 = DB::select('id', 'title', 'brief', 'status')
			->from('game_developer')
			->where('is_deleted', '=', 0)
			->order_by('title', 'ASC')
			->execute()
			->as_array();
		
		return $level1;
			
	}
	
	public function fetch($id)
	{
		$data = DB::select('id', 'title', 'brief', 'status')
			->from('game_developer')
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
	
	public function save($data)
	{
		$valid = $this->check($data);
		
		if ( ! $valid->check())
			return $valid->errors('gamedeveloper');

		if ($data['id'])
			return $this->_update($data);
		else
			return $this->_insert($data);
			
	}
		
	protected function _insert($data)
	{
		
		list($added_id) = DB::insert('game_developer', array('title', 'brief', 'status', 'is_deleted'))
			->values(array($data['title'], $data['brief'], $data['status'], 0))
			->execute();
		
		$this->_log_transaction($this->_module_id, $added_id, $data['title'], $data, 1);
		
		return TRUE;
	}
	
	protected function _update($data)
	{

		$query = DB::update('game_developer')
			->set(array('title'  => $data['title']))
			->set(array('brief'  => $data['brief']))
			->set(array('status'       => $data['status']))
			->where('id', '=', $data['id'])
			->execute();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 2);
		
		return TRUE;
	}

	public function delete($id)
	{
		$id = (int) $id;
		
		DB::update('game_developer')
			->set(array('is_deleted' => 1))
			->where('id', '=', $id)
			->execute();
		
		$data = DB::select('id', 'title')
			->from('game_developer')
			->where('id', '=', $id)
			->execute()
			->current();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 3);
		
		return TRUE;
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