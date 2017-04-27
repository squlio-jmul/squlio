<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Subject library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Subject_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Subject_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Subject_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function add($subject_data){
		try{
			$default_subject_data = array(
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			$subject_data = array_merge($subject_data, $default_subject_data);
			if ($subject_id = $this->_ci->Subject_model->add($subject_data)) {
				return $subject_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($subject_id, $subject_data) {
		try {
			if ($subject = $this->_ci->Subject_model->update($subject_id, $subject_data)) {
				return $subject;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function delete($filters) {
		try {
			return $this->_ci->Subject_model->delete($filters);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

}
