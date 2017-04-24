<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classroom Teacher library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Guardian_student_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Guardian_student_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			if($guardian_students = $this->_ci->Guardian_student_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $guardian_students;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($guardian_student_data){
		try{
			if ($guardian_student_id = $this->_ci->Guardian_student_model->add($guardian_student_data)) {
				return $guardian_student_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($guardian_student_id, $guardian_student_data) {
		try {
			if ($guardian_student = $this->_ci->Guardian_student_model->update($guardian_student_id, $guardian_student_data)) {
				return $guardian_student;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function delete($filters) {
		try {
			return $this->_ci->Guardian_student_model->delete($filters);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
