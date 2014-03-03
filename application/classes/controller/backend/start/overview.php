<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Start_Overview extends Controller_Backend_Template {

	public function action_index()
	{
		$identity = $this->template->identity;
		
		$view = View::factory('backend/start/overview/index')
				->set('transactions', Model::factory('Sys_Activity_Log')->latest(5, $identity['id']))
				->set('sessions', Model::factory('Sys_Session_Log')->latest(5, $identity['id']))
				->set('site_title', $this->template->site_title);

		$this->template->content = $view;
	}

}