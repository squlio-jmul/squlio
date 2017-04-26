<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Term library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Term_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Term_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			if($terms = $this->_ci->Term_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $terms;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($term_data){
		try{
			$term_data['start_date'] = new \DateTime($term_data['start_date']);
			$term_data['end_date'] = new \DateTime($term_data['end_date']);
			if ($term_id = $this->_ci->Term_model->add($term_data)) {
				return $term_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($term_id, $term_data) {
		try {
			if (isset($term_data['start_date'])) {
				$term_data['start_date'] = new \DateTime($term_data['start_date']);
			}
			if (isset($term_data['end_date'])) {
				$term_data['end_date'] = new \DateTime($term_data['end_date']);
			}
			if ($term = $this->_ci->Term_model->update($term_id, $term_data)) {
				return $term;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function delete($filters) {
		try {
			return $this->_ci->Term_model->delete($filters);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
