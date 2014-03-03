<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Game extends Controller_Frontend_Template {
	

	public function action_index()
	{
		
		$user_front = Session::instance()->get('identity_front');
		$params['status'] = 1;
		$tmp_favorites = Model::factory('Player')->get_favorites($user_front['id']);
		
		$favorites = array();
		foreach($tmp_favorites as $row) {
			$favorites[] = $row['id'];
		}
		
		$view = View::factory('frontend/game/index')
			->set('favorites', $favorites)
			->set('games', Model::factory('Game')->fetch_all($params))
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
		$this->template->content = $view;
	}

	public function action_detalle(){
		
		$user_front = Session::instance()->get('identity_front');
		
		if (!isset($user_front)){
			Request::current()->redirect('/registro');
		}
		
		$game = $this->request->param('game');
		$game_info = Model::factory('Game')->fetch_by_slug($game);
		Session::instance()->set('game_id', $game_info['id']);
		
		if(isset($user_front['source_id']) && $user_front['source_id'] == 8){ //registro de clic en juego matriz
			$registro = Model::factory('Game')->setGameClic($game_info['id'],$user_front['id']);
		}
		
		$view = View::factory('frontend/game/detail')
			->set('game', $game_info)
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
		$this->template->content = $view;
		
	}

	public function action_play()
	{
		
		
		$game = $this->request->param('game');
		$game_info = Model::factory('Game')->fetch_by_slug($game);
		Session::instance()->set('game_id', $game_info['id']);
		Session::instance()->set('play_id', 0);
		$partner = Arr::get($_GET, 'partner', '');
		
		if($partner != '' && $partner=='televisa') {
			$login = Model::factory('Player')->loginIframe('TELEVISA');
		}
		
		$ext_file = explode(".", $game_info['gamefile']);
		
		if($ext_file[1]=='swf') {
			$ext_file = 1;
		} else {
			$ext_file = 2;
		}
		
		//echo $ext_file;
		
		//var_dump($game_info);		
		
		
		$view = View::factory('frontend/game/play')
			->set('ext_file', $ext_file)
			->set('game', $game_info)
			->set('partner', $partner)
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
		$this->template->content = $view;
	}
	
	public function action_result()
	{
		$game = $this->request->param('game');
		$game_info = Model::factory('Game')->fetch_by_slug($game);
		$user_front = Session::instance()->get('identity_front');
		$registry = Model::factory('Sys_Registry')->fetch_all();
		$player_data = Model::factory('Player')->fetch($user_front['id']);
		$max_score = Model::factory('Game')->us_maxscore_game(array('game_id' => $game_info['id'], 'player_id' => $user_front['id']));
		$top_players = Model::factory('Game')->top_maxscore_game(array('game_id' => $game_info['id'], 'limit' => 4));
		
	
		$view = View::factory('frontend/game/result')
			->set('top_players', $top_players)
			->set('max_score', $max_score)
			->set('user_front', $user_front)
			->set('player_data', $player_data)
			->set('game', $game_info)
			->set('registry', $registry);
	
		$this->template->content = $view;
	}
	
	public function action_search()
	{
		$term = Arr::get($_GET, 'search_txt', '');
		
		$user_front = Session::instance()->get('identity_front');
		$params['status'] = 1;
		$tmp_favorites = Model::factory('Player')->get_favorites($user_front['id']);
		
		$favorites = array();
		foreach($tmp_favorites as $row) {
			$favorites[] = $row['id'];
		}
		
		$view = View::factory('frontend/game/search')
			->set('favorites', $favorites)
			->set('games', Model::factory('Game')->search($term))
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
		$this->template->content = $view;
	}

}