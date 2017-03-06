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

	public function emailExist($email) {
		try {
			if ($exist = $this->_ci->Login_model->get(array('email'=>$email), array('emai'))) {
				return true;
			} else {
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function verifyLogin($email, $password, $login_token = null) {
		$success_obj = array('success' => false, 'redirect_page' => null, 'id' => null, 'cookie_obj' => null);

		try {
			if ($login_obj = $this->_ci->Login_model->get(array('email'=>$email))) {
				$login = $login_obj[0];
				if ($login['password'] == $password && $login['active'] && !$login['deleted']) {
					switch($login['type']) {
						case 'admin':
							$type_info_obj = $this->_ci->Admin_model->get(array('login'=>$login['id']));
							$type_info = $type_info_obj[0];
							break;
						default:
							$type_info = null;
							break;
					}
					if ($type_info) {
						$success_obj['success'] = true;
						$success_obj['redirect_page'] = '/admin/dashboard';
						$success_obj['id'] = $login['id'];
						$success_obj['cookie_obj'] = array('id'=>$login['id'], 'type'=>$login['type']);
					}
				}
			}
			return $success_obj;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

}