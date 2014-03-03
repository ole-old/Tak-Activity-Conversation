<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Reports_Game extends Controller_Backend_Template {
	
	public $game;
	
	public function before()
	{
		parent::before();
		
		$this->reports = new Model_ReportGame;
		$this->states = new Model_Catstate;
		$this->school_years = new Model_Catschoolyear;
		$this->developers = new Model_GameDeveloper;
		$this->games = new Model_Game;
		$this->activities = new Model_Catfactivity;
		$this->asignatures = new Model_Catasignature;
		$this->how_id = new Model_Cathow;
		$this->source_id = new Model_Catsource;
		$this->location_id = new Model_Catlocation;
		$this->the_action = $this->_action;

	}
	
	public function action_index()
	{
	
		$page = (int)Arr::get($_GET, 'page',1);
		if($page==1)
			$_SESSION['order_by']="";
			
		$items_per_page = 20;
		$offset   = ($page - 1) * $items_per_page;
					
		$state_id = Arr::get($_GET, 'state_id', '');
		$school_year_id = Arr::get($_GET, 'school_year_id', '');
		$asignature_id = Arr::get($_GET, 'asignature_id', '');
		$developer_id = Arr::get($_GET, 'developer_id', '');
		$game_id = Arr::get($_GET, 'game_id', '');
		$activity_id = Arr::get($_GET, 'activity_id', '');
		$date_start = Arr::get($_GET, 'date_start', '');
		$date_end = Arr::get($_GET, 'date_end', '');
		$gender = Arr::get($_GET, 'gender', '');
		$source_id = Arr::get($_GET, 'source_id', '');
		$location_id = Arr::get($_GET, 'location_id', '');
		$how_id= Arr::get($_GET, 'how_id', '');
		$order_by1= Arr::get($_GET, 'order_by', '');
		if(!empty($order_by1)){
			$_SESSION['order_by']=$order_by1;
			}
		$params = array('state_id' => $state_id, 'developer_id' => $developer_id, 'game_id' => $game_id, 
		                'school_year_id' => $school_year_id, 'date_start' => $date_start, 'date_end' => $date_end, 
						'activity_id' => $activity_id, 'asignature_id' => $asignature_id, 'gender' => $gender, 'source_id' => $source_id, 'location_id' => $location_id, 'how_id' => $how_id, 'order_by' => $_SESSION['order_by']);
	
		$total =  $this->reports->player_report($params,$items_per_page,null,1)->execute()->count();

		$pagination = Pagination::factory(array(
        'items_per_page'    =>  $items_per_page,
        'total_items'       =>  $total,
		));	
		
		
		$results = $this->reports->player_report($params,$items_per_page,$offset,2); 
		$page_links=$pagination->render();
		
	

		$view = View::factory('backend/reports/'.$this->_controller.'/index')
			->set('controller', $this->_controller)
			->set('params', $params)
			->set('states', $this->states->fetch_all())
			->set('school_years', $this->school_years->fetch_all())
			->set('asignatures', $this->asignatures->fetch_by_school_year($school_year_id))
			->set('developers', $this->developers->fetch_all())
			->set('games', $this->games->fetch_all())
			->set('activities', $this->activities->fetch_all())
			->set('source_id', $this->source_id->fetch_all())
			->set('location_id', $this->location_id->fetch_all())
			->set('how_id', $this->how_id->fetch_all())
			->set('the_action', 'index')
			->set('data', $results)
			->set('page_links', $page_links)
			->set('page', $page);
			
	
			$this->template->content = $view;

	}
	

	public function action_report(){
	
		$state_id = Arr::get($_GET, 'state_id', '');
		$school_year_id = Arr::get($_GET, 'school_year_id', '');
		$asignature_id = Arr::get($_GET, 'asignature_id', '');
		$developer_id = Arr::get($_GET, 'developer_id', '');
		$game_id = Arr::get($_GET, 'game_id', '');
		$activity_id = Arr::get($_GET, 'activity_id', '');
		$date_start = Arr::get($_GET, 'date_start', '');
		$date_end = Arr::get($_GET, 'date_end', '');
		$gender = Arr::get($_GET, 'gender', '');
		$source_id = Arr::get($_GET, 'source_id', '');
		$location_id = Arr::get($_GET, 'location_id', '');
		$how_id= Arr::get($_GET, 'how_id', '');
		$order_by1= Arr::get($_GET, 'order_by', '');
		if(!empty($order_by1)){
			$_SESSION['order_by']=$order_by1;
			}
		$params = array('state_id' => $state_id, 'developer_id' => $developer_id, 'game_id' => $game_id, 
		                'school_year_id' => $school_year_id, 'date_start' => $date_start, 'date_end' => $date_end, 
						'activity_id' => $activity_id, 'asignature_id' => $asignature_id, 'gender' => $gender, 'source_id' => $source_id, 'locatione_id' => $location_id, 'how_id' => $how_id, 'order_by' => $_SESSION['order_by']);
	

			$result=$this->reports->player_report($params,null,null,1)->execute();
			
			$view = View::factory('backend/reports/'.$this->_controller.'/index')
			->set('controller', $this->_controller)
			->set('params', $params)
			->set('states', $this->states->fetch_all())
			->set('school_years', $this->school_years->fetch_all())
			->set('asignatures', $this->asignatures->fetch_by_school_year($school_year_id))
			->set('developers', $this->developers->fetch_all())
			->set('games', $this->games->fetch_all())
			->set('activities', $this->activities->fetch_all())
			->set('how_id', $this->how_id->fetch_all())
			->set('source_id', $this->source_id->fetch_all())
			->set('location_id', $this->location_id->fetch_all())
			->set('the_action', 'report')
			->set('data', $result);
			
			$this->template->content = $view;
	
			header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
			header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
			header("Pragma: public");
			header("Expires: 0");	
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: public");
			header("Content-Description: File Transfer");										
			session_cache_limiter("must-revalidate");
			header('Content-Type: application/vnd.ms-excel;');
			header('Content-Disposition: attachment; filename=Reporte_juegos_'.date('Y-m-d-H-i-s').'.xls');

	
	}
	

}
