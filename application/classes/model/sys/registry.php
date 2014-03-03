<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sys_Registry extends Model {
	
	protected $_module_id = 5;
	
	public function fetch_all()
	{
		$settings = array();
		
		$results = DB::select('var', 'value')
			->from('sys_registry')
			->order_by('id', 'ASC')
			->execute();
			
		foreach ($results as $result)
		{
			$settings[$result['var']] = $result['value'];
		}
		
		return $settings;
	}
	
	public function save($data)
	{
		unset($data['csrf_token']);
		
		foreach ($data as $var => $value)
		{
			DB::update('sys_registry')->set(array('value' => $value))->where('var', '=', $var)->execute();
			
		}
		
		$this->_log_transaction($this->_module_id, 1, 'Variables', $data, 2);

		return TRUE;
	}
	
}