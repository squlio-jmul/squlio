<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_admin extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('School_admin_library');
		$this->load->library('Login_library');
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

	public function add() {
		$add_login_data = array (
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'type' => 'school_admin',
			'token' => 'blah',
			'active' => 1,
			'deleted' => 0,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login_id = $this->login_library->add($add_login_data)) {
			$add_school_admin_data = array (
				'login_id' => $login_id,
				'school_id' => $this->input->post('school_id'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			if ($school_admin_id = $this->school_admin_library->add($add_school_admin_data)) {
				$this->setResponseElement('success', true);
				$this->setResponseElement('school_admin_id', $school_admin_id);
				$this->setResponseElement('login_id', $login_id);
			} else {
				$this->setResponseElement('success', false);
			}
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function addBulk() {
		$school_id = $this->input->post('school_id');
		$school_admins = $this->input->post('school_admins');
		$success = $this->school_admin_library->addBulk($school_id, $school_admins);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$login_id = $this->input->post('login_id');
		$delete_school_admin_data = array (
			'type' => 'school_admin',
			'token' => 'blah',
			'active' => 0,
			'deleted' => 1,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login = $this->login_library->update($login_id, $delete_school_admin_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('login', $login);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();

	}

	public function update() {
		$school_admin_id = $this->input->post('school_admin_id');
		$school_admin_data = $this->input->post('school_admin_data');
		$success = $this->school_admin_library->update($school_admin_id, $school_admin_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}
}
