<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Teacher library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Teacher_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Teacher_model');
		$this->_ci->load->model('Login_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Teacher_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($teacher_data){
		try{
			$token = uniqid(strtotime('now'));
			$login_data = array(
				'email' => $teacher_data['email'],
				'username' => $teacher_data['username'],
				'password' => $teacher_data['password'],
				'type' => 'teacher',
				'token' => $token,
				'active' => $teacher_data['active'],
				'deleted' => 0,
				'reset_password' => 0,
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			if ($login_id = $this->_ci->Login_model->add($login_data)) {
				$default_teacher_data = array(
					'login_id' => $login_id,
					'push_notification_quiet_hours' => 0,
					'push_notification_mute_weekends' => 0,
					'allow_story_comments' => 1,
					'birthday' => new \DateTime($teacher_data['birthday']),
					'created_on' => new \DateTime('now'),
					'last_updated' => new \DateTime('now')
				);
				$teacher_data = array_merge($teacher_data, $default_teacher_data);
				if ($teacher_id = $this->_ci->Teacher_model->add($teacher_data)) {
					return $teacher_id;
				}
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function getActiveCountBySchoolId($school_id) {
		return $this->_ci->Teacher_model->getActiveCountBySchoolId($school_id);
	}

	public function update($teacher_id, $teacher_data) {
		try {
			if (isset($teacher_data['birthday'])) {
				$teacher_data['birthday'] = new \DateTime($teacher_data['birthday']);
			}
			if ($teacher = $this->_ci->Teacher_model->update($teacher_id, $teacher_data)) {
				return $teacher;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
