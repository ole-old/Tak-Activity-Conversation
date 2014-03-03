<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Contact extends Controller_Frontend_Template {
	
	public function action_index()
	{
		
		$data = Model::factory('Page')->fetch_from_uri('contacto', '');

		$sent = false;
		$registry = Model::factory('Sys_Registry')->fetch_all();
		
		if($_POST){
			$data = array_merge( (array) $data, $_POST);
			Model::factory('Contact')->send_contact($data, $registry);
			$sent = true;
		}
	
		$view = View::factory('frontend/homepage/contact')
			->set('content', $data)
			->set('sent', $sent)
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
	
		$this->template->content = $view;
	}


}