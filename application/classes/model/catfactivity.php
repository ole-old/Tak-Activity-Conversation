<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catfactivity extends Model {
	
	protected $_module_id = 9;
	
	public function fetch_all($params = NULL)
	{
		
		$data = DB::select('id', 'activity', 'status')
				 ->from('cat_factivity')
				 ->where('is_deleted', '=', 0)
				 ->order_by('id', 'ASC')->execute();
		
		return $data;
			
	}	

	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('activity', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
		
		return $data;
	}
	
}