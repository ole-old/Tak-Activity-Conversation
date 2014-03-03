<?php defined('SYSPATH') or die('No direct script access.');

class File extends Kohana {
	
	public static function getFormat($filename)
	{
		$ftype = "";
		$imgs = array('jpg', 'jpeg', 'png', 'gif');
		$docs = array('pdf', 'doc', 'docx', 'xls', 'vcf', 'vcard', 'ppt', 'pptx');
		$fle = pathinfo($filename);
		
		if(in_array(strtolower($fle['extension']), $docs)){
			$fle['type'] = 'doc';
		} else if(in_array(strtolower($fle['extension']), $imgs)){
			$fle['type'] = 'image';
		}
		return $fle;
	}
	
}