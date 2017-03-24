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
		$this->_ci->load->model('Login_model');
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

	public function addBulk($school_id, $principals) {
		$success = true;
		foreach($principals as $p) {
			$login_data = array(
				'email' => $p['email'],
				'username' => $p['username'],
				'password' => $p['password'],
				'type' => 'principal',
				'token' => md5(strtotime('now')),
				'active' => 1,
				'deleted' => 0,
				'reset_password' => 0,
				'last_login' => null,
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			if ($login_id = $this->_ci->Login_model->add($login_data)) {
				$principal_data = array(
					'login_id' => $login_id,
					'school_id' => $school_id,
					'first_name' => $p['first_name'],
					'last_name' => $p['last_name'],
					'created_on' => new \DateTime('now'),
					'last_updated' => new \DateTime('now')
				);
				if ($principal_id = $this->_ci->Principal_model->add($principal_data)) {
				} else {
					$success = false;
				}
			} else {
				$success = false;
			}
		}
		return $success;
	}

	public function getActiveCountBySchoolId($school_id) {
		return $this->_ci->Principal_model->getActiveCountBySchoolId($school_id);
	}

	public function update($principal_id, $principal_data) {
		try {
			if ($principal = $this->_ci->Principal_model->update($principal_id, $principal_data)) {
				return $principal;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
