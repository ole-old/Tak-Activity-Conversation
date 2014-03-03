<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Banners extends Controller_Backend_Template {
	
	public $banner;
	
	public function before()
	{
		parent::before();
		
		$this->banner = new Model_Banner;
		$this->banner_type = new Model_BannerType;
	}
	
	public function action_index()
	{
		
		$view = View::factory('backend/manage/'.$this->_controller.'/index')
			->set('controller', $this->_controller)
			->set('data', $this->banner->fetch_all( array('type_id' => 1) ))
			->set('data2', $this->banner->fetch_all( array('type_id' => 2) ));

		$this->template->content = $view;
	}
	
	public function action_form()
	{
		$id        = Arr::get($_GET, 'id', 0);
		$status    = Model::factory('Sys_Lookup')->fetch_by_type('status');
		$data      = ($id) ? $this->banner->fetch($id) : NULL;
		$yesno     = Model::factory('Sys_Lookup')->fetch_by_type('yesno');
		$banner_types = $this->banner_type->fetch_all();

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			if (($this->template->errors = $this->banner->save($data)) === TRUE)
				Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
		}
		
		$view = View::factory('backend/manage/'.$this->_controller.'/form')
			->set('data', $data)
			->set('banner_types', $banner_types)
			->set('controller', $this->_controller)
			->set('yesno', $yesno)
			->set('status', $status);
		
		$this->template->content = $view;
	}

	public function action_sort()
	{
		$id     = Arr::get($_GET, 'id', 0);
		$pos    = Arr::get($_GET, 'position', 0);
		$type_id    = Arr::get($_GET, 'type_id', 1);
		
		$this->banner->sort($id, $pos, $type_id);
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}
	
	public function action_delete()
	{

		if ($_POST)
		{
			$id = Arr::get($_GET, 'id', 0);
			$this->banner->delete($id);
		}
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}

}