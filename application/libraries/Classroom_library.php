<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classroom library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Classroom_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Classroom_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Classroom_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($classroom_data){
		try{
			if ($classroom_id = $this->_ci->Classroom_model->add($classroom_data)) {
				return $classroom_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($classroom_id, $classroom_data) {
		try {
			if ($classroom = $this->_ci->Classroom_model->update($classroom_id, $classroom_data)) {
				return $classroom;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
