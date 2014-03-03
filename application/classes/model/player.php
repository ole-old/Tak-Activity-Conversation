<?php defined('SYSPATH') or die('No direct script access.');

class Model_Player extends Model {
	
	protected $_module_id = 10;
	
	public function login($username, $password, $remember, $r_pass)
	{
		$now = date('Y-m-d H:i:s');
		
		$player = DB::select('id', 'username', 'password', 'avatar', 'school','privacy_policy','source_id')
			->from('player')
			->where('username', '=', $username)
			->where('password', '=', $password)
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		if( ! $player) {
			$successful = 0;
		} else {
			$successful = 1;
		}	
			
		list($log) = DB::insert('login_logs', array('credentials', 'successful', 'date_log', 'ip', 'user_agent'))
			->values(array($username, $successful, $now, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']))
			->execute();
			
		if(!$player)
			return 0;
			
		if($player['password'] != $password)
			return 0;
		
		if($player['privacy_policy'] != 1)
		{
			Session::instance()->set('identity_front', $player);
						//si se tiene que recordar el usuario
			if($remember == 1)
				 Cookie::set('taktaktak', $player['username'],time()+60*60*24*30);
			else
				Cookie::delete('taktaktak');
			//si se tiene que recordar la contraseña
			if($r_pass == 1)
				Cookie::set('taktaktakpw',$player['password'],time()+60*60*24*30);	
			else
				Cookie::delete('taktaktakpw');

			Cookie::set("taktaktakid",base64_encode($player['id']),time()+60*60*24*30);
			return 2;
		}
		
		//cuando existe el usuario y tiene en 1 el aviso de privacidad
		if($successful==1 && $player['privacy_policy'] == 1)
		{
			Session::instance()->set('identity_front', $player);
			
			//si se tiene que recordar el usuario
			if($remember == 1)
				 Cookie::set('taktaktak', $player['username'],time()+60*60*24*30);
			else
				Cookie::delete('taktaktak');
			//si se tiene que recordar la contraseña
			if($r_pass == 1)
				Cookie::set('taktaktakpw',$player['password'],time()+60*60*24*30);
			else
				Cookie::delete('taktaktakpw');
			
			Cookie::set("taktaktakid",base64_encode($player['id']),time()+60*60*24*30);
			
			if($player['source_id'] == 7){
				return 3;
			}else{
				return 1;
			}
			
		}
	}
	
	public function refresh_session($id)
	{
		$user = DB::select('id', 'username', 'password', 'avatar', 'school')
			->from('player')
			->where('id', '=', base64_decode($id))
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		if( ! $user)
			return FALSE;
		
		Session::instance()->set('identity_front', $user);
		
		return TRUE;		
	}	
	
	public function logout()
	{
		$user = Session::instance()->get('identity_front');
		Session::instance()->delete('identity_front');
		setcookie("taktaktakid",'',time()-3600);
		return TRUE;
	}	
	
	public function fetch_all($params)
	{
		$limit = "";
		$sql   = "";
		
		if (ctype_digit( (string) $params['limit']) AND ctype_digit( (string) $params['offset']))
		{
			$limit = "LIMIT ".$params['offset'].", ".$params['limit'];
		}
		
		if (array_key_exists('school_id', $params))
		{
			$sql = "AND school_id = ".$params['school_id'];
		}		
		
		return DB::query(Database::SELECT, "
						 SELECT SQL_CALC_FOUND_ROWS pl.id, sc.title as school, pl.fullname, pl.email, pl.gender, pl.source_id, pl.location_id, pl.date_register, pl.total_score, pl.status, pl.school
						 FROM player pl LEFT JOIN school sc ON pl.school_id = sc.id
						 WHERE pl.is_deleted = 0 ".$sql." ORDER BY ".$params['order_by']." ".$params['sort']." ".$limit)
						 ->execute();
	}
	
	public function fetch($id){
		
		$data = DB::select('player.id', 'player.school_id', 'player.school_year_id', 'player.username', 'player.answer1', 'player.answer2', 
		                   'player.answer3', 'player.avatar', 'player.birthday', 'player.fullname', 'player.email', 'player.gender',
						   'player.curp', 'player.pais_id', 'player.asignature_id', 'player.asignature_other', 'player.activity_id', 'player.activity_other',
						   'player.school_year_other', 'player.how_id', 'player.how', 'player.date_register', 'player.total_score', 'player.status',
						   'school.title', 'player.password', 'player.school', 'player.state_id', 'player.source_id', 'player.location_id', 'player.confirmation_card')
			->from('player')
			->join('school', 'left')
			->on('school.id', '=', 'player.school_id')
			->where('player.id', '=', $id)
			->execute()
			->current();
			
		if ($data){
			$log = Model::factory('Sys_Activity_Log')->last_modified($this->_module_id, $id);
			$data['log_timestamp'] = $log['timestamp'];
			$data['log_user'] = $log['name'];
		}
		
		return $data;
		
	}
	
	public function searchPlayer($player){
		
		$chk = DB::select('username')->from('player')->where('username', '=', $player)->execute()->current();
		
		if($chk){
			return true;
		}else{
			return false;
		}
		
	}
	
	public function do_favorite($player_id, $game_id)
	{
		$chk = DB::select('game_id')
			->from('player_favorites')
			->where('player_favorites.player_id', '=', $player_id)
			->where('player_favorites.game_id', '=', $game_id)
			->execute()->current();
			
		if($chk) {
			$del = DB::delete('player_favorites')
					->where('player_favorites.player_id', '=', $player_id)
					->where('player_favorites.game_id', '=', $game_id)
					->execute();
		} else {
			list($register_id) = DB::insert('player_favorites', array('player_id', 'game_id'))
				->values(array($player_id, $game_id))
				->execute();
		}
		
	}

	public function get_favorites($id)
	{
		$data = DB::select('game.id', 'game.title', 'game.brief', 'game.imagename', 'game.slug')
			->from('player_favorites')
			->join('game', 'left')
			->on('player_favorites.game_id', '=', 'game.id')
			->where('player_favorites.player_id', '=', $id)
			->execute();
		
		return $data;
	}
	
	public function save($data)
	{
		$valid = $this->check($data);
		
		if ( ! $valid->check())
			return $valid->errors('player');
			else{
				foreach($data as $campo => $valor){
					if($campo != 'avatar')
					$data[$campo] = strtoupper($data[$campo]);
				}
			}

		if ($data['id']):
			return $this->_update($data);
		else:		
			return $this->_insert($data);
		endif;
			
	}
	
	public function delete($id)
	{
		$id = (int) $id;
		
		DB::update('player')
			->set(array('is_deleted' => 1))
			->where('id', '=', $id)
			->execute();
		
		$data = DB::select('id', 'fullname')
			->from('player')
			->where('id', '=', $id)
			->execute()
			->current();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['fullname'], $data, 3);
		
		return TRUE;
	}
	
	protected function _insert($data)
	{		
		list($player_id) = DB::insert('player', array('school_id', 'school_year_id', 'username', 'password', 'answer1', 'answer2', 
		                   'answer3', 'avatar', 'birthday', 'fullname', 'email', 'gender', 'curp', 'state_id', 'asignature_id',
						   'asignature_other', 'activity_id', 'activity_other', 'school_year_other', 'how_id','how',
						   'date_register', 'total_score', 'status', 'privacy_policy'))
						   //'date_register', 'total_score', 'status','source_id', 'location_id', 'privacy_policy'))

			->values(array($data['school_id'], $data['school_year_id'], $data['username'], $data['password'], $data['answer1'], $data['answer2'],
			               $data['answer3'], $data['avatar'], $data['birthday'], $data['fullname'], $data['email'], $data['gender'], $data['curp'], $data['state_id'], $data['asignature_id'],
						   $data['asignature_other'], $data['activity_id'], $data['activity_other'], $data['school_year_other'], $data['how_id'], $data['how'],
						   //$data['date_register'], $data['total_score'], $data['status'], $data['source_id'], $data['location_id'],1))
						   $data['date_register'], $data['total_score'], $data['status'],1))
			->execute();
		
		return $player_id;
	}
	
	protected function _update($data)
	{
		print_r($data);
		$query = DB::update('player')
			->set(array('school_id'  => $data['school_id']))
			->set(array('school_year_id'   => $data['school_year_id']))
			->set(array('username'   => $data['username']))
			->set(array('password'   => $data['password']))
			->set(array('answer1'   => $data['answer1']))
			->set(array('answer2'   => $data['answer2']))
			->set(array('answer3'   => $data['answer3']))
			->set(array('avatar'   => $data['avatar']))
			->set(array('birthday'   => $data['birthday']))
			->set(array('fullname'   => $data['fullname']))
			->set(array('email'   => $data['email']))
			->set(array('gender'   => $data['gender']))
			->set(array('curp'   => $data['curp']))
			->set(array('pais_id'   => $data['pais_id']))
			->set(array('asignature_id'   => $data['asignature_id']))
			->set(array('state_id'   => $data['state_id']))
			->set(array('asignature_other'   => $data['asignature_other']))
			->set(array('activity_id'   => $data['activity_id']))
			->set(array('activity_other'   => $data['activity_other']))
			->set(array('school_year_other'   => $data['school_year_other']))
			->set(array('how_id'   => $data['how_id']))
			->set(array('total_score'   => $data['total_score']))
			->set(array('how'   => $data['how']))
			->set(array('confirmation_card'   => $data['confirmation_card']))
			->set(array('status' => $data['status']))
			->set(array('school'  => $data['school']))
			//->set(array('source_id' => $data['source_id']))
			//->set(array('location_id' => $data['location_id']))
			->where('id', '=', $data['id']);
			
		$query->execute();
		
		//$this->_log_transaction($this->_module_id, $data['id'], $data['fullname'], $data, 2);
		
		return TRUE;
	}			
	
	public function status($id, $status_id)
	{
		$query = DB::update('player')
			->set(array('status_id'  => $status_id))
			->where('id', '=', $id);
			
		$query->execute();
		
		return TRUE;
	}
	
	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		
		
		$data = Validation::factory($data)
			->rule('username', 'not_empty')
			->rule('password', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2, 3, 4, 5, 6)));		
		
