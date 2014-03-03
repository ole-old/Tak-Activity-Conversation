<?php

  //******************
  //Create scripts:
  //******************
  
	$mysqli = new mysqli("localhost", "root", "kawabunga", "inoma");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	//Generate player script
	$sql = "SELECT * FROM player WHERE local_processed = 0 LIMIT 1000;";

	if (!$mysqli->multi_query($sql)) {
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	do{
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			foreach($result as $row):
			
				$player_script .= "
				INSERT INTO local_player (school_id, school_year_id, username, password, school, answer1, answer2, answer3, avatar, birthday, fullname, email, gender, curp, state_id, asignature_id, asignature_other, activity_id, activity_other, school_year_other, how, date_register, total_score, status, is_deleted, how_id, location_id, format_id, source_id, card_number, privacy_policy, confirmation_card, tmp_id) VALUES 
				('".$row['school_id']."', '".$row['school_year_id']."', '".$row['username']."', '".$row['password']."', '".$row['school']."', '".$row['answer1']."', '".$row['answer2']."', '".$row['answer3']."', '".$row['avatar']."', '".$row['birthday']."', '".$row['fullname']."', '".$row['email']."', '".$row['gender']."', '".$row['curp']."', '".$row['state_id']."', '".$row['asignature_id']."', '".$row['asignature_other']."', '".$row['activity_id']."', '".$row['activity_other']."', '".$row['school_year_other']."', '".$row['how']."', '".$row['date_register']."', '".$row['total_score']."', '".$row['status']."', '".$row['is_deleted']."', '".$row['how_id']."', '".$row['location_id']."', '".$row['format_id']."', '".$row['source_id']."', '".$row['card_number']."', '".$row['privacy_policy']."', '".$row['confirmation_card']."', '".$row['tmp_id']."');";
				$up_player_script .= "UPDATE player SET local_processed = 1 WHERE id = '".$row['id']."';";
				
			endforeach;
			
			echo $player_script."<br /><br />";
			echo $up_player_script."<br /><br />";
			
			$res->free();
			
		}
		
	} while ($mysqli->more_results() && $mysqli->next_result());
  
  
  //Generate player_favorites script
  $sql = "SELECT player_id, game_id FROM player_favorites WHERE local_processed = 0 LIMIT 1000;";
  
  if (!$mysqli->multi_query($sql)) {
    echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
  }
  
  do {
    if ($res = $mysqli->store_result()) {
      $result = $res->fetch_all(MYSQLI_ASSOC);
      
      
      
      foreach($result as $row):
        $player_fav_script .= "INSERT INTO local_player_favorites (player_id, game_id) VALUES ('".$row['player_id']."', '".$row['game_id']."');";
        
        $up_player_fav_script .= "UPDATE player_favorites SET local_processed = 1 WHERE player_id = '".$row['player_id']."' AND game_id = '".$row['game_id']."';";
      endforeach;
      
      echo $player_fav_script."<br /><br />";
      echo $up_player_fav_script."<br /><br />";
      
      
      $res->free();
    }
  } while ($mysqli->more_results() && $mysqli->next_result());
  
  
	//Generate login_logs script
	$sql = "SELECT id, credentials, successful, date_log, ip, user_agent FROM login_logs;";
	
	if(!$mysqli->multi_query($sql)){
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	do{
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			foreach($result as $row):
			
				$login_logs_script .= "INSERT INTO local_login_logs (id, credentials, successful, date_log, ip, user_agent) VALUES " .
				"(" . $row['id'] . ", '" . $row['credentials'] . "', " . $row['successful'] . ", '" . $row['date_log'] . "', '" . $row['ip'] . "', '" . $row['user_agent'] . "');";
				
				$up_login_logs_script .= "UPDATE login_logs SET local_processed = 1 WHERE id = '" . $row['id'] . "';";
				
			endforeach;
			
			echo $login_logs_script."<br /><br />";
			echo $up_login_logs_script."<br /><br />";
			
			$res->free();
			
		}
		
	} while ($mysqli->more_results() && $mysqli->next_result());
	
	//Generate game_played script
	$sql = "SELECT id, player_id, game_id, game_data, score, max_level, date_start, date_end, gameplay_time FROM game_played;";
	
	if(!$mysqli->multi_query($sql)){
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	do{
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			foreach($result as $row):
				
				$game_played_script .= "INSERT INTO local_game_played (id, player_id, game_id, game_data, score, max_level, date_start, date_end, gameplay_time) VALUES " .
				"(" . $row['id'] . ", " . $row['player_id'] . ", " . $row['game_id'] . ", '" . $row['game_data'] . "', " . $row['score'] . ", " . $row['max_level'] . ", '" . $row['date_start'] . "', '" . $row['date_end'] . "', " . $row['gameplay_time'] . ");";
				
				$up_game_played_script .= "UPDATE game_played SET local_processed = 1 WHERE id = '" . $row['id'] . "';";
				
			endforeach;
			
			echo $game_played_script."<br /><br />";
			echo $up_game_played_script."<br /><br />";
			
			$res->free();
			
		}
		
	} while ($mysqli->more_results() && $mysqli->next_result());
	
	//Generate game_played_details script
	$sql = "SELECT id, game_played_id, player_id, game_id, mini_game_id, event_id, scene_in, scene_out, level, extra_info, score, ip, user_agent, date_start, date_end, game_info FROM game_played_details;";
	
	if(!$mysqli->multi_query($sql)){
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}
	
	do{
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			foreach($result as $row):
				
				$game_played_details_script .= "INSERT INTO local_game_played_details (id, game_played_id, player_id, game_id, mini_game_id, event_id, scene_in, scene_out, level, extra_info, score, ip, user_agent, date_start, date_end, game_info) " .
				"VALUES (" . $row['id'] . ", " . $row['game_played_id'] . ", " . $row['player_id'] . ", " . $row['game_id'] . ", " . $row['mini_game_id'] . ", " . $row['event_id'] . ", '" . $row['scene_in'] . "', '" . $row['scene_out'] . "', " . $row['level'] . ", '" . $row['extra_info'] . "', " . $row['score'] . ", '" . $row['ip'] . "', '" . $row['user_agent'] . "', '" . $row['date_start'] . "', '" . $row['date_end'] . "', '" . $row['game_info'] . "');";
				
				$up_game_played_details_script .= "UPDATE game_played_details SET local_processed = 1 WHERE id = '" . $row['id'] . "';";
				
			endforeach;
			
			echo $game_played_details_script."<br /><br />";
			echo $up_game_played_details_script."<br /><br />";
			
			$res->free();
			
		}
		
	} while ($mysqli->more_results() && $mysqli->next_result());
  
  
  $mysqli->close;
  
  
	//******************
	//Execute scripts REMOTE:
	//******************

	$mysqli = new mysqli("localhost", "root", "root", "inoma"); //TODO cambiar a conexión remota
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sql = $player_script . $player_fav_script . $login_logs_script . $game_played_script . $game_played_details_script;

	if (!$mysqli->multi_query($sql)) {
		echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	do {
		if ($res = $mysqli->store_result()) {
			var_dump($res->fetch_all(MYSQLI_ASSOC));
			$res->free();
		}
	} while ($mysqli->more_results() && $mysqli->next_result());

	$mysqli->close;
  
  
	//******************
	//Execute scripts LOCAL:
	//******************

	$mysqli = new mysqli("localhost", "root", "root", "inoma");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$sql = $up_player_script . $up_player_fav_script . $up_login_logs_script . $up_game_played_script . $up_game_played_details_script;

	if (!$mysqli->multi_query($sql)) {
		echo "Multi query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	do {
		if ($res = $mysqli->store_result()) {
			var_dump($res->fetch_all(MYSQLI_ASSOC));
			$res->free();
		}
	} while ($mysqli->more_results() && $mysqli->next_result());

	$mysqli->close;
  
?>