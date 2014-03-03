<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_PasswordRecovery extends Controller_Frontend_Template {
	

	public function action_index()
	{

		
		$data = array('id' => 0, 'school_id' => 0, 'school_year_id' => 0, 'avatar' => '', 'birthday' => '', 'fullname' => '', 'email' => '', 'gender' => '',  'state_id' => '0', 
		       'curp' => '', 'asignature_id' => '', 'asignature_other' => '', 'activity_id' => '', 'activity_other' => '', 'school_year_other' => '', 'how' => '', 'how_id' => '', 
			   'date_register' => date('Y-m-d G:i:s'), 'total_score' => 0, 'status' => 1);		
		
		$answers1 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '1'));
		$answers2 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '2'));
		$answers3 = Model::factory('Catanswer')->fetch_by_question(array('question_id' => '3'));
		
		if($_POST){			
			$username = $_POST['username'];
			$a1=$_POST['answer1'];
			$a2=$_POST['answer2'];
			$a3=$_POST['answer3'];
			
			$data = array_merge( (array) $data, $_POST);
		
			$user_password=Model::factory('Player')->change_password($username,$a1,$a2,$a3);
		
		//si el usuario no ingresa la información correctamente
			if(empty($user_password)):
				Model::factory('Player')->logout();
				?>                
			    <script type="text/javascript">
					alert('<?=utf8_decode('Datos incorrectos, por favor intenta de nuevo.')?>');
					window.location.href='recupera_contrasena';
                </script>               
                <?php
					exit;
			endif;
			
			if(Model::factory('Player')->login(strtoupper($username), $user_password,0,0) == 1):
				Security::token(TRUE);
				Request::current()->redirect('nueva_contrasena');	
				exit;
			endif;
			
			//$save_player = Model::factory('Player')->save($data);
			//$login = Model::factory('Player')->loginRegister(strtoupper($_POST['username']),strtoupper($_POST['password']), 2);
			

			Request::current()->redirect('mi_perfil');
			
		} else {
			$data = NULL;
		}	

	
		$view = View::factory('frontend/homepage/password_recovery')
			->set('data', $data)
			->set('answers1', $answers1)
			->set('answers2', $answers2)
			->set('answers3', $answers3);
			
	
		$this->template->content = $view;
	
	}
	

	public function action_logout()
	{
		Model::factory('Player')->logout();
		Request::current()->redirect('inicio');
	}
}