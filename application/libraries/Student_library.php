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
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($students = $this->_ci->Student_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $students;
			}else{
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($student_data){
		try{
			if ($student_id = $this->_ci->Student_model->add($student_data)) {
				return $student_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
