<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Start_Settings extends Controller_Backend_Template {

	public $registry;
	
	public function before()
	{
		parent::before();
		
		$this->registry = new Model_Sys_Registry;
	}
	
	public function action_index()
	{
		if ($_POST)
		{
			if (($this->template->errors = $this->registry->save($_POST)) === TRUE)
				Request::current()->redirect('/admin/start/settings/index');
		}
		
		$view = View::factory('backend/start/settings/index')
				->set('setting', $this->registry->fetch_all());

		$this->template->content = $view;
	}

}