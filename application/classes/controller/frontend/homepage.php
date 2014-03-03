<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Frontend_Homepage extends Controller_Frontend_Template {
	
	public function action_index(){
		
		$user_front = Session::instance()->get('identity_front');
		$params['status'] = 1;
		$tmp_favorites = Model::factory('Player')->get_favorites($user_front['id']);
		$banner_big = Model::factory('Banner')->fetch_all(array('type_id' => '1'));
		$banner_small = Model::factory('Banner')->fetch_all(array('type_id' => '2'));
		$games = Model::factory('Game')->fetch_all($params);
		
		$favorites = array();
		foreach($tmp_favorites as $row) {
			$favorites[] = $row['id'];
		}
		
		$games_matriz = array();
		
		if(isset($user_front['source_id']) && $user_front['source_id'] == 8){
			$games_matriz = Model::factory('Game')->fetch_matriz($user_front['id']);
		}
		
		$view = View::factory('frontend/homepage/index')
			->set('banner_big', $banner_big)
			->set('banner_small', $banner_small)
			->set('favorites', $favorites)
			->set('games', $games)
			->set('games_matriz',$games_matriz)
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
		$this->template->content = $view;
	}

	public function action_pages()
	{

		$section = $this->request->param('section');
		$page = $this->request->param('page');
		
		$content = Model::factory('Page')->fetch_from_uri($section, $page);

		$view = View::factory('frontend/homepage/pages')
			->set('content', $content)
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
	
		$this->template->content = $view;
	}

	public function action_calendar()
	{

		$content = Model::factory('Calendar')->fetch_active(0);

		$view = View::factory('frontend/homepage/calendar')
			->set('calendar', $content)
			->set('months', array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"))
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
	
		$this->template->content = $view;
	}

	public function action_noticias()
	{

		$content = Model::factory('News')->fetch_active(10);

		$view = View::factory('frontend/homepage/news')
			->set('news', $content)
			->set('months', array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"))
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
	
		$this->template->content = $view;
	}

	public function action_talleres()
	{

		$data = Model::factory('Page')->fetch_from_uri('talleres', '');
		$content = Model::factory('Talleres')->fetch_active(50);

		$view = View::factory('frontend/homepage/talleres')
			->set('talleres', $content)
			->set('content', $data)
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
	
		$this->template->content = $view;
	}

	public function action_colaboradores()
	{

		$view = View::factory('frontend/homepage/colaboradores')
			->set('colaboradores', Model::factory('Colaboradores')->fetch_active())
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
	
		$this->template->content = $view;
	}

	public function action_search()
	{
		$term = Arr::get($_GET, 'search', '');
		
		$view = View::factory('frontend/homepage/search')
			->set('search', Model::factory('Page')->search($term))
			->set('registry', Model::factory('Sys_Registry')->fetch_all());
	
		$this->template->content = $view;
	}

}