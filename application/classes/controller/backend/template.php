<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Template extends Controller_Template {

	public    $template = 'backend/template';
	protected $_session;
	protected $_directory;
	protected $_controller;
	protected $_action;
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		
		$this->_session    = Session::instance();
		$this->_directory  = str_replace('backend/', '', Request::$current->directory());
		$this->_controller = Request::$current->controller();
		$this->_action     = Request::$current->action();
	}
	
	public function before()
	{
		parent::before();
		
		if ( ! $this->_session->get('identity'))
		{
			if(Request::$current->controller() != 'session')
				Request::current()->redirect('/admin/start/session/login');
		}
		
		if ($_POST AND $this->_controller!='session')
		{
			$token = Arr::get($_POST, 'csrf_token', '');
			if( ! Security::check($token))
				throw new Exception('Invalid security token');
		}
		
		if ($this->auto_render)
		{
			$site = Kohana::config('site');
			$sys_module = new Model_Sys_Module;
			$sys_activity_log = new Model_Sys_Activity_Log;
			
			$sys_activity_log->check_undo();
			$this->template->site_title = $site->title;
			$this->template->site_url   = $site->url;
			$this->template->title      = $sys_module->title($this->_directory, $this->_controller);
			$this->template->content    = '';
			$this->template->identity   = $this->_session->get('identity');
			$this->template->menu       = $sys_module->menu($this->_directory);
			$this->template->submenu    = $sys_module->submenu($this->_directory, $this->_controller);
			$this->template->errors     = array();
			$this->template->success    = $sys_activity_log->get_flash_msg('activity_log_id');
			$this->template->the_action = $this->_action;
		}
	}
	
	public static function routes($uri)
	{
		$default = array('backend', 'start', 'overview', 'index');
		$route   = explode('/', str_replace('admin', 'backend', $uri));
		$array_replaced = $route + $default;
		list($application, $directory, $controller, $action) = $array_replaced;
		
		if ($application != 'backend')
			return FALSE;
		
		return array(
			'directory'  => 'backend/'.$directory,
			'controller' => $controller,
			'action'     => $action,
		);
	}

}