<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catasignature extends Model {
	
	protected $_module_id = 9;
	
	public function fetch_all($params = NULL)
	{
		
		$data = DB::select('id', 'asignature', 'school_year_id', 'status')
				 ->from('cat_asignature')
				 ->where('is_deleted', '=', 0)
				 ->order_by('id', 'ASC')->execute();
		
		return $data;
			
	}	

	public function fetch_by_school_year($sy_id)
	{
		
		$data = DB::select('id', 'asignature')
				->from('cat_asignature')
				->where('school_year_id','=',$sy_id)
				->execute();
		
		return $data;
			
	}	

	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('asignature', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
		
		return $data;
	}
	
}