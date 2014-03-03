<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Contento base model.
 *
 * @package    Contento
 * @category   Models
 * @author     Copyleft Solutions
 * @copyright  (c) 2012 Copyleft Solutions
 * @license    http://contento.copyleft.com/license
 */
class Model extends Kohana_Model {
	
	public function delete($id)
	{
		$table = strtolower(str_replace('Model_', '', get_called_class()));
		
		return DB::query(Database::UPDATE, "UPDATE ".mysql_real_escape_string($table)." SET deleted = 1 WHERE id = :id")
			->parameters(array(
				':id' => $id,
			))
			->execute();
		
		/*
		foreach ( (array) $id as $_id)
		{
			$data = $model->fetch($_id);
			$query->execute();
			//$this->_log_activity($this->_module_id, $_id, $data['item_name'], self::DELETE, array('deleted' => 1));
		}
		*/
	}
	
	public function status($id, $status)
	{
		$table = strtolower(str_replace('Model_', '', get_called_class()));
		
		return DB::query(Database::UPDATE, "UPDATE ".mysql_real_escape_string($table)." SET status = :status WHERE id = :id")
			->parameters(array(
				':status' => $status,
				':id' => $id,
			))
			->execute();
		
		/*
		$class = get_called_class();
		$model = new $class;
		$table = strtolower(str_replace('Model_', '', $class));
		
		$query = DB::query(Database::UPDATE, "UPDATE ".mysql_real_escape_string($table)." SET status = :status WHERE id = :id")
			->bind(':id', $_id)
			->parameters(array(
				':status' => $status,
			));
		
		foreach ( (array) $id as $_id)
		{
			$data = $model->fetch($_id);
			$query->execute();
			//$this->_log_activity($this->_module_id, $_id, $data['item_name'], self::UPDATE, array('status' => $status));
		}
	
		return TRUE;
		*/
	}
	
}
