<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catsource extends Model {
		
	public function fetch_all()
	{
		return DB::select('id','source')
			->from('cat_source')
			->where('is_deleted', '=', 0)
			->order_by('id', 'ASC')
			->execute();
			
	}	
	
}