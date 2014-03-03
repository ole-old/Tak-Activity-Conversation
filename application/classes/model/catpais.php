<?php defined('SYSPATH') or die('No direct script access.');

class Model_Catpais extends Model {
	
	public function fetch_all()
	{
		return DB::select('id', 'pais')
			->from('cat_paises')
			->order_by('pais', 'ASC')
			->execute();
	}

}