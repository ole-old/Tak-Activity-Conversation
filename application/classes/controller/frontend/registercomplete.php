<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_RegisterComplete extends Controller_Frontend_Template {
	

	public function action_index()
	{
		$user_front = Session::instance()->get('identity_front');
		$registry = Model::factory('Sys_Registry')->fetch_all();
		$player_data = Model::factory('Player')->fetch($user_front['id']);
		$passwd = $player_data['password'];
		Model::factory('Player')->logout();
		
		$data = array('id' => '','school_id' => 0, 'school_year_id' => 0, 'avatar' => '', 'birthday' => '', 'fullname' => '', 'email' => '', 'gender' => '',  'state_id' => '0', 
		              'curp' => '', 'asignature_id' => '', 'asignature_other' => '', 'activity_id' => '', 'activity_other' => '', 'school_year_other' => '', 'how' => '', 'how_id' => '', 
					  'date_register' => date('Y-m-d G:i:s'), 'total_score' => 0, 'status' => 1, 'privacy_policy' => '');
		
		
		$answers1 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '1'));
		$answers2 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '2'));
		$answers3 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '3'));
		
		
		if($_POST) {
			$data['id'] = $_POST['id_usr'];
			$data['o_username'] = $_POST['username'];
			$data['status'] = $player_data['status'];
			$data['total_score'] = $player_data['total_score'];
			$data['privacy_policy'] = 1;
			$data = array_merge( (array) $data, $_POST);
			$data['avatar'] = $data['avatar'].'.png';
			
			
			
			$save_player = Model::factory('Player')->updateRegister($data);
			
			if($save_player):
				Model::factory('Player')->loginRegister(strtoupper($_POST['username']),strtoupper($passwd), 2);
			endif;			
		} else {
			$data = NULL;
		}
	
		$view = View::factory('frontend/homepage/register_complete')
			->set('answers1', $answers1)
			->set('answers2', $answers2)
			->set('answers3', $answers3)
			->set('user_front', $user_front)
			->set('player_data', $player_data)
			->set('registry', $registry);
	
		$this->template->content = $view;
	}
	

	public function action_logout()
	{
		Model::factory('Player')->logout();
		Request::current()->redirect('inicio');
	}


}