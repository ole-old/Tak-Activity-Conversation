<?php defined('SYSPATH') or die('No direct script access.');

class Model_Banner extends Model {
	
	protected $_module_id = 9;
	
	public function fetch_all($params = NULL)
	{
		
		$query = DB::select('banner.id', 'banner.type_id', 'banner.title', 'banner.imagename', 'banner.url', 'banner.position', 'banner.status', array('banner_type.title', 'type'))
				 ->from('banner')
				 ->join('banner_type', 'left')
				 ->on('banner.type_id', '=', 'banner_type.id')
				 ->where('banner.is_deleted', '=', 0);
		
		if($params && array_key_exists('type_id', $params))
		{
			$query->and_where('type_id', '=', $params['type_id']);
		}
		
		return $query->order_by('banner.position', 'ASC')->execute()->as_array();
			
	}
	
	public function fetch($id)
	{
		$data = DB::select('id', 'type_id', 'title', 'imagename', 'url', 'position', 'status')
			->from('banner')
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
			return $valid->errors('banner');

		if ($data['id'])
			return $this->_update($data);
		else
			return $this->_insert($data);
			
	}
		
	protected function _insert($data)
	{
		
		$data['position'] = $this->_position($data['type_id']);
		list($added_id) = DB::insert('banner', array('type_id', 'title', 'imagename', 'url', 'position', 'status', 'is_deleted'))
			->values(array($data['type_id'], $data['title'], $data['imagename'], $data['url'], $data['position'], $data['status'], 0))
			->execute();
		
		$this->_log_transaction($this->_module_id, $added_id, $data['title'], $data, 1);
		
		return TRUE;
	}
	
	protected function _update($data)
	{

		$query = DB::update('banner')
			->set(array('type_id'  => $data['type_id']))
			->set(array('title'  => $data['title']))
			->set(array('imagename'  => $data['imagename']))
			->set(array('url'  => $data['url']))
			->set(array('status'       => $data['status']))
			->where('id', '=', $data['id'])
			->execute();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 2);
		
		return TRUE;
	}

	public function delete($id)
	{
		$id = (int) $id;
		
		DB::update('banner')
			->set(array('is_deleted' => 1))
			->where('id', '=', $id)
			->execute();
		
		$data = DB::select('id', 'title')
			->from('banner')
			->where('id', '=', $id)
			->execute()
			->current();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 3);
		
		return TRUE;
	}

	public function sort($id, $position, $type_id)
	{
		$query = DB::select('id')->from('banner')->where('is_deleted', '=', 0)->where('type_id', '=', $type_id)->order_by('position', 'ASC');
		
		$results = $query->execute()->as_array();
		
		
		for ($i=0; $i<count($results); $i++)
		{
			if($position == 'up'){
				if($results[$i]['id'] == $id && $i>0){
					$tmp = $results[($i-1)];
					$results[($i-1)] = $results[$i];
					$results[$i] = $tmp;
					break;
				}
			} else {
				if($results[$i]['id'] == $id && ($i-1) < count($results)){
					$tmp = $results[($i+1)];
					$results[($i+1)] = $results[$i];
					$results[$i] = $tmp;
					$i++;
					break;
				}
			}
		}
		
		for ($i=0; $i<count($results); $i++)
			DB::update('banner')->set(array('position' => $i))->where('id', '=', $results[$i]['id'])->execute();
	}

	protected function _position($type_id)
	{
		$query = DB::select(array(DB::expr('`position` + 1'), 'position'))
			->from('banner')
			->where('is_deleted', '=', 0)
			->where('type_id', '=', $type_id)
			->order_by('position', 'DESC')
			->limit(1)
			->offset(0);
			
		return $query->execute()->get('position', 1);
	}

	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('type_id', 'not_empty')
			->rule('title', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
		
		return $data;
	}
	
}