<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sys_Module extends Model {
	
	public function menu($directory)
	{
		$_results = DB::select('name', 'path')
			->from('sys_module')
			->where('parent_id', 'IS', NULL)
			->order_by('position', 'ASC')
			->execute();
		
		$results = array();
		foreach ($_results as $result)
		{
			$result['selected'] = ($result['path'] == $directory) ? 'selected' : '';
			$result['link'] = $result['path'];
			$results[] = $result;
		}
		
		return $results;
		
	}
	
	public function submenu($directory, $controller)
	{
		$_results = DB::select('m2.name', array('m1.path','group'), 'm2.path')
			->from(array('sys_module', 'm2'))
			->join(array('sys_module', 'm1'))
			->on('m1.id', '=', 'm2.parent_id')
			->where('m1.parent_id', 'IS', NULL)
			->order_by('m1.position', 'ASC')
			->order_by('m2.position', 'ASC')
			->execute();
		
		$results = array();
		foreach ($_results as $result)
		{
			$result['visible'] = ($result['group'] == $directory) ? 'visible' : '';
			$result['selected'] = ($result['group'] == $directory AND $result['path'] == $controller) ? 'selected' : '';
			$result['link'] = $result['group'].'/'.$result['path'].'/index';
			$results[] = $result;
		}
		
		return $results;
	}
	
	public function title($directory, $controller)
	{
		return DB::select('m2.name')
			->from(array('sys_module', 'm2'))
			->join(array('sys_module', 'm1'))
			->on('m1.id', '=', 'm2.parent_id')
			->where('m1.parent_id', 'IS', NULL)
			->where('m1.path', '=', $directory)
			->where('m2.path', '=', $controller)
			->execute()
			->get('name', '');
	}
	
}