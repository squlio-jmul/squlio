<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Principal library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Principal_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Principal_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($principals = $this->_ci->Principal_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $principals;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($principal_data){
		try{
			if ($principal_id = $this->_ci->Principal_model->add($principal_data)) {
				return $principal_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
