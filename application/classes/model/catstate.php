<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catstate extends Model {
	
	public function fetch_all()
	{
		return DB::select('id', 'name')
			->from('cat_state')
			->order_by('name', 'ASC')
			->execute();
	}

}