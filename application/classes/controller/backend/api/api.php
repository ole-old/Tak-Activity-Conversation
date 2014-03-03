<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Backend_Api_Api extends Controller {
	
	public $api;
	
	public function action_uploadify()
	{

		$result = array(
			'error'=>true,
			'errordesc'=>'No file received',
			'original'=>'',
			'original_wpath'=>'',
			'medium'=>'',
			'medium_wpath'=>'',
			'thumb'=>'',
			'thumb_wpath'=>'',
			'fileInfo'=>array(),
			'callBack'=>Arr::get($_POST, 'callBack', '')
		);

		$folder = Arr::get($_POST, 'folder', '/assets/files/');
		$allowFiles = array('image'=>array('jpg', 'png', 'gif', 'eps', 'psd', 'ai', 'tiff'), 'doc'=>array('doc', 'pdf', 'ppt', 'vcf', 'vcard'));

		if ($_FILES)
		{
			
			$folder = substr($folder, 1);
			
			// Validate file
			$myUpload = Validation::factory($_FILES)
				->rule('upload', 'Upload::type', array(':value', $allowFiles[Arr::get($_POST, 'fileType', 'image')]))
				->rule('upload', 'Upload::not_empty')
				->rule('upload', 'Upload::valid');
				
			if(Arr::get($_POST, 'fileType', 'image') == 'image')
				$myUpload->rule('upload', 'Upload::image');
				
				// Save image
				$myUpload = Upload::save($myUpload['upload'], NULL, $folder);
				
				$result['tmp'] = $myUpload;
	
			// Check if file uploaded
			if($myUpload !== FALSE){
				
				$result['error'] = false;
				$result['errordesc'] = '';
				$result['original_wpath'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $myUpload);
				$result['original'] = basename($result['original_wpath']);
				$result['fileInfo'] = File::getFormat($result['original_wpath']);

				if(Arr::get($_POST, 'fileType', 'image') == 'image'){
					// Create thumbnail
					$myThumb = Model::factory('Image')
						->set('image', $myUpload)
						->set('maxWidth', Arr::get($_POST, 'thumbWidth', 64))
						->set('maxHeight', Arr::get($_POST, 'thumbHeight', 64))
						->set('target', $folder.'thumb/')
						->create_thumbnail();
						$result['thumb_wpath'] = $myThumb;
						$result['thumb'] = basename($result['thumb_wpath']);
						
						
					if(Arr::get($_POST, 'extrathumb', 0)){
						// Create extra thumbnail
						$myThumb = Model::factory('Image')
							->set('image', $myUpload)
							->set('maxWidth', Arr::get($_POST, 'extrathumb', 64))
							->set('maxHeight', Arr::get($_POST, 'extrathumb', 64))
							->set('target', $folder.'extrathumb/')
							->create_thumbnail();
					}

						
				}
					
			}

		}
		$response = json_encode($result);
		
		$this->request->headers['Content-Type'] = 'application/json';
		$this->response->body($response);

	}

}