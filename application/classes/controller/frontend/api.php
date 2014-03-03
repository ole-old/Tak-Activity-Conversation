<?php defined('SYSPATH') or die('No direct script access.');

//class Controller_Frontend_Api extends Controller_Frontend_Template {
class Controller_Frontend_Api extends Controller {

	protected $_sess;
	
	public function __construct(Request $request, Response $response){
		parent::__construct($request, $response);
		$this->_sess    = Session::instance();
	}
	
	public function before(){
		parent::before();
	}

	public function action_index(){
		$this->response->body('');
	}
	
	public function action_get_initial_info(){
		$user_front = Session::instance()->get('identity_front');
		$data = array();
		$data = array_merge( (array) $data, $_POST);
		
		$game_info = Model::factory('Game')->us_save_data(array(
			'game_id' => $this->_sess->get('game_id'),
			'player_id' => $user_front['id'],
			'data' => '',
			'new_game' => 1,
		));
		$this->response->body('');
	}
	
	public function action_game_info(){
		
		$user_front = Session::instance()->get('identity_front');
		$data = array();
		$data = array_merge((array) $data, $_POST);
		
		if(array_key_exists('metodo', $data) && $data['metodo'] == "inicioJuego"){
			 $data['data'] = $data['info'];
		}else{
			$data['data'] = "";
		}
		
		echo "Estoy en action_game_info: " . $this->_sess->get('game_id') . "   :\n";
		
		$game_info = Model::factory('Game')->us_set_game_info(array(
			'game_id' => $this->_sess->get('game_id'),
			'player_id' => $user_front['id'],
			'score' => $data['score'],
			'game_info' => $data['info'],
			'metodo' => $data['metodo'],
			'data' => $data['data']
		));
		
		$this->response->body('');
		
	}

	public function action_save_data(){
		$user_front = Session::instance()->get('identity_front');
		$data = array();
		$data = array_merge( (array) $data, $_POST);
		
		if(Session::instance()->get('play_id')) {
			$new = 0;
		} else {
			$new = 1;
		}
		
		
		$game_info = Model::factory('Game')->us_save_data(array(
			'game_id' => $this->_sess->get('game_id'),
			'player_id' => $user_front['id'],
			'data' => $data['data'],
			'new_game' => $new,
		));
		$this->response->body('');
	}
	
	public function action_scene_changed(){
		$user_front = Session::instance()->get('identity_front');
		$data = array();
		$data = array_merge( (array) $data, $_POST);				
		
		
		$game_info = Model::factory('Game')->us_scene_changed(array(
			'game_id' => $this->_sess->get('game_id'),
			'player_id' => $user_front['id'],
			'sceneIn' => $data['sceneIn'],
			'sceneOut' => $data['sceneOut'],
		));
		$this->response->body('');
	}
	
	public function action_game_ended(){
		$user_front = Session::instance()->get('identity_front');
		$data = array();
		$data = array_merge( (array) $data, $_POST);				
		
		
		$game_info = Model::factory('Game')->us_game_ended(array(
			'game_id' => $this->_sess->get('game_id'),
			'player_id' => $user_front['id'],
			'score' => $data['points'],
			'level' => $data['level'],
			'extra_info' => $data['didChange'],
			'mini_game_id' => $data['idGame'],
		));
		$this->response->body('');
	}

	

}