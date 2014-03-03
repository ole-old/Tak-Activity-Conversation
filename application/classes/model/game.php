<?php defined('SYSPATH') or die('No direct script access.');

class Model_Game extends Model {
	
	protected $_module_id = 8;
	
	public function fetch_all(){
		$level1 = DB::select('game.id', array('game_developer.title', 'developer'), 'game.slug', 'game.title', 'game.brief', 'game.imagename', 
		                     'game.imagetop', 'game.imageback', 'game.game_width', 'game.game_height', 'game.gamefile', 'game.gamefile_eng', 
							 'game.status', 'game.base_path')
			->from('game')
			->join('game_developer', 'left')
			->on('game.developer_id', '=', 'game_developer.id')
			->where('game.is_deleted', '=', 0)
			->order_by('game.position', 'ASC')
			->execute()
			->as_array();
		
		return $level1;
			
	}
	
	public function fetch_matriz($player_id){
		
		$juegos = DB::select('juego_1', 'juego_2')// , 'juego_3', 'juego_4', 'juego_5')
			->from('player_matriz_prueba')
			->where('player_id','=',$player_id)
			->execute()->current();
		
		$level1 = array();
		$level1[0] = $this->fetch($juegos['juego_1']);
		$level1[1] = $this->fetch($juegos['juego_2']);
		/* $level1[2] = $this->fetch($juegos['juego_3']);
		$level1[3] = $this->fetch($juegos['juego_4']);
		$level1[4] = $this->fetch($juegos['juego_5']); */
	
		return $level1;
			
	}
	
	public function search($search)
	{
		$level1 = DB::select('game.id', array('game_developer.title', 'developer'), 'game.slug', 'game.title', 'game.brief', 'game.imagename', 
		                     'game.imagetop', 'game.imageback', 'game.game_width', 'game.game_height', 'game.gamefile', 'game.gamefile_eng', 
							 'game.status', 'game.base_path')
			->from('game')
			->join('game_developer', 'left')
			->on('game.developer_id', '=', 'game_developer.id')
			->where('game.is_deleted', '=', 0)
			->where('game.title', 'like', '%'.$search.'%')
			->order_by('game.position', 'ASC')
			->execute()
			->as_array();
		
		return $level1;
			
	}
	
	public function fetch($id)
	{
		$data = DB::select('id', 'developer_id', 'slug', 'title', 'brief', 'game_width', 'game_height', 'imagename', 'imagetop', 'imageback', 'gamefile', 
		         		   'gamefile_eng', 'status', 'base_path')
			->from('game')
			->where('id', '=', $id)
			->execute()
			->current();
			
		if ($data)
		{
			$log = Model::factory('Sys_Activity_Log')->last_modified($this->_module_id, $id);
			$data['log_timestamp'] = $log['timestamp'];
			$data['log_user'] = $log['name'];
		}
		
		return $data;
	}
	
	public function fetch_by_slug($slug)
	{
		$data = DB::select('id', 'developer_id', 'slug', 'title', 'brief', 'game_width', 'game_height', 'imagename', 'imagetop', 'imageback', 'gamefile', 
						   'gamefile_eng', 'status', 'base_path')
			->from('game')
			->where('slug', '=', $slug)
			->execute()
			->current();
			
		if ($data)
		{
			$log = Model::factory('Sys_Activity_Log')->last_modified($this->_module_id, $slug);
			$data['log_timestamp'] = $log['timestamp'];
			$data['log_user'] = $log['name'];
		}
		
		return $data;
	}
	
	public function save($data)
	{
		$valid = $this->check($data);
		
		$data['slug'] = URL::title($data['title'], '-', TRUE);
		
		if ( ! $valid->check())
			return $valid->errors('game');

		if ($data['id'])
			return $this->_update($data);
		else
			return $this->_insert($data);
			
	}
		
	protected function _insert($data)
	{
		
		list($added_id) = DB::insert('game', array('developer_id', 'slug', 'title', 'brief', 'game_width', 'game_height', 'imagename', 'imagetop', 'imageback', 
								     'base_path', 'gamefile', 'gamefile_eng', 'status', 'is_deleted'))
			->values(array($data['developer_id'], $data['slug'], $data['title'], $data['brief'], $data['game_width'], $data['game_height'], $data['imagename'], $data['imagetop'], $data['imageback'], 
						   $data['base_path'], $data['gamefile'], $data['gamefile_eng'], $data['status'], 0))
			->execute();
		
		$this->_log_transaction($this->_module_id, $added_id, $data['title'], $data, 1);
		
		return TRUE;
	}
	
