<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * School Admin library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class School_admin_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Login_model');
		$this->_ci->load->model('School_admin_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($school_admins = $this->_ci->School_admin_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $school_admins;
			}else{
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}
	public function usernameExist($username) {
		try {
			if ($exist = $this->_ci->Login_model->get(array('username'=>$username), array('username'))) {
				return true;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
