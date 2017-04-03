<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Teacher library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Teacher_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Teacher_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($teachers = $this->_ci->Teacher_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $teachers;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($teacher_data){
		try{
			if ($teacher_id = $this->_ci->Teacher_model->add($teacher_data)) {
				return $teacher_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function getActiveCountBySchoolId($school_id) {
		return $this->_ci->Teacher_model->getActiveCountBySchoolId($school_id);
	}

	public function update($teacher_id, $teacher_data) {
		try {
			if ($teacher = $this->_ci->Teacher_model->update($teacher_id, $teacher_data)) {
				return $teacher;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
