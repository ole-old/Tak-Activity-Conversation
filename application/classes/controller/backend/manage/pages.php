<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Pages extends Controller_Backend_Template {
	
	public $page;
	
	public function before()
	{
		parent::before();
		
		$this->page = new Model_Page;
	}
	
	public function action_index()
	{
		$order_by = Arr::get($_GET, 'order_by', 'position');
		$sort     = Arr::get($_GET, 'sort', 'ASC');
		
		$view = View::factory('backend/manage/'.$this->_controller.'/index')
			->set('pages', $this->page->fetch_all($order_by, $sort))
			->set('order_by', $order_by)
			->set('controller', $this->_controller)
			->set('sort', $sort);
				
		$this->template->content = $view;
	}
	
	public function action_form()
	{
		$id        = Arr::get($_GET, 'id', 0);
		$parent_id = Arr::get($_GET, 'parent_id', 0);
		$status    = Model::factory('Sys_Lookup')->fetch_by_type('status');
		$sections  = Model::factory('Page')->fetch_sections();
		$data      = ($id) ? $this->page->fetch($id) : NULL;
		
		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			
			if (($this->template->errors = $this->page->save($data)) === TRUE)
				Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
		}
		
		$view = View::factory('backend/manage/'.$this->_controller.'/form')
			->set('page', $data)
			->set('parent_id', $parent_id)
			->set('sections', $sections)
			->set('controller', $this->_controller)
			->set('status', $status);
		
		$this->template->content = $view;
	}
	
	public function action_sort()
	{
		$id     = Arr::get($_GET, 'id', 0);
		$pos    = Arr::get($_GET, 'position', 0);
		$parent = Arr::get($_GET, 'parent_id', 0);
		
		$this->page->sort($id, $pos, $parent);
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}
	
	public function action_delete()
	{
		if ($_POST)
		{
			$id = Arr::get($_GET, 'id', 0);
			$this->page->delete($id);
		}
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}

}