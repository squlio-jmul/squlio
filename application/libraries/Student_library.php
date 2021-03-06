<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Student library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Student_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Student_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Student_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function add($student_data){
		try{
			$student_data['birthday'] = new \DateTime($student_data['birthday']);
			$student_data['code'] = uniqid(strtotime('now'));
			if ($student_id = $this->_ci->Student_model->add($student_data)) {
				return $student_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($student_id, $student_data) {
		try {
			if ($student = $this->_ci->Student_model->update($student_id, $student_data)) {
				return $student;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
