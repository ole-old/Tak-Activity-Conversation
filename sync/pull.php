<?php

	//******************
	//Create scripts from REMOTE:
	//******************

	$mysqli = new mysqli("localhost", "root", "root", "inoma_feed");
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
	//Generate game script
	$sql = "SELECT id, developer_id, slug, title, brief, game_width, game_height, imagename, imagetop, imageback, base_path, gamefile, gamefile_eng, hash, status, is_deleted, position FROM game WHERE 1;";
	
	if (!$mysqli->multi_query($sql)) {
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	do {
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			$game_script = "TRUNCATE TABLE game;";
			foreach($result as $row):
			
				$game_script .= "INSERT INTO game (id, developer_id, slug, title, brief, game_width, game_height, imagename, imagetop, imageback, base_path, gamefile, gamefile_eng, hash, status, is_deleted, position) " . 
				"VALUES (" . $row['id'] . ", " . $row['developer_id'] . ", '" . $row['slug'] . "', '" . $row['title'] . "', '" . $row['brief'] . "', " . $row['game_width'] . ", " . $row['game_height'] . ", '" . $row['imagename'] . "', '" . $row['imagetop'] . "', '" . $row['imageback'] . "', '" . $row['base_path'] . "', '" . $row['gamefile'] . "', '" . $row['gamefile_eng'] . "', '" . $row['hash'] . "', " . $row['status'] . ", " . $row['is_deleted'] . ", " . $row['position'] . ");";
				
			endforeach;
			
			echo $game_script."<br /><br />";
			echo "Generación de scripts finalizada (remote)<br />"; 
			
			$res->free();
			
		}
	
	} while ($mysqli->more_results() && $mysqli->next_result());
	
	//Generate game_developer script
	$sql = "SELECT id, title, brief, status, is_deleted FROM game_developer WHERE 1;";
	
	if (!$mysqli->multi_query($sql)) {
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	do {
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			$game_developer_script = "TRUNCATE TABLE game;";
			foreach($result as $row):
			
				$game_developer_script .= "INSERT INTO game_developer (id, title, brief, status, is_deleted) " .
				"VALUES (" . $row['id'] . ", '" . $row['title'] . "', '" . $row['brief'] . "', " . $row['status'] . ", " . $row['is_deleted'] . ");";
				
			endforeach;
			
			echo $game_developer_script."<br /><br />";
			echo "Generación de scripts finalizada (remote)<br />"; 
			
			$res->free();
			
		}
	
	} while ($mysqli->more_results() && $mysqli->next_result());

	//Generate page script
	$sql = "SELECT * FROM page WHERE 1;";

	if (!$mysqli->multi_query($sql)) {
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	do {
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			$page_script = "TRUNCATE TABLE page;";
			foreach($result as $row):
			
				if(!$row['parent_id']){
					$row['parent_id'] = 'NULL';
				}
				$page_script .= "INSERT INTO page (parent_id, slug, title, content, redirect_to, position, status, is_deleted) VALUES 
				(".$row['parent_id'].", '".$row['slug']."', '".$row['title']."', '".$row['content']."', '".$row['redirect']."', '".$row['position']."', '".$row['status']."', '".$row['is_deleted']."');";
				
			endforeach;
			
			echo $page_script."<br /><br />";
			echo "Generación de scripts finalizada (remote)<br />"; 
			
			$res->free();
			
		}
	
	} while ($mysqli->more_results() && $mysqli->next_result());
	
	
	//Generate banner script
	$sql = "SELECT id, type_id, title, imagename, url, position, status, is_deleted FROM banner WHERE 1;";
	
	if (!$mysqli->multi_query($sql)) {
		echo "Query failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	do {
	
		if ($res = $mysqli->store_result()) {
		
			$result = $res->fetch_all(MYSQLI_ASSOC);
			$banner_script = "TRUNCATE TABLE game;";
			foreach($result as $row):
			
				$banner_script .= "INSERT INTO banner (id, type_id, title, imagename, url, position, status, is_deleted) " .
				"VALUES (" . $row['id'] . ", " . $row['type_id'] . ", '" . $row['title'] . "', '" . $row['imagename'] . "', '" . $row['url'] . "', " . $row['position'] . ", " . $row['status'] . ", " . $row['is_deleted'] . ");";
				
			endforeach;
			
			echo $banner_script."<br /><br />";
			echo "Generación de scripts finalizada (remote)<br />"; 
			
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

	$sql = $page_script;

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

	echo "Ejecución de scripts finalizada (Local)<br />"; 

?>