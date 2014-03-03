<?php defined('SYSPATH') or die('No direct script access.');

class Model_Contact extends Model {
	
	protected $_module_id = 28;
	
	public function fetch_all()
	{
		$level1 = DB::select('id', 'fullname', 'email', 'message', 'datereg')
			->from('contact')
			->order_by('datereg', 'DESC')
			->execute()
			->as_array();
		
		return $level1;
			
	}
	
	public function fetch($id)
	{
		$data = DB::select('id', 'fullname', 'email', 'message', 'datereg')
			->from('contact')
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
	
	public function send_contact($data, $registry)
	{
			$this->save_contact($data);
		
			$mailheaders = "";
			$mailheaders .= "From: ".$data['fullname']." <".$data['email'].">\r\n";
			$mailheaders .= 'MIME-Version: 1.0' . "\r\n";
			$mailheaders .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			
			$msg = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body style="background: #fff; padding-top: 15px; font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 14px;">
<div style="width: 700px; padding-left: 55px;">
Se ha contactado desde la página de Recursos<br><br><br>
<strong>Nombre:</strong> '.$data['fullname'].'<br><br><br>
<strong>Correo Electrónico:</strong> '.$data['email'].'<br><br><br>
<strong>Mensaje:</strong> '.nl2br($data['message']).'
</div>
</body>
</html>
';

			$subject= "=?utf-8?b?".base64_encode("Te han contactado desde la página de Recursos")."?=";
			mail($registry['contact_email'], $subject, $msg, $mailheaders);

			$result['result'] = true;
	}
	
	public function save_contact($data){
		list($added_id) = DB::insert('contact', array('fullname', 'email', 'message', 'datereg'))
			->values(array($data['fullname'], $data['email'], $data['message'], DB::expr('now()')))
			->execute();
	}
	
}