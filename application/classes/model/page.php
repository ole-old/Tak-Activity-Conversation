<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page extends Model {
	
	protected $_module_id = 7;
	
	public function fetch_all($order_by, $sort)
	{
		$pages = array();
		
		$level1 = DB::select('id', 'title', 'status')
			->from('page')
			->where('is_deleted', '=', 0)
			->where('parent_id', 'IS', NULL)
			->order_by($order_by, $sort)
			->execute();
		
		foreach ($level1 as $page)
		{
			$page['level'] = 1;
			$page['parent_id'] = 0;
			$pages[] = $page;
			
			
			$level2 = DB::select('id', 'title', 'status')
				->from('page')
				->where('is_deleted', '=', 0)
				->where('parent_id', '=', $page['id'])
				->order_by($order_by, $sort)
				->execute();
			
			foreach ($level2 as $subpage)
			{
				$subpage['level'] = 2;
				$subpage['parent_id'] = $page['id'];
				$pages[] = $subpage;
			}
			
		}
		
		return $pages;
		
	}
	
	public function fetch($id)
	{
		$data = DB::select('id', 'slug', 'title', 'content', 'redirect_to', 'status')
			->from('page')
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

	public function search($term)
	{
		$data = DB::select('page.id', 'page.parent_id', 'page.slug', 'page.title', 'page.redirect_to', array('pg.slug', 'pslug'))
			->from('page')
			->join(array('page', 'pg'), 'LEFT')
			->on('pg.id', '=', 'page.parent_id')
			->where('page.is_deleted', '=', 0)
			->where('page.status', '=', 1)
			->where_open()
        		->or_where('page.title', 'LIKE', '%'.$term.'%')
        		->or_where('page.content', 'LIKE', '%'.$term.'%')
			->where_close()
			->execute()
			->as_array();
		
		for($i=0; $i<count($data); $i++){
			if(strlen($data[$i]['redirect_to'])>0){
				$data[$i]['link'] = $data[$i]['redirect_to'];
			} else {
				if($data[$i]['parent_id'] > 0)
					$data[$i]['link'] = $data[$i]['pslug']."/".$data[$i]['slug'];
				else
					$data[$i]['link'] = $data[$i]['slug'];
			}
		}
		
		return $data;
	}
	
	public function fetch_sections()
	{
		return DB::select('id', 'title', 'status')
			->from('page')
			->where('is_deleted', '=', 0)
			->where('parent_id', 'IS', NULL)
			->order_by('position', 'ASC')
			->execute();
	}
	
	public function save($data)
	{
//		$valid = $this->check($data);
		
//		if ( ! $valid->check())
//			return $valid->errors('page');

		$data['slug'] = URL::title($data['title'], '-', TRUE);
		$data['parent_id'] = Arr::get($data, 'parent_id', NULL);

		if ($data['id'])
			$this->_update($data);
		else
			$data['id'] = $this->_insert($data);
		
		return true;
	}
	
	public function delete($id)
	{
		$id = (int) $id;
		
		DB::update('page')
			->set(array('is_deleted' => 1))
			->where('id', '=', $id)
			->execute();
		
		$data = DB::select('id', 'title')
			->from('page')
			->where('id', '=', $id)
			->execute()
			->current();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 3);
		
		return TRUE;
	}
	
	public function sort($id, $position, $parent_id)
	{
		$sort = ($position == 'up') ? 'DESC' : 'ASC';
		
		$current = DB::select('id', 'position')->from('page')->where('id', '=', $id)->execute()->current();
		
		$next = array('id' => NULL, 'position' => NULL);
		
		$query = DB::select('id', 'position')->from('page')->where('is_deleted', '=', 0)->order_by('position', $sort);
		
		if ($parent_id)
		{
			$query->where('parent_id', '=', $parent_id);
		}
		else
		{
			$query->where('parent_id', 'IS', NULL);
		}
		
		$results = $query->execute();
		
		for ($i=0; $i<count($results); $i++)
		{
			if ( ! $next['id'])
			{
				if ($results[$i]['id'] == $id)
				{
					$next['id'] = $results[$i+1]['id'];
					$next['position'] = $results[$i+1]['position'];
				}
			}
		}
		
		if ($next['id'])
		{
			DB::update('page')->set(array('position' => $next['position']))->where('id', '=', $current['id'])->execute();
			DB::update('page')->set(array('position' => $current['position']))->where('id', '=', $next['id'])->execute();
		}
	}
	
	protected function _insert($data)
	{
		$data['position'] = $this->_position($data['parent_id']);

		list($page_id) = DB::insert('page', array('parent_id', 'slug', 'title', 'content', 'redirect_to', 'position', 'status', 'is_deleted'))
			->values(array($data['parent_id'], $data['slug'], $data['title'], $data['content'], $data['redirect_to'], $data['position'], $data['status'], 0))
			->execute();
		
		$this->_log_transaction($this->_module_id, $page_id, $data['title'], $data, 1);
		
		return $page_id;
	}


	protected function _update($data)
	{
		$parent_id = DB::select('parent_id')
			->from('page')
			->where('id', '=', $data['id'])
			->limit(1)
			->offset(0)
			->execute()
			->get('parent_id', NULL);
		
		$query = DB::update('page')
			->set(array('slug'        => $data['slug']))
			->set(array('title'       => $data['title']))
			->set(array('content'     => $data['content']))
			->set(array('redirect_to' => $data['redirect_to']))
			->set(array('status'      => $data['status']))
			->where('id', '=', $data['id']);
		
		if ($parent_id != $data['parent_id'])
		{
			$data['position'] = $this->_position($data['parent_id']);
			
			$query->set(array('parent_id' => $data['parent_id']))
				->set(array('position'    => $data['position']));
		}
		
		$query->execute();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['title'], $data, 2);
		
		return TRUE;
	}
	
	protected function _position($parent_id)
	{
		$query = DB::select(array(DB::expr('`position` + 1'), 'position'))
			->from('page')
			->where('is_deleted', '=', 0)
			->order_by('position', 'DESC')
			->limit(1)
			->offset(0);
			
		if ($parent_id)
		{
			$query->where('parent_id', '=', $parent_id);
		}
		
		return $query->execute()->get('position', 1);
	}
	
	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('title', 'not_empty')
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
		
		return $data;
	}
	
	public function menu($uri)
	{
		
		$mytmpuri = explode('?', $uri);
		$uri = $mytmpuri[0];
		$myuri = explode('/', $uri);
		$section = current($myuri);
		
		$category = (isset($myuri[1]))?$myuri[1]:"";
		$subcategory = (isset($myuri[2]))?$myuri[2]:"";
		
//		$menu = array(array('id'=>0, 'slug'=>'', 'title'=>'Inicio', 'redirect_to'=>'', 'link'=>'/', 'selected'=>'', 'submenu'=>array()));
		
		$results = DB::select('page.id', 'page.slug', 'page.title', 'page.redirect_to')
			->from('page')
			->where('page.parent_id', 'IS', NULL)
			->where('page.is_deleted', '=', 0)
			->where('page.status', '=', 1)
			->order_by('page.position', 'ASC')
			->execute()
			->as_array();
		
		for ($i=0; $i<count($results); $i++)
		{
			$results[$i]['selected'] = ($results[$i]['slug'] == $section) ? 'on' : '';
			if(strlen($results[$i]['redirect_to'])>0){
				$results[$i]['link'] = $results[$i]['redirect_to'];
				if($uri == $results[$i]['redirect_to'])
					$results[$i]['selected'] = 'on';
			} else {
				$results[$i]['link'] = $results[$i]['slug'];
			}
			
			
			if($results[$i]['slug'] == 'talleres'){
				$tall = Model::factory('Talleres')->fetch_active(50);
				$results[$i]['submenu'] = array();
				foreach($tall as $tll)
					$results[$i]['submenu'][] = array('id'=>$tll['id'], 'slug'=>$tll['title'], 'title'=>$tll['title'], 'redirect_to'=>'', 'link'=>'talleres', 'selected'=>'');
			} else {
				$results[$i]['submenu'] = DB::select('page.id', 'page.slug', 'page.title', 'page.redirect_to')
					->from('page')
					->where('page.parent_id', '=', $results[$i]['id'])
					->where('page.is_deleted', '=', 0)
					->where('page.status', '=', 1)
					->order_by('page.position', 'ASC')
					->execute()
					->as_array();

				for ($j=0; $j<count($results[$i]['submenu']); $j++)
				{
					$results[$i]['submenu'][$j]['selected'] = ($results[$i]['submenu'][$j]['slug'] == $section) ? 'on' : '';
					if(strlen($results[$i]['submenu'][$j]['redirect_to'])>0){
						$results[$i]['submenu'][$j]['link'] = $results[$i]['submenu'][$j]['redirect_to'];
						if($uri == $results[$i]['submenu'][$j]['redirect_to'])
							$results[$i]['submenu'][$j]['selected'] = 'on';
					} else {
						$results[$i]['submenu'][$j]['link'] = $results[$i]['slug'].'/'.$results[$i]['submenu'][$j]['slug'];
					}
				}
			}
			
			$menu[] = $results[$i];
		}
		
		return $menu;
		
	}

	public function get_title($uri)
	{
		$section = current(explode('/', $uri));
								   
		return DB::select('title')
			->from('page')
			->where('is_deleted', '=', 0)
			->where('parent_id', 'IS', NULL)
			->where('slug', '=', $section)
			->limit(1)
			->offset(0)
			->execute()
			->get('title', 0);
	}

	public function fetch_from_uri($section, $page)
	{
		$result = DB::select('id', array('id', 'id_section'), 'title', 'content')
			->from('page')
			->where('is_deleted', '=', 0)
			->where('parent_id', 'IS', NULL)
			->where('slug', '=', $section)
			->limit(1)
			->offset(0)
			->execute()
			->current();
			
//		$sectbanns = $this->fetch_banners($result['id']);
		
		$parent_id = $result['id'];
		
		if ($page)
		{
			$result = DB::select('id', array('parent_id', 'id_section'), 'title', 'content')
				->from('page')
				->where('is_deleted', '=', 0)
				->where('parent_id', '=', $parent_id)
				->where('slug', '=', $page)
				->limit(1)
				->offset(0)
				->execute()
				->current();
		}
		
		if ( ! $result)
			return FALSE;
		
		$result['related'] = array();
		$related = DB::select('slug', 'title', 'redirect_to')
			->from('page')
			->where('is_deleted', '=', 0)
			->where('status', '=', 1)
			->where('parent_id', '=', $parent_id)
			->order_by('position', 'ASC')
			->execute();
			
		for ($i=0; $i<count($related); $i++)
		{
			$result['related'][$i] = $related[$i];
			$result['related'][$i]['selected'] = ($related[$i]['slug'] == $page) ? 'class="on"' : '';
			$result['related'][$i]['link'] = ($related[$i]['redirect_to']) ? $related[$i]['redirect_to'] : $section.'/'.$related[$i]['slug'];
		}

		return $result;
	}

	
}