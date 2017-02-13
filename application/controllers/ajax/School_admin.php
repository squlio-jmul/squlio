<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_admin extends SQ_Controller {
	public function __construct() {
		parent::__construct();
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
}
