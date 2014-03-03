<?php defined('SYSPATH') or die('No direct script access.');

class Model_Cathow extends Model {
		
	public function fetch_all()
	{
		return DB::select('id','how')
			->from('cat_how')
			->where('is_deleted', '=', 0)
			->order_by('id', 'ASC')
			->execute();
			
	}	
	
}