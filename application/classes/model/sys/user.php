<?php defined('SYSPATH') or die('No direct script access.');

class Model_Sys_User extends Model {
	
	protected $_module_id = 6;
	
	public function login($username, $password, $remember)
	{
		$user = DB::select('id', 'name', 'password')
			->from('sys_user')
			->where('email', '=', $username)
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		if( ! $user)
			return FALSE;
			
		if($user['password'] != $this->password($password))
			return FALSE;
		
		Session::instance()->set('identity', $user);
		
		$this->_log_session($user['id'], 'login');
		
		return TRUE;
	}
	
	public function logout()
	{
		$user = Session::instance()->get('identity');
		$this->_log_session($user['id'], 'logout');
		Session::instance()->delete('identity');
		return TRUE;
	}
	
	public function fetch_all($order_by, $sort)
	{
		$sub = DB::select('ssl.user_id', 'ssl.timestamp')
			->from(array('sys_session_log','ssl'))
			->where('ssl.action', 'IN', array(1,3)) // login or cookie
			->order_by('ssl.timestamp', 'DESC')
			->limit(1)
			->offset(0);
		
		return DB::select('su.id', 'su.name', 'su.email', 'su.status', array('ssl.timestamp','last_login'))
			->from(array('sys_user','su'))
			->join(array($sub, 'ssl'), 'LEFT')->on('su.id', '=', 'ssl.user_id')
			->where('su.is_deleted', '=', 0)
			->order_by($order_by, $sort)
			->execute();
	}
	
	public function fetch($id)
	{
		$data = DB::select('id', 'name', 'email', array('email','o_email'), 'status')
			->from('sys_user')
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
	
	public function save($data)
	{
		$valid = $this->check($data);
		
		if ( ! $valid->check())
			return $valid->errors('user');
		
		$data['password'] = $this->password($data['password']);

		if ($data['id'])
			return $this->_update($data);
		else
			return $this->_insert($data);
			
	}
	
	public function delete($id)
	{
		$id = (int) $id;
		
		DB::update('sys_user')
			->set(array('is_deleted' => 1))
			->where('id', '=', $id)
			->execute();
		
		$data = DB::select('id', 'name')
			->from('sys_user')
			->where('id', '=', $id)
			->execute()
			->current();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['name'], $data, 3);
		
		return TRUE;
	}
	
	protected function _insert($data)
	{
		list($user_id) = DB::insert('sys_user', array('name', 'email', 'password', 'status'))
			->values(array($data['name'], $data['email'], $data['password'], $data['status']))
			->execute();
		
		$this->_log_transaction($this->_module_id, $user_id, $data['name'], $data, 1);
		
		return TRUE;
	}
	
	protected function _update($data)
	{
		DB::update('sys_user')
			->set(array('name'     => $data['name']))
			->set(array('email'    => $data['email']))
			->set(array('password' => $data['password']))
			->set(array('status'   => $data['status']))
			->where('id', '=', $data['id'])
			->execute();
		
		$this->_log_transaction($this->_module_id, $data['id'], $data['name'], $data, 2);
		
		return TRUE;
	}
	
	protected function _log_session($user_id, $action)
	{
		$code = Model::factory('Sys_Lookup')->get_code('session', $action);
		Model::factory('Sys_Session_Log')->log($user_id, $code);
	}
	
	public function check($data)
	{
		$data = array_map('trim', $data);
		$data['id'] = (int) $data['id'];
		
		$data = Validation::factory($data)
			->rule('name', 'not_empty')
			->rule('email', 'not_empty')
			->rule('email', 'email')
			->rule('email', 'Model_Sys_User::unique_email', array($data['id'], $data['email'], $data['o_email']))
			->rule('status', 'not_empty')
			->rule('status', 'in_array', array(':value', array(1, 2)));
			
		if ( ! $data['id'] OR $data['password'] )
		{
			$data->rule('password', 'not_empty');
			$data->rule('password', 'min_length', array(':value', '6'));
		}
		
		return $data;
	}
	
	public static function unique_email($id, $email, $o_email)
	{
		$result = DB::select(array(DB::expr('COUNT(email)'), 'total'))
			->from('sys_user')
			->where('email', '=', $email);
		
		if ($id)
		{
			$result->where('email', '<>', $o_email);
		}
		
		return ! $result->execute()->get('total');
	}
	
	public function password($pass)
	{
		$config = Kohana::config('auth')->backend;
		
		return hash_hmac($config['hash_method'], $pass, $config['hash_key']);
	}

	public function generate_password()
	{
		return Text::random('alnum', 8);
	}

	public function forgot($username)
	{
		$user = DB::select('id', 'name')
			->from('sys_user')
			->where('email', '=', $username)
			->where('status', '=', 1)
			->where('is_deleted', '=', 0)
			->execute()
			->current();
			
		if( ! $user)
			return FALSE;

		$newpassword_text = $this->generate_password();
		$newpassword = $this->password($newpassword_text);

		DB::update('sys_user')
			->set(array('password' => $newpassword))
			->where('id', '=', $user['id'])
			->execute();
		
		$data = array("newpassword"=>$newpassword);
		
		// Send mail
		
		$site = Kohana::config('site');

		$mailTo = $username;

		$mailFrom = "Webmaster <webmaster@copyleftsolutions.no>";
		$subject = $site->title." (".__('Forgot your password?').")";
		$message = '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<base href="'.$site->url.'">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>'.$subject.'</title>
		<style type="text/css">
		body { font: normal 11px Arial, Helvetica, Verdana; color: #000; }
		</style>
		</head>
		<body>
		<div>
		'.__('We have received a request to generate a new password and here it is').':<br />
		<br /><strong>'.$newpassword_text.'</strong><br /><br />
		<a href="'.$site->url.'admin/">'.$site->url.'admin/</a>
		</div>
		</body>
		</html>
		';
		$mailheaders = "From: " . $mailFrom . " \n";
		$mailheaders .= 'Content-type: text/html; charset=utf8' . "\r\n";
		mail($mailTo, $subject, $message, $mailheaders);
		
//		$this->_log_transaction($this->_module_id, $user['id'], $user['name'], $data, 4);

		return TRUE;
	}

}