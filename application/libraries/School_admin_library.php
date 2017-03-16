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

	public function add($school_admin_data) {
		try {
			if ($school_admin_id = $this->_ci->School_admin_model->add($school_admin_data)) {
				return $school_admin_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function addBulk($school_id, $school_admins) {
		$success = true;
		foreach($school_admins as $sa) {
			$login_data = array(
				'email' => $sa['email'],
				'username' => $sa['username'],
				'password' => $sa['password'],
				'type' => 'school_admin',
				'token' => md5(strtotime('now')),
				'active' => 1,
				'deleted' => 0,
				'reset_password' => 0,
				'last_login' => null,
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			if ($login_id = $this->_ci->Login_model->add($login_data)) {
				$school_admin_data = array(
					'login_id' => $login_id,
					'school_id' => $school_id,
					'first_name' => $sa['first_name'],
					'last_name' => $sa['last_name'],
					'created_on' => new \DateTime('now'),
					'last_updated' => new \DateTime('now')
				);
				if ($school_admin_id = $this->_ci->School_admin_model->add($school_admin_data)) {
				} else {
					$success = false;
				}
			} else {
				$success = false;
			}
		}
		return $success;
	}

}
