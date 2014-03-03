<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Reports_Dashboard extends Controller_Backend_Template {
	
	public $game;
	
	public function before()
	{
		parent::before();
		
		$this->reports = new Model_Reports;
	}
	
	public function action_index()
	{
	
		$date_start = Arr::get($_GET, 'date_start', '');
		$date_end = Arr::get($_GET, 'date_end', '');
		$params = array('date_start' => $date_start, 'date_end' => $date_end);

	
		$view = View::factory('backend/reports/'.$this->_controller.'/index')
			->set('controller', $this->_controller)
			->set('params', $params)
			->set('top_games', $this->reports->get_top($params,1))
			->set('top_games2', $this->reports->get_top($params,2))
			->set('top_points', $this->reports->get_points($params))
			->set('top_played', $this->reports->top_games_played($params))
			->set('site_info', $this->reports->get_site_info($params));

		$this->template->content = $view;
	}
	

}