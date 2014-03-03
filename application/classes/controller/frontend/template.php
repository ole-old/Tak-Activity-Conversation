<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Template extends Controller_Template {
	
	public    $template = 'frontend/template';
	protected $_controller;
	protected $_action;
	
	public function __construct(Request $request, Response $response)
	{
		parent::__construct($request, $response);
		
		$this->_controller = Request::$current->controller();
		$this->_action     = Request::$current->action();
	}
	
	public function before()
	{
		parent::before();
			
		
		if ($this->auto_render)
		{
			
			if (isset($_COOKIE["taktaktakid"])){
				Model::factory('Player')->refresh_session($_COOKIE["taktaktakid"]);
			}
		
			$cookie=Cookie::get('taktaktak', '');
			$cookie2=Cookie::get('taktaktakpw', '');
			

			
			$site = Kohana::config('site');
			$uri = explode("?", Request::$current->uri());
			$user_front = Session::instance()->get('identity_front');
			$game = $this->request->param('game');
			
			$game_data = array('game_data' => '');
			$game_info = array();
			if($game) {
				$game_info = Model::factory('Game')->fetch_by_slug($game);
				if($user_front['id']) {
					$game_data = Model::factory('Game')->us_gamedata(
						array('id' => $game_info['id'], 'player_id' => $user_front['id'], 'order_by' => 'id', 'sort' => 'DESC', 'offset' => '0', 'limit' => '1'))->current();
				}
				if(!count($game_data)) 
				{
				    $game_data = array('game_data' => '');
				}
			}
			
			
			$uri = $uri[0];
			
			$is_home = ($this->_controller=='homepage' && $this->_action == 'index')?"home":"";
		
			$this->template->site_title = Kohana::config('site')->title;
			$this->template->site_url   = $site->url;
			$this->template->title      = Model::factory('Page')->get_title($uri);
			$this->template->content    = '';
			$this->template->is_home    = $is_home;
			$this->template->registry   = Model::factory('Sys_Registry')->fetch_all();
			$this->template->user_front    = $user_front;
			$this->template->game_data     = $game_data;
			$this->template->the_game_info     = $game_info;
			if(isset($_COOKIE["taktaktak"]))
				$this->template->cookie = $cookie;
			if(isset($_COOKIE["taktaktakpw"]))
				$this->template->cookie2 = $cookie2;
			//$this->template->menu       = Model::factory('Page')->menu($uri);
			$this->template->controller = $this->_controller;
			$this->template->the_action = $this->_action;
		}
	}

}