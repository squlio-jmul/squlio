<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * Classroom Grade library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Classroom_grade_library extends SQ_Library {
	public function __construct() {
		parent::__construct();
		$this->_ci->load->model('Classroom_grade_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($classroom_grades = $this->_ci->Classroom_grade_model->get($filters, $fields, $order_by, $limit, $offset, $modules)) {
				return $classroom_grades;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function add($classroom_grade_data) {
		try {
			if ($classroom_grade_id = $this->_ci->Classroom_grade_model->add($classroom_grade_data)) {
				return $classroom_grade_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($classroom_grade_id, $classroom_grade_data) {
		try {
			if ($classroom_grade = $this->_ci->Classroom_grade_model->update($classroom_grade_id, $classroom_grade_data)) {
				return $classroom_grade;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
