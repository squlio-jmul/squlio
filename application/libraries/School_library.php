<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * School library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class School_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('School_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($schools = $this->_ci->School_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $schools;
			}else{
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($school_data){
		try{
			if ($school_id = $this->_ci->School_model->add($school_data)) {
				return $school_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($school_id, $school_data) {
		try {
			if ($school = $this->_ci->School_model->update($school_id, $school_data)) {
				return $school;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function uploadImage($file) {
		$error = false;
		$error_msg = $url_path = null;
		$valid_extensions = array('jpeg', 'jpg', 'png');
		if (isset($file['type'])) {
			$temporary = explode('.', $file['name']);
			$file_extension = end($temporary);
			if ((($file['type'] == 'image/png') || ($file['type'] == 'image/jpg') || ($file['type'] == 'image/jpeg')
				) && ($file['size'] < (2000*1024)) && in_array($file_extension, $valid_extensions)) {
					if ($file['error'] > 0) {
						$error = true;
						$error_msg = $file['error'];
					} else {
						$uniqid = uniqid(strtotime('now'));
						$url_path = $this->_ci->config->item('upload_img_dir') . '/' . $uniqid;
						$handle = fopen($url_path, 'w');
						$img = file_get_contents($file['tmp_name']);
						fwrite($handle, $img);
						fclose($handle);
						if (file_exists($url_path)) {
							$error = false;
						} else {
							$error = true;
							$error_msg = 'Unable to upload file';
						}
					}
				}
		} else {
			$error = true;
			$error_msg = 'Invalid file size (Max 2MB) or type (has to be jpg, jpeg or png)';
		}
		return array('success'=>!$error, 'error_msg'=>$error_msg, 'url_path'=>$this->_ci->config->item('main_url') . '/' . $url_path);
	}

}
