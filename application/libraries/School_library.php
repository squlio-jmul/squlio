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
			return $this->_ci->School_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
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
}