		return $data;
	}
	
		public static function unique_username($id, $username, $o_username)
	{
		$result = DB::select(array(DB::expr('COUNT(username)'), 'total'))
			->from('player')
			->where('username', '=', $username)
			->and_where('is_deleted', '=', 0);
		
		if ($id)
		{
			$result->where('username', '<>', $o_username);
		}
		
		return ! $result->execute()->get('total');
	}

	
	public function unq_username($username)
	{
	
		$result = DB::select(array('COUNT("username")', 'total'))
			->from('player')
			->where('username', '=', strtoupper($username))
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		return $result['total']; 
	}

	public function change_password($username,$answer1,$answer2,$answer3)
	{
	
		$data = DB::select('username', 'password')
			->from('player')
			->where('username', '=', strtoupper($username))
			->where('answer1', '=', $answer1)
			->where('answer2', '=', $answer2)
			->where('answer3', '=', $answer3)
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()->current();
			
		if($data)
			return $data['password']; 
		else
			return 0;
	}
	
	
		public function updateRegister($data)
	{
		$query = DB::update('player')
			->set(array('answer1'   => $data['answer1']))
			->set(array('answer2'   => $data['answer2']))
			->set(array('answer3'   => $data['answer3']))
			->set(array('avatar'   => $data['avatar']))
			->set(array('privacy_policy' => $data['privacy_policy']))
			->where('id', '=', $data['id']);
			
		$query->execute();
	
		
		return TRUE;
	}	
	
	
		
		public function updatePassword($data)
	{
		$query = DB::update('player')
			->set(array('password'   => strtoupper($data['password'])))
			->where('id', '=', $data['id']);
			
		$query->execute();
	
		
		return TRUE;
	}	
	
	
	public function loginIframe($username)
	{
		$now = date('Y-m-d H:i:s');
		
		$player = DB::select('id', 'username', 'password', 'avatar', 'school','privacy_policy','source_id')
			->from('player')
			->where('username', '=', $username)
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		if( ! $player) {
			$successful = 0;
		} else {
			$successful = 1;
		}	
			
		list($log) = DB::insert('login_logs', array('credentials', 'successful', 'date_log', 'ip', 'user_agent'))
			->values(array($username, $successful, $now, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']))
			->execute();
	
			Session::instance()->set('identity_front', $player);
			setcookie("taktaktakid",base64_encode($player['id']),time()+60*60*24*30);
			return true;
	
	}
	
	
	
	public function loginRegister($username)
	{
		$now = date('Y-m-d H:i:s');
		
		$player = DB::select('id', 'username', 'password', 'avatar', 'school','privacy_policy','source_id')
			->from('player')
			->where('username', '=', $username)
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		if( ! $player) {
			$successful = 0;
		} else {
			$successful = 1;
		}	
			
		list($log) = DB::insert('login_logs', array('credentials', 'successful', 'date_log', 'ip', 'user_agent'))
			->values(array($username, $successful, $now, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']))
			->execute();
	
			Session::instance()->set('identity_front', $player);
			Request::current()->redirect('mi_perfil/gracias');
			setcookie("taktaktakid",base64_encode($player['id']),time()+60*60*24*30);
			return true;
	
	}

	public function checkuser($data)
	{
			$result = DB::select('id')
			->from('player')
			->where('username', '=', strtoupper($data))
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		return $result; 
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
}
