<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin library
 *
 * @package Librarires
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Admin_library extends SQ_Library {

	public function __construct(){

		parent::__construct();
		$this->_ci->load->model('Login_model');
		$this->_ci->load->model('Admin_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($admins = $this->_ci->Admin_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $admins;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
