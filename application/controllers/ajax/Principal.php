<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Principal_library');
		$this->load->library('School_library');
		$this->load->library('Login_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($principals = $this->principal_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('principals', $principals);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {

		$add_login_data = array (
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'type' => 'principal',
			'token' => 'blah',
			'active' => 1,
			'deleted' => 0,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login_id = $this->login_library->add($add_login_data)) {
			$add_principal_data = array(
				'login_id' => $login_id,
				'school_id' => $this->input->post('school_id'),
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			if ($principal_id = $this->principal_library->add($add_principal_data)) {
				$this->setResponseElement('success', true);
				$this->setResponseElement('principal_id', $principal_id);
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
		$principals = $this->input->post('principals');
		$success = $this->principal_library->addBulk($school_id, $principals);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$login_id = $this->input->post('login_id');
		$delete_principal_data = array (
			'type' => 'principal',
			'token' => 'blah',
			'active' => 0,
			'deleted' => 1,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($login = $this->login_library->update($login_id, $delete_principal_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('login', $login);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function update() {
		$principal_id = $this->input->post('principal_id');
		$principal_data = $this->input->post('principal_data');
		$success = $this->principal_library->update($principal_id, $principal_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}
}
