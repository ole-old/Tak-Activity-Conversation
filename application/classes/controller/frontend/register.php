<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Register extends Controller_Frontend_Template {
	
	public function action_index()
	{
		
		//$data = Model::factory('Page')->fetch_from_uri('contacto', '');
		$data = array('id' => 0, 'school_id' => 0, 'school_year_id' => 0, 'avatar' => '', 'birthday' => '', 'fullname' => '', 'email' => '', 'gender' => '',  'state_id' => '0', 
		              'curp' => '', 'asignature_id' => '', 'asignature_other' => '', 'activity_id' => '', 'activity_other' => '', 'school_year_other' => '', 'how' => '', 'how_id' => '', 
					  'date_register' => date('Y-m-d G:i:s'), 'total_score' => 0, 'status' => 1);		
		$registry = Model::factory('Sys_Registry')->fetch_all();
		$answers1 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '1'));
		$answers2 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '2'));
		$answers3 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '3'));
		$terms = Model::factory('Page')->fetch_from_uri('aviso-de-privacidad', '');
		
		if($_POST){			
			$data['o_username'] = $_POST['username'];
			$data = array_merge( (array) $data, $_POST);
			$data['avatar'] = $data['avatar'].'.png';
			
		
	
		$usr_validate=Model::factory('Player')->unq_username($data['o_username']);
			
		if((int)$usr_validate >= 1):
				Model::factory('Player')->logout();
				?>                
			    <script type="text/javascript">
					alert('<?=utf8_decode('Ese usuario ya existe, elige otro')?>');
					window.location.href='registro';
                </script>               
                <?php
					exit;
			endif;
			
			$save_player = Model::factory('Player')->save($data);
			$login = Model::factory('Player')->loginRegister(strtoupper($_POST['username']),strtoupper($_POST['password']), 2);
			
			
			
			if($save_player):
				Request::current()->redirect('registro/gracias');
			endif;			
		} else {
			$data = NULL;
		}				
	
		$view = View::factory('frontend/homepage/register')
			->set('terms', $terms)
			->set('data', $data)
			->set('answers1', $answers1)
			->set('answers2', $answers2)
			->set('answers3', $answers3)
			->set('registry', $registry);
	
		$this->template->content = $view;
	}
	
	public function action_validateUsername(){
		
		$data = array();
		
		$data = array_merge( (array) $data, $_POST);
		$exist = Model::factory('Player')->searchPlayer($data['username']);
		
		echo $exist;
		exit();
		
	}
	
	public function action_thanks(){
			
		$registry = Model::factory('Sys_Registry')->fetch_all();
	
		$view = View::factory('frontend/homepage/register_thanks')
			->set('registry', $registry);
	
		$this->template->content = $view;
	}

	public function action_favorite()
	{
			
		$game = $this->request->param('game');
		$user_front = Session::instance()->get('identity_front');
		$registry = Model::factory('Sys_Registry')->fetch_all();
		$game_info = Model::factory('Game')->fetch_by_slug($game);
		$do_favorite = Model::factory('Player')->do_favorite($user_front['id'], $game_info['id']);
	
		Request::current()->redirect('favoritos');
	
		$this->template->content = $view;
	}

	public function action_favorites()
	{
			
		$user_front = Session::instance()->get('identity_front');
		$registry = Model::factory('Sys_Registry')->fetch_all();
		$player_data = Model::factory('Player')->fetch($user_front['id']);
		$favorites = Model::factory('Player')->get_favorites($user_front['id']);
	
		$view = View::factory('frontend/homepage/favorites')
			->set('player_data', $player_data)
			->set('games', $favorites)
			->set('registry', $registry);
	
		$this->template->content = $view;
	}
	
	public function action_profile(){
		
		$user_front = Session::instance()->get('identity_front');
		$registry = Model::factory('Sys_Registry')->fetch_all();
		$player_data = Model::factory('Player')->fetch($user_front['id']);
		
		$player_data['year'] = substr($player_data['birthday'], 0, 4);
		$player_data['month'] = substr($player_data['birthday'], 5, 2);
		$player_data['day'] = substr($player_data['birthday'], 8, 2);
		$answers1 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '1'));
		$answers2 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '2'));
		$answers3 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '3'));
		$states = Model::factory('Catstate')->fetch_all();
		$paises = Model::factory('Catpais')->fetch_all();
		$factivities = Model::factory('Catfactivity')->fetch_all();
		$school_years = Model::factory('Catschoolyear')->fetch_all();
		$how_id = Model::factory('Cathow')->fetch_all();
		
		if($_POST) {
			$data['o_username'] = $_POST['username'];
			$data['status'] = $player_data['status'];
			$data['school_id'] = $player_data['school_id'];
			$data['school_year_id'] = $player_data['school_year_id'];
			$data['curp'] = $player_data['curp'];
			$data['total_score'] = $player_data['total_score'];
			$data['confirmation_card']=$player_data['confirmation_card'];
			$data = array_merge( (array) $data, $_POST);
			$data['avatar'] = $data['avatar'].'.png';
			
			$data['birthday'] = $data['year']."-".$data['month']."-".$data['day'];
			
			if(!array_key_exists('gender', $data)):
				$data['gender'] = 0;
			endif;
			
			//no password change
			if(!$data['password']):
				$data['password'] = $player_data['password'];
			endif;
			
			if($data['pais_id'] != 24 && !isset($data['state_id'])):
				$data['state_id'] = 33;
			endif;

			$save_player = Model::factory('Player')->save($data);
			
			if($save_player):
				Request::current()->redirect('mi_perfil/gracias');
			endif;			
		} else {
			$data = NULL;
		}
	
		$view = View::factory('frontend/homepage/profile')
			->set('states', $states)
			->set('paises',$paises)
			->set('factivities', $factivities)
			->set('school_years', $school_years)
			->set('answers1', $answers1)
			->set('answers2', $answers2)
			->set('answers3', $answers3)
			->set('user_front', $user_front)
			->set('player_data', $player_data)
			->set('how_id', $how_id)
			->set('registry', $registry);
	
		$this->template->content = $view;
	}
	
	public function action_profile_thanks()
	{
			
		$registry = Model::factory('Sys_Registry')->fetch_all();
	
		$view = View::factory('frontend/homepage/profile_thanks')
			->set('registry', $registry);
	
		$this->template->content = $view;
	}
	
	public function action_login(){
		$data = NULL;
		
		if ($_POST){

			$data = array_merge( (array) $data, $_POST);			
			//para ver si se marcó la casilla de verificación
			if(isset($data['sample-check']) == true):
				$remember = 1;
			else:
				$remember = 0;
			endif;
			
			if(isset($data['sample-check2']) == true):
				$r_pass = 1;
			else:
				$r_pass = 0;
			endif;

			$login = Model::factory('Player')->login(strtoupper($data['login_username']), strtoupper($data['login_password']), $remember, $r_pass);
			
			if($login == 1):
				Security::token(TRUE);
				Request::current()->redirect('inicio');	
				exit;
			elseif($login == 0):
				Model::factory('Player')->logout();?>
				<script type="text/javascript">
					alert('<?=utf8_decode('Verifica tus datos porque son incorrectos')?>');
					window.location.href='inicio';
				</script><?php
				exit;
			elseif($login == 2):
				Request::current()->redirect('completa_registro');
				exit;
			elseif($login == 3):
				Request::current()->redirect('inicio');
				exit;
			endif;

		}		
	}
	
	public function action_materias(){
			header('Content-type: application/json');
			$materias = Model::factory('Catasignature')->fetch_by_school_year($_REQUEST['school_year_id'])->as_array();
			echo json_encode($materias);
			exit();
	}
	
	public function action_logout()
	{
		Model::factory('Player')->logout();
		Request::current()->redirect('inicio');
	}
	
	

	public function action_recovery()
	{
		$user_front = Session::instance()->get('identity_front');
		$registry = Model::factory('Sys_Registry')->fetch_all();
		$player_data = Model::factory('Player')->fetch($user_front['id']);
		Model::factory('Player')->logout();
		
			
		if($_POST) {			
			$data['user'] = $_POST['username'];
			$data['password'] = $_POST['password'];
			$data['id'] = $_POST['id_usr'];

			$data = array_merge( (array) $data, $_POST);
	
			$save_player = Model::factory('Player')->updatePassword($data);
			
			if($save_player):
				Model::factory('Player')->loginRegister(strtoupper($_POST['username']));
			endif;			
		} else {
			$data = NULL;
		}
	
		$view = View::factory('frontend/homepage/new_password')
			->set('user_front', $user_front)
			->set('player_data', $player_data)
			->set('registry', $registry);
	
		$this->template->content = $view;
	}
	

}