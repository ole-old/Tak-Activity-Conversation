<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Access_Users extends Controller_Backend_Template {
	
	public $user;
	
	public function before()
	{
		parent::before();
		
		$this->user = new Model_Sys_User;
	}
	
	public function action_index()
	{
		$order_by = Arr::get($_GET, 'order_by', 'name');
		$sort     = Arr::get($_GET, 'sort', 'ASC');
		
		$view = View::factory('backend/access/users/index')
			->set('users', $this->user->fetch_all($order_by, $sort))
			->set('order_by', $order_by)
			->set('sort', $sort);
				
		$this->template->content = $view;
	}
	
	public function action_form()
	{
		$id       = Arr::get($_GET, 'id', 0);
		$status   = Model::factory('Sys_Lookup')->fetch_by_type('status');
		$data     = ($id) ? $this->user->fetch($id) : NULL;
		
		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			if (($this->template->errors = $this->user->save($data)) === TRUE)
				Request::current()->redirect('/admin/access/users/index');
		}
		
		$view = View::factory('backend/access/users/form')
			->set('user', $data)
			->set('status', $status);
			
		$this->template->content = $view;
	}
	
	public function action_delete()
	{
		if ($_POST)
		{
			$id = Arr::get($_GET, 'id', 0);
			$this->user->delete($id);
		}
		
		Request::current()->redirect('/admin/access/users/index');
	}

}