<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Guardian library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Guardian_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Guardian_model');
		$this->_ci->load->model('Login_model');
		$this->_ci->load->model('Guardian_student_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Guardian_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function add($guardian_data){
		try{
			$token = uniqid(strtotime('now'));
			$login_data = array(
				'email' => $guardian_data['email'],
				'password' => $guardian_data['password'],
				'type' => 'guardian',
				'token' => $token,
				'active' => $guardian_data['active'],
				'deleted' => 0,
				'reset_password' => 0,
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			if ($login_id = $this->_ci->Login_model->add($login_data)) {
				$default_guardian_data = array(
					'login_id' => $login_id,
					'app_connected' => 0,
					'created_on' => new \DateTime('now'),
					'last_updated' => new \DateTime('now')
				);
				$guardian_data = array_merge($guardian_data, $default_guardian_data);
				if ($guardian_id = $this->_ci->Guardian_model->add($guardian_data)) {
					return $guardian_id;
				}
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($guardian_id, $guardian_data) {
		try {
			if ($guardian = $this->_ci->Guardian_model->update($guardian_id, $guardian_data)) {
				return $guardian;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function verifyEmail($student_id, $email) {
		$email_avail = true;
		$guardian = null;
		$guardian_exist = false;
		try {
			if ($login_obj = $this->_ci->Login_model->get(array('email'=>$email))) {
				$login = $login_obj[0];
				$email_avail = false;
				if ($login['type'] == 'guardian') {
					if ($guardian_obj = $this->_ci->Guardian_model->get(array('login'=>$login['id']))) {
						$guardian = $guardian_obj[0];
						if ($guardian_student_obj = $this->_ci->Guardian_student_model->get(array('student'=>$student_id, 'guardian'=>$guardian['id']))) {
							$guardian_exist = true;
						}
					}
				}
			}
		} catch (Exception $err) {
			die($err->getMessage());
		}
		return array('email_available'=>$email_avail, 'guardian'=>$guardian, 'guardian_exist' => $guardian_exist);
	}
}
