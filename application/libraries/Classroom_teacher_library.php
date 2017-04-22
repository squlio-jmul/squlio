<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classroom Teacher library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Classroom_teacher_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Classroom_teacher_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($classroom_teachers = $this->_ci->Classroom_teacher_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $classroom_teachers;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($classroom_teacher_data){
		try{
			if ($classroom_teacher_id = $this->_ci->Classroom_teacher_model->add($classroom_teacher_data)) {
				return $classroom_teacher_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($classroom_teacher_id, $classroom_teacher_data) {
		try {
			if ($classroom_teacher = $this->_ci->Classroom_teacher_model->update($classroom_teacher_id, $classroom_teacher_data)) {
				return $classroom_teacher;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function setPrimary($classroom_teacher_id) {
		try {
			if ($classroom_teacher = $this->_ci->Classroom_teacher_model->setPrimary($classroom_teacher_id)) {
				return $classroom_teacher;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

}
