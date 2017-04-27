<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Pickup library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Pickup_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Pickup_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Pickup_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($pickup_data){
		try{
			if ($pickup_id = $this->_ci->Pickup_model->add($pickup_data)) {
				return $pickup_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($pickup_id, $pickup_data) {
		try {
			if ($pickup = $this->_ci->Pickup_model->update($pickup_id, $pickup_data)) {
				return $pickup;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function delete($filters) {
		try {
			return $this->_ci->Pickup_model->delete($filters);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