	protected function _update($data)
	{
			
		$now = date('Y-m-d H:i:s');

		$query = DB::update('game')
		    ->set(array('developer_id'  => $data['developer_id']))
			->set(array('slug'  => $data['slug']))
			->set(array('title'  => $data['title']))
			->set(array('brief'  => $data['brief']))
			->set(array('game_width'  => $data['game_width']))
			->set(array('game_height'  => $data['game_height']))
			->set(array('imagename'  => $data['imagename']))
			->set(array('imagetop'  => $data['imagetop']))
			->set(array('imageback'  => $data['imageback']))
			->set(array('base_path'  => $data['base_path']))
			->set(array('gamefile'  => $data['gamefile']))
			->set(array('gamefile_eng'  => $data['gamefile_eng']))
			->set(array('status'       => $data['status']))
			->set(array('date_change'       => $now))
			->where('id', '=', $data['id'])
			->execute();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 2);
		
		return TRUE;
	}

	public function delete($id)
	{
		$id = (int) $id;
		
		DB::update('game')
			->set(array('is_deleted' => 1))
			->where('id', '=', $id)
			->execute();
		
		$data = DB::select('id', 'title')
			->from('game')
			->where('id', '=', $id)
			->execute()
			->current();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 3);
		
		return TRUE;
	}
	
	public function us_gamedata($params)
	{
		$limit = "";
		$sql   = "";
		
		if (ctype_digit( (string) $params['limit']) AND ctype_digit( (string) $params['offset']))
		{
			$limit = "LIMIT ".$params['offset'].", ".$params['limit'];
		}
		
		if (array_key_exists('player_id', $params))
		{
			$sql = "AND player_id = ".$params['player_id'];
		}
		
		if (array_key_exists('game_id', $params))
		{
			$sql = "AND game_id = ".$params['game_id'];
		}
		
		if(array_key_exists('id', $params)){
			$sql .= " AND game_id = ".$params['id'];
		}
		
		if(isset($params['id']) && $params['id'] == 28){ //calle-k
			$sql .= " AND game_data != '' ";
		}
		
		return DB::query(Database::SELECT, "
						 SELECT SQL_CALC_FOUND_ROWS game_data, score, max_level
						FROM game_played
						 WHERE 1 ".$sql." ORDER BY ".$params['order_by']." ".$params['sort']." ".$limit)
						 ->execute();
	}
	
	public function us_save_data($data){
		echo "Estoy en us_save_data \n";
		$now = date('Y-m-d H:i:s');
				
		if (array_key_exists('new_game', $data) && $data['new_game']){
			
			echo "Entré al if \n";
			echo "data['data'] " . $data['data'];
			//set database record for game data 'max_level'
			list($record_id) = DB::insert('game_played', array('player_id', 'game_id', 'game_data', 'score', 'max_level', 'date_start', 'date_end', 'gameplay_time'))
			->values(array($data['player_id'], $data['game_id'], $data['data'], '0', '', $now, $now, 0))->execute();
			
			Session::instance()->set('play_id', $record_id);
			
			if(!array_key_exists('game_info', $data)){
				$data['game_info'] = "";
			}
			
			if(!array_key_exists('score', $data)){
				$data['score'] = 0;
			}
			
			//register access to the game
			list($log_id) = DB::insert('game_played_details', array('game_played_id', 'player_id', 'game_id', 'score', 'event_id', 'ip', 'user_agent', 'date_start', 'date_end', 'game_info'))
				->values(array( $record_id, $data['player_id'], $data['game_id'], $data['score'],'1', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $now, $now, $data['game_info']))->execute();
							
		}else{
			
			echo "Entré al else \n";
			echo "data['data'] " . $data['data'];
			echo "Session::instance()->get('play_id')" . Session::instance()->get('play_id');
			
			$gameplay_time = $this->_time_played();
			
			if(!array_key_exists('score', $data)){
				$data['score'] = 0;
			}
			if(!array_key_exists('max_level', $data)){
				$data['max_level'] = 0;
			}
			
			if($data['data'] != ''){
				
				$query = DB::update('game_played')
				->set(array('player_id'  => $data['player_id']))
				->set(array('game_id'  => $data['game_id']))
				->set(array('game_data'  => $data['data']))
				->set(array('score'  => $data['score']))
				->set(array('max_level'  => $data['max_level']))
				->set(array('date_end'       => $now))
				->set(array('gameplay_time'       => $gameplay_time))
				->where('id', '=', Session::instance()->get('play_id'))
				->execute();
				
			}else{
				
				$query = DB::update('game_played')
				->set(array('player_id'  => $data['player_id']))
				->set(array('game_id'  => $data['game_id']))
				->set(array('score'  => $data['score']))
				->set(array('max_level'  => $data['max_level']))
				->set(array('date_end'       => $now))
				->set(array('gameplay_time'       => $gameplay_time))
				->where('id', '=', Session::instance()->get('play_id'))
				->execute();
				
			}
			
			if(array_key_exists('game_info', $data) && $data['game_info'] != ""){
				list($log_id) = DB::insert('game_played_details', array('game_played_id', 'player_id', 'game_id', 'score', 'event_id', 'ip', 'user_agent', 'date_start', 'date_end', 'game_info'))
				->values(array( Session::instance()->get('play_id'), $data['player_id'], $data['game_id'], $data['score'], '1', $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $now, $now, $data['game_info']))->execute();
			}
			
		}
	}

	public function us_set_game_info($data){
			
		$now = date('Y-m-d H:i:s');
		$beforeTenMinutes = date('Y-m-d H:i:s', strtotime($now) - 60 * 10);
		$data['max_level'] = 0;
		
		$maxDateStart = DB::query(Database::SELECT, "SELECT max(date_start) date_start FROM game_played  WHERE game_id = " . $data['game_id'] . " and player_id = " . $data['player_id'])->execute()->current();
		
		$chk = DB::query(Database::SELECT,"SELECT id 
			FROM game_played 
			WHERE game_id = " . $data['game_id'] . " and player_id = " . $data['player_id'] . " 
			and date_start between '" . $beforeTenMinutes . "' and '" . $maxDateStart['date_start'] . "'")->execute()->current();
		
		/* if(!$chk){
			$data['new_game'] = true;
		}else{
			$data['new_game'] = false;
		} */
		
		if(array_key_exists('metodo', $data) && $data['metodo'] != ""){
			
			if($data['metodo'] == "inicioJuego"){
				
				$data['new_game'] = true;
				$game_info = $this->us_save_data($data);
				
			}else if($data['metodo'] == "cambioEscena"){
				
				$data['sceneIn'] = ""; //TODO recuperar
				$data['sceneOut'] = ""; //TODO recuperar
				$game_info = $this->us_scene_changed($data);
				
			}else if($data['metodo'] == "salvarInfo"){
					
				$data['new_game'] = false;
				$game_info = $this->us_save_data($data);
				
			}else if($data['metodo'] == "finJuego"){
				
				$data['mini_game_id'] = 0; //TODO recuperar
				$data['level'] = ""; //TODO recuperar
				$data['extra_info'] = $data['game_info'];
				$game_info = $this->us_game_ended($data);
				
			}
			
		}
		
		//$game_info = Model::factory('Game')->us_save_data($data);
		
	}
	
	public function us_scene_changed($data){
		
		$now = date('Y-m-d H:i:s');
		$gameplay_time = $this->_time_played();
		
		if(!isset($data['game_info'])){
			$data['game_info'] = "";
		}
							
		//adjust time played
		$query = DB::update('game_played')
			->set(array('game_data' => $data['game_info']))
			->set(array('date_end' => $now))
			->set(array('gameplay_time' => $gameplay_time))
			->where('id', '=', Session::instance()->get('play_id'))
			->execute();
			
		//insert the log (check to avoid repeated logs)
		$chk = DB::query(Database::SELECT, "
						SELECT id
						FROM game_played_details
						WHERE event_id = 2 
						AND game_played_id = '".Session::instance()->get('play_id')."' 
						AND player_id = '".$data['player_id']."' 
						AND game_id = '".$data['game_id']."' 
						AND scene_in = '".$data['sceneIn']."' 
						AND scene_out = '".$data['sceneOut']."'")->execute()->current();
						 
		
		if(!$chk) {
			list($log_id) = DB::insert('game_played_details', array('game_played_id', 'player_id', 'game_id', 'event_id', 'scene_in', 'scene_out', 'extra_info' ,'ip', 'user_agent', 'date_start', 'date_end'))
				->values(array(Session::instance()->get('play_id'), $data['player_id'], $data['game_id'], '2', $data['sceneIn'], $data['sceneOut'], $data['game_info'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $now, $now))
				->execute();
		}						 	
		
	}
	
	public function us_game_ended($data){
		$now = date('Y-m-d H:i:s');
		$gameplay_time = $this->_time_played();
		
		list($log_id) = DB::insert('game_played_details', array('game_played_id', 'player_id', 'game_id', 'mini_game_id', 'event_id', 'level', 'extra_info', 'score', 'ip', 'user_agent', 'date_start', 'date_end'))
			->values(array(Session::instance()->get('play_id'), $data['player_id'], $data['game_id'], $data['mini_game_id']*1000, '3', $data['level'], $data['extra_info'], $data['score'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $now, $now))
			->execute();
		
		$total_score = DB::query(Database::SELECT, "
						SELECT SUM( score ) AS total
						FROM game_played_details
						WHERE game_played_id = '".Session::instance()->get('play_id')."' 
						AND player_id = '".$data['player_id']."' 
						AND game_id = '".$data['game_id']."'")
						->execute()->current();
							
		//adjust time played and score
		
		$query = DB::update('game_played')
			->set(array('game_data' => $data['extra_info']))
			->set(array('score'       => $total_score['total']))
			->set(array('max_level'       => $total_score['total'])) 
			->set(array('date_end'       => $now))
			->set(array('gameplay_time'       => $gameplay_time))
			->where('id', '=', Session::instance()->get('play_id'))
			->execute();
			
		echo "play_id de sesión: " . Session::instance()->get('play_id');
		
	}
	
	public function us_maxscore_game($params){
		/*SELECT score AS max_score*/
		return DB::query(Database::SELECT, "
						SELECT SUM( score ) AS max_score 
						FROM game_played
						WHERE player_id = '".$params['player_id']."' 
						AND game_id = '".$params['game_id']."'
						ORDER BY id DESC")
						->execute()->current();
	}
	
	public function top_maxscore_game($params){
		
		return DB::query(Database::SELECT, "
						SELECT Max( gp.score ) AS max_score, p.username, p.avatar, p.id
						FROM game_played gp LEFT JOIN player p ON gp.player_id = p.id
						WHERE gp.game_id = '".$params['game_id']."' AND player_id > 0
						GROUP BY gp.player_id
						ORDER BY max_score DESC
						LIMIT ".$params['limit']."
						")
						->execute();
						
	}
	
	private function _time_played(){
		$now = date('Y-m-d H:i:s');
		$date_start = DB::query(Database::SELECT, "
					SELECT date_start
					FROM game_played
					WHERE id = '".Session::instance()->get('play_id')."'")
					->execute()->current();

		$gameplay_time = 0;
		if($date_start) {
			$gameplay_time = strtotime($now) - strtotime($date_start['date_start']);
		}
		
		return $gameplay_time;
	}

	public function check($data){
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('developer_id', 'not_empty')
			->rule('title', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
		
		return $data;
	}
	
	public function sort($id, $position){
		$query = DB::select('id')
					->from('game')
					->where('is_deleted', '=', 0)
					->order_by('position', 'ASC');
		
		$results = $query->execute()->as_array();

		for ($i=0; $i<count($results); $i++)
		{
			if($position == 'up'){
				if($results[$i]['id'] == $id && $i>0){
					$tmp = $results[($i-1)];
					$results[($i-1)] = $results[$i];
					$results[$i] = $tmp;
					break;
				}
			} else {
				if($results[$i]['id'] == $id && ($i-1) < count($results)){
					$tmp = $results[($i+1)];
					$results[($i+1)] = $results[$i];
					$results[$i] = $tmp;
					$i++;
					break;
				}
			}
		}
		
		for ($i=0; $i<count($results); $i++)
			DB::update('game')->set(array('position' => $i))->where('id', '=', $results[$i]['id'])->execute();
	}
	
	public function setGameClic($game_id,$user_id){
		
		$now = date('Y-m-d H:i:s');
		
		echo "game_id: ".$game_id;
		echo "user_id".$user_id;
		
		$chk = DB::query(Database::SELECT,"SELECT id FROM player_matriz_prueba ".
		"WHERE player_id = " . $user_id . " and (juego_1 = ".$game_id." or juego_2 = ".$game_id." or juego_3 = ".$game_id." or juego_4 = ".$game_id." or juego_5 = ".$game_id.")")->execute()->current();
		
		if($chk){
			list($record_id) = DB::insert('registro_clic_matriz', array('player_id', 'game_id', 'date_stamp'))->values(array($user_id, $game_id, $now))->execute();
		}
		
	}
	
}