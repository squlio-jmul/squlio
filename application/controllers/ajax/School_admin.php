<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_admin extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Login_library');
		$this->load->library('School_admin_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($school_admins = $this->school_admin_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('school_admins', $school_admins);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function usernameExist() {
		$username = $this->input->post('username');

		$exist = $this->school_admin_library->usernameExist($username);
		if ($exist) {
			echo 'true';
		} else {
			echo 'false';
		}
		die();
	}

	public function add(){
		$login_data = array(
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'type' => 'school_admin',
			'token' => 'blah',
			'active' => 1,
			'deleted' => 0,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login_id = $this->login_library->add($login_data)){
			$school_admin_data = array(
				'login_id' => $login_id,
				'school_id' => 1,
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			if ($school_admin_id = $this->school_admin_library->add($school_admin_data)) {
				$this->setResponseElement('success', true);
				$this->setResponseElement('school_admin_id', $school_admin_id);
			} else {
				$this->setResponseElement('success', false);
			}
		} else {
			$this->setResponseElement('success', false);
		}

		$this->sendResponse();
	}
}
