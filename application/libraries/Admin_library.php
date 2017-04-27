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
		$this->_ci->load->model('Admin_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Admin_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
