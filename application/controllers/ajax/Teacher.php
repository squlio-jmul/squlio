<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Teacher_library');
		$this->load->library('Login_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($teachers = $this->teacher_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('teachers', $teachers);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
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
				'birthday' => $this->input->post('birthday')
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
}

