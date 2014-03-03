<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Manage_Games extends Controller_Backend_Template {
	
	public $game;
	
	public function before()
	{
		parent::before();
		
		$this->game = new Model_Game;
		$this->gamedeveloper = new Model_GameDeveloper;
	}
	
	public function action_index()
	{
		
		$view = View::factory('backend/manage/'.$this->_controller.'/index')
			->set('controller', $this->_controller)
			->set('data', $this->game->fetch_all());

		$this->template->content = $view;
	}
	
	public function action_form()
	{
		$id        = Arr::get($_GET, 'id', 0);
		$status    = Model::factory('Sys_Lookup')->fetch_by_type('status');
		$data      = ($id) ? $this->game->fetch($id) : NULL;
		$yesno     = Model::factory('Sys_Lookup')->fetch_by_type('yesno');
		
		$developers = $this->gamedeveloper->fetch_all();

		if ($_POST)
		{
			$data = array_merge( (array) $data, $_POST);
			if (($this->template->errors = $this->game->save($data)) === TRUE)
				Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
		}
		
		$view = View::factory('backend/manage/'.$this->_controller.'/form')
			->set('data', $data)
			->set('developers', $developers)
			->set('controller', $this->_controller)
			->set('yesno', $yesno)
			->set('status', $status);
		
		$this->template->content = $view;
	}

	public function action_sort()
	{
		$id     = Arr::get($_GET, 'id', 0);
		$pos    = Arr::get($_GET, 'position', 0);
		
		$this->game->sort($id, $pos);
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}
	
	public function action_delete()
	{

		if ($_POST)
		{
			$id = Arr::get($_GET, 'id', 0);
			$this->game->delete($id);
		}
		
		Request::current()->redirect('/admin/manage/'.$this->_controller.'/index');
	}

}