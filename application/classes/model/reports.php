<?php defined('SYSPATH') or die('No direct script access.');

class Model_Reports extends Model {
	
	protected $_module_id = 8;
	
	public function get_site_info($params=NULL)
	{
		$site_info = array();
	
		$sql = "";
		$sql_2 = "";
		$sql_3 = "";
		
		if($params['date_start']) {
			$sql .= " AND date_register  >= '".$params['date_start']." 00:00:00'";
			$sql_2 .= " AND date_log  >= '".$params['date_start']." 00:00:00'";
			$sql_3 .= " AND date_start >= '".$params['date_start']." 00:00:00'";
		}
		
		if($params['date_end']) {
			$sql .= " AND date_register  <= '".$params['date_end']." 23:59:59'";
			$sql_2 .= " AND date_log  <= '".$params['date_end']." 23:59:59'";
			$sql_3 .= " AND date_end  <= '".$params['date_end']." 23:59:59'";
		}
		
		
		
		// Get total online games
		$t_games = DB::query(Database::SELECT, "SELECT count(id) as total FROM game WHERE is_deleted = 0 ")->execute()->current();
		if($t_games) {
			$site_info[] = array('key' => 'Total de juegos online', 'val' => $t_games['total']); 
		}
		
		// Get total players regitered
		$t_players = DB::query(Database::SELECT, "SELECT count(id) as total FROM player WHERE is_deleted = 0 ".$sql."")->execute()->current();
		if($t_games) {
			$site_info[] = array('key' => 'Total de jugadores registrados', 'val' => $t_players['total']); 
		}
		
		// Get total de logins de usuarios
		$t_logins = DB::query(Database::SELECT, "SELECT count(id) as total FROM login_logs WHERE successful = 1 ".$sql_2."")->execute()->current();
		if($t_logins) {
			$site_info[] = array('key' => 'Total de logins', 'val' => $t_logins['total']); 
		}
		
		// Get total of games played
		$t_players = DB::query(Database::SELECT, "SELECT count(id) as total, sum(gameplay_time) as playtime, sum(score) as total_score FROM game_played WHERE 1 ".$sql_3."")->execute()->current();
		if($t_games) {
			$site_info[] = array('key' => 'Total de juegos jugados', 'val' => $t_players['total']);
			$site_info[] = array('key' => 'Total de puntos ganados', 'val' => $t_players['total_score']);
			$site_info[] = array('key' => 'Total de horas jugadas', 'val' => round($t_players['playtime']/(60*60), 0));
		}
		
		return $site_info;

			
	}
	
	
	public function get_top($params=NULL,$flag)
	{
		
		if($flag==1)
			$order="DESC";
		if($flag==2)
			$order="ASC";
		$sql = "";
		if($params['date_start']) {
			$sql .= " AND date_start >= '".$params['date_start']." 00:00:00'";
		}
		if($params['date_end']) {
			$sql .= " AND date_end  <= '".$params['date_end']." 23:59:59'";
		}
			//Get top 5 played games
		return DB::query(Database::SELECT, "SELECT g.title AS title, count( gp.game_id ) AS total 
												  FROM game_played gp
												  LEFT JOIN game g ON gp.game_id = g.id
												  WHERE 1 ".$sql."
												  GROUP BY gp.game_id
												  ORDER BY total ".$order."
												  LIMIT 0 , 5")->execute();
	}
	
	
	public function get_points($params=NULL)
	{
		$sql = "";
		if($params['date_start']) {
			$sql .= " AND date_start >= '".$params['date_start']." 00:00:00'";
		}
		if($params['date_end']) {
			$sql .= " AND date_end  <= '".$params['date_end']." 23:59:59'";
		}
	
		return DB::query(Database::SELECT, "SELECT p.username AS usuario, sum( gp.score ) AS total
											FROM game_played gp
											LEFT JOIN player p ON gp.player_id = p.id
											WHERE 1 ".$sql."
											GROUP BY gp.player_id
											ORDER BY total DESC
											LIMIT 0 , 5")->execute();
	}
	
	public function top_games_played($params=NULL){
		$sql = "";
		if($params['date_start']) {
			$sql .= " AND date_start >= '".$params['date_start']." 00:00:00'";
		}
		if($params['date_end']) {
			$sql .= " AND date_end  <= '".$params['date_end']." 23:59:59'";
		}
	
		return DB::query(Database::SELECT, "SELECT p.username AS usuario, count( gp.game_id ) AS total
											FROM game_played gp
											LEFT JOIN player p ON gp.player_id = p.id
											WHERE 1 ".$sql."
											GROUP BY gp.player_id
											ORDER BY total DESC
											LIMIT 0 , 5")->execute();
	}
	
	
	
	
	
	

	public function player_report($params,$items_per_page,$offset,$flag)
	{
		
		$sql = "";
		if($params['free_text']) {
			$sql .= " AND (p.username like '%".$params['free_text']."%' OR g.title like '%".$params['free_text']."%')";
		}
		if($params['state_id']) {
			$sql .= " AND p.state_id  = '".$params['state_id']."'";
		}
		if($params['developer_id']) {
			$sql .= " AND g.developer_id  = '".$params['developer_id']."'";
		}
		if($params['game_id']) {
			$sql .= " AND gp.game_id  = '".$params['game_id']."'";
		}
		if($params['school_year_id']) {
			$sql .= " AND p.school_year_id  = '".$params['school_year_id']."'";
		}
		if($params['asignature_id']) {
			$sql .= " AND p.asignature_id  = '".$params['asignature_id']."'";
		}
		if($params['gender']) {
			$sql .= " AND p.gender  = '".$params['gender']."'";
		}
		if($params['activity_id']) {
			$sql .= " AND p.activity_id  = '".$params['activity_id']."'";
		}
		if($params['date_start']) {
			$sql .= " AND gp.date_start  >= '".$params['date_start']." 00:00:00'";
		}
		if($params['date_end']) {
			$sql .= " AND gp.date_start  <= '".$params['date_end']." 23:59:59'";
		}
		if($params['how_id']) {
			$sql .= " AND p.how_id  = '".$params['how_id']."'";
		}
		if($params['source_id']) {
			$sql .= " AND p.source_id  = '".$params['source_id']."'";
		}
		if($params['location_id']) {
			$sql .= " AND p.location_id  = '".$params['location_id']."'";
		}
		if($params['order_by']):
			$order_by  = $params['order_by'];
		else:
			$order_by = "tot_score DESC";
		endif;
		
		if(!empty($offset)):
			$offst="OFFSET ".$offset;
		else:
			$offst="";
		endif;
		
		if($flag==1)
		{
		
			return DB::query(Database::SELECT, "
				  SELECT p.username as username, g.title as game, SUM(score) as tot_score, SUM(gameplay_time) as tot_time, count(gp.id) as num_games
					  FROM game_played gp 
					  LEFT JOIN player p ON gp.player_id = p.id
					  LEFT JOIN game g ON gp.game_id = g.id
					  WHERE p.is_deleted = 0 AND g.is_deleted = 0 ".$sql."
					  GROUP BY gp.player_id, gp.game_id
					  ORDER BY ".$order_by.""); 
		}
				  
		if($flag==2)
		{
			return	DB::query(Database::SELECT, "
				  SELECT p.username as username, g.title as game, SUM(score) as tot_score, SUM(gameplay_time) as tot_time, count(gp.id) as num_games
					  FROM game_played gp 
					  LEFT JOIN player p ON gp.player_id = p.id
					  LEFT JOIN game g ON gp.game_id = g.id
					  WHERE p.is_deleted = 0 AND g.is_deleted = 0 ".$sql."
					  GROUP BY gp.player_id, gp.game_id
					  ORDER BY ".$order_by."
					  LIMIT ".$items_per_page." 
					  ".$offst."")->execute()->as_array();
				 
		}
				
	}

	
}