<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * Account Type library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Account_type_library extends SQ_Library {
	public function __construct() {
		parent::__construct();
		$this->_ci->load->model('Account_type_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Account_type_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function add($account_type_data) {
		try {
			if ($account_type_id = $this->_ci->Account_type_model->add($account_type_data)) {
				return $account_type_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($account_type_id, $account_type_data) {
		try {
			if ($account_type = $this->_ci->Account_type_model->update($account_type_id, $account_type_data)) {
				return $account_type;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
