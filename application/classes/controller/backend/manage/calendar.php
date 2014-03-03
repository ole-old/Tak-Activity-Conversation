<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Calendar extends Controller_Backend_Template {
	
	public $calendar;
	
	public function before()
	{
		parent::before();
		
		$this->calendar = new Model_Calendar;
	}
	
	public function action_index()
	{
		$id_type = Arr::get($_GET, 'id_type', 0);
		
		$view = View::factory('backend/manage/'.$this->_controller.'/index')
			->set('id_type', $id_type)
			->set('controller', $this->_controller)
			->set('data', $this->calendar->fetch_all($id_type));

		$this->template->content = $view;
	}
	
	public function action_form()
	{
		$id        = Arr::get($_GET, 'id', 0);
		$status    = Model::factory('Sys_Lookup')->fetch_by_type('status');
		$data      = ($id) ? $this->calendar->fetch($id) : NULL;

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			if (($this->template->errors = $this->calendar->save($data)) === TRUE)
				Request::current()->redirect('/admin/manage/'.$this->_controller.'/index?id_type='.$data['id_type']);
		}
		
		$view = View::factory('backend/manage/'.$this->_controller.'/form')
			->set('data', $data)
			->set('controller', $this->_controller)
			->set('status', $status);
		
		$this->template->content = $view;
	}

	public function action_sort()
	{
		$id     = Arr::get($_GET, 'id', 0);
		$pos    = Arr::get($_GET, 'position', 0);
		
		$parent = $this->calendar->sort($id, $pos);
		
		Request::current()->redirect('/admin/manage/calendar/index?id_section='.$parent['id_section'].'&id_category='.$parent['id_category']);
	}
	
	public function action_delete()
	{

		if ($_POST)
		{
			$id = Arr::get($_GET, 'id', 0);
			$this->calendar->delete($id);
		}
		
		Request::current()->redirect('/admin/manage/calendar/index');
	}

}