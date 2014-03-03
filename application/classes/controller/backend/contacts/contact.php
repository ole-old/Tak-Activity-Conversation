<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Contacts_Contact extends Controller_Backend_Template {
	
	public $contact;
	
	public function before()
	{
		parent::before();
		
		$this->contact = new Model_Contact;
	}
	
	public function action_index()
	{
		
		$view = View::factory('backend/contacts/contact/index')
			->set('data', $this->contact->fetch_all());

		$this->template->content = $view;
	}

	public function action_details()
	{
		$id = Arr::get($_GET, 'id', 0);

		$reset = Arr::get($_GET, 'reset', 0);
		
		if($reset){
			$del = $this->user->resetgames($id);
		}

		$view = View::factory('backend/contacts/contact/details')
			->set('data', $this->contact->fetch($id));
			
		$this->auto_render = false;
		$this->response->body($view);
	}

	public function action_export()
	{
		
		$view = View::factory('backend/contacts/contact/export')
			->set('data', $this->contact->fetch_all());
			
		$this->auto_render = false;
		
		
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=CMP2013_contactos_".date('Ymd').".xls"); 
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		/*
		$this->request->headers['Expires'] = '0';
		$this->request->headers['Cache-Control'] = 'must-revalidate, post-check=0, pre-check=0';
		$this->request->headers['Content-Type'] = 'application/vnd.ms-excel';
		$this->request->headers['Content-Disposition'] = 'attachment; filename=CMP2013_contactos_'.date('Ymd').'.xls';
		*/
		$this->response->body($view);
	}


}