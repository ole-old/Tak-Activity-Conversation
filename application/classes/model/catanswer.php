<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catanswer extends Model {
	
	protected $_module_id = 9;
	
	public function fetch_by_question($params = NULL)
	{
		
		$data = DB::select('id', 'answer', 'status')
				 ->from('cat_answer')
				 ->where('is_deleted', '=', 0)
				 ->and_where('question_id', '=', $params['question_id'])
				 ->order_by('id', 'ASC')->execute();
		
		return $data;
			
	}	

	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('question_id', 'not_empty')
			->rule('answer', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
		
		return $data;
	}
	
}