<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catlocation extends Model {
		
	public function fetch_all()
	{
		return DB::select('id','location')
			->from('cat_location')
			->where('is_deleted', '=', 0)
			->order_by('id', 'ASC')
			->execute();
			
	}	
	
}