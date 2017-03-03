<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Syllabus library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Syllabus_library extends SQ_Library {

	public function __construct(){

		parent::__construct();
		$this->_ci->load->model('Syllabus_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try{
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIADATE_BOOLEAN)) ? true : false;

			if($syllabuses = $this->_ci->Syllabus_model->get($filters, $fields, $order_by, $limit, $offset, $modules)) {
				return $syllabuses;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function add($syllabus_data){
		try{
			if ($syllabus_id = $this->_ci->Syllabus_model->add($syllabus_data)){
				return $syllabus_id;
			}
			return false;
		} catch(Exception $err){
			die($err->getMessage());
		}
	}
}
