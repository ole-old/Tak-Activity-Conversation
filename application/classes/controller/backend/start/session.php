<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Start_Session extends Controller_Backend_Template {
	
	public function action_login()
	{
		if($_POST)
		{
			$remember = array_key_exists('remember', $_POST);
			$_POST['success'] = Model::factory('Sys_User')->login($_POST['email'], $_POST['password'], $remember);
			
			if ($_POST['success'])
			{
				Security::token(TRUE);
				Request::current()->redirect('/admin/start/overview/index');
			}
		}
		
		$view = View::factory('backend/start/session/login')
			->set('email',   Arr::get($_POST, 'email'))
			->set('success', Arr::get($_POST, 'success', TRUE));
		
		$this->template->content = $view;
	}
	
	public function action_logout()
	{
		Model::factory('Sys_User')->logout();
		Request::current()->redirect('/admin/start/session/login');
	}


	public function action_password()
	{
		if($_POST)
		{
			$_POST['success'] = Model::factory('Sys_User')->forgot($_POST['email']);
			
			if ($_POST['success'])
			{
				$_POST['sent'] = TRUE; 
			}
		}
		
		$view = View::factory('backend/start/session/password')
			->set('email',   Arr::get($_POST, 'email'))
			->set('sent',   Arr::get($_POST, 'sent', FALSE))
			->set('success', Arr::get($_POST, 'success', TRUE));
		
		$this->template->content = $view;
	}

}