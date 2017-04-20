<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Teacher_library');
		$this->load->library('Login_library');
		$this->load->model('Teacher_model');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($teachers = $this->teacher_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('teachers', $teachers);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$teacher_data = $this->input->post('teacher_data');
		if ($teacher_id = $this->teacher_library->add($teacher_data)) {
			$this->setResponseElement('teacher_id', $teacher_id);
		} else {
			$this->setResponseElement('teacher_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$teacher_id = $this->input->post('teacher_id');
		$teacher_data = $this->input->post('teacher_data');
		$success = $this->teacher_library->update($teacher_id, $teacher_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function upload_image() {
		$response = $this->teacher_library->uploadImage($_FILES['file']);
		$this->setResponseElement('success', $response['success']);
		$this->setResponseElement('error_msg', $response['error_msg']);
		$this->setResponseElement('url_path', $response['url_path']);
		$this->sendResponse();
	}

	/*
	public function add() {
		$birthday = $this->input->post('birthday');
		$add_login_data = array (
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'type' => 'teacher',
			'token' => 'blah',
			'active' => $this->input->post('status'),
			'deleted' => 0,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login_id = $this->login_library->add($add_login_data)) {
			$add_teacher_data = array (
				'login_id' => $login_id,
				'school_id' => $this->input->post('school_id'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'push_notification_quiet_hours' => 1,
				'push_notification_quiet_hours_from' => new \DateTime('now'),
				'push_notification_quiet_hours_to' => new \DateTime('now'),
				'push_notification_mute_weekends' => 1,
				'allow_story_comments' => 1,
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now'),
				'phone' => $this->input->post('phone'),
				'address' => $this->input->post('address'),
				'gender' => $this->input->post('gender'),
				'birthday' => new \DateTime($birthday)
			);
			if ($teacher_id = $this->teacher_library->add($add_teacher_data)) {
				$this->setResponseElement('success', true);
				$this->setResponseElement('teacher_id', $teacher_id);
				$this->setResponseElement('login_id', $login_id);
			} else {
				$this->setResponseElement('success', false);
			}
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function displayTable() {

		$table_data = array();
		if ($teacher_obj = $this->Teacher_model->getActiveTeacher($this->input->post('school_id'))){
			foreach($teacher_obj as $t){

				//if ($t['login']['active'] == 1) {
				//	$status = "active";
				//} else {
				//	$status = "inactive";
				//}
				$data = array(
					'id' => $t['id'],
					'name' => $t['first_name'],
					'class' => "-",
					'status' => "active"
				);
				$table_data[] = $data;
			}
		}
		if ($table_data) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('teacher_data', $table_data);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();

		//echo json_encode(array('data' => $table_data));
	}

	public function update() {
		$login_id = $this->input->post('login_id');
		$teacher_id = $this->input->post('id');
		$update_login_data = array (
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login = $this->login_library->update($login_id, $update_login_data)) {
			$update_teacher_data = array (
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now'),
				'phone' => $this->input->post('phone'),
				'address' => $this->input->post('address'),
				'gender' => $this->input->post('gender'),
				'birthday' => new \DateTime($this->input->post('birthday'))
			);
			if ($teacher = $this->teacher_library->update($teacher_id, $update_teacher_data)) {
				$this->setResponseElement('success', true);
				$this->setResponseElement('teacher', $teacher);
				$this->setResponseElement('login', $login);
			} else {
				$this->setResponseElement('success', false);
			}
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function delete() {
		$login_id = $this->input->post('login_id');
		$delete_teacher_data = array (
			'active' => 0,
			'deleted' => 1,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login = $this->login_library->update($login_id, $delete_teacher_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('login', $login);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}
	 */
}
