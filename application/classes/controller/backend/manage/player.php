<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Player extends Controller_Backend_Template {
	
	public $player;
	
	public function before()
	{
		parent::before();
		
		$this->player = new Model_Player;
	}
	
	public function action_index()
	{
		$order_by = Arr::get($_GET, 'order_by', 'fullname');
		$sort     = Arr::get($_GET, 'sort', 'ASC');
		$limit    = Arr::get($_GET, 'limit', 20);
		$offset     = Arr::get($_GET, 'offset', 0);
		$school_id     = Arr::get($_GET, 'school_id', 0);
		
		$params = array('limit'=>$limit, 'offset'=>$offset, 'school_id'=>$school_id, 'order_by'=>$order_by, 'sort'=>$sort);
		
		$view = View::factory('backend/manage/'.$this->_controller.'/index')
			->set('dbdata', $this->player->fetch_all($params))
			->set('order_by', $order_by)
			->set('controller', $this->_controller)
			->set('sort', $sort);
				
		$this->template->content = $view;
	}

	public function action_details()
	{
		$id = Arr::get($_GET, 'id', 0);

		$view = View::factory('backend/manage/'.$this->_controller.'/details')
			->set('controller', $this->_controller)
			->set('dbdata', $this->player->fetch($id));
			
		$this->auto_render = false;
		$this->response->body($view);
	}


	public function action_form()
	{
		$id        = Arr::get($_GET, 'id', 0);
		$parent_id = Arr::get($_GET, 'parent_id', 0);
		$status    = Model::factory('Sys_Lookup')->fetch_by_type('status');
		$sections  = Model::factory('Page')->fetch_sections();
		$data      = ($id) ? $this->player->fetch($id) : NULL;
		
		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			
			if (($this->template->errors = $this->player->save($data)) === TRUE)
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
		
		$this->player->sort($id, $pos, $parent);
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}
	
	public function action_delete()
	{
		if ($_POST)
		{
			$id = Arr::get($_GET, 'id', 0);
			$this->player->delete($id);
		}
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}

}