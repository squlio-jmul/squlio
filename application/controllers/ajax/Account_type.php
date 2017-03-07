<?php
defined('BASEPATH') OR exit('No direct script allowed');

class Account_type extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Account_type_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ?  $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($account_types = $this->account_type_library->get($filters, $fields, $order_by, $limit, $offset, $modules)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('account_types', $account_types);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$add_account_type_data = array (
			'name' => $this->input->post('name'),
			'display_name' => $this->input->post('display_name'),
			'num_principal' => $this->input->post('num_principal'),
			'num_school_admin' => $this->input->post('num_school_admin'),
			'num_teacher' => $this->input->post('num_teacher'),
			'num_classroom' => $this->input->post('num_classroom'),
			'num_guardian' => $this->input->post('num_guardian'),
			'num_student' => $this->input->post('num_student'),
			'active' => 1,
			'deleted' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($account_type_id = $this->account_type_library->add($add_account_type_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('account_type_id', $account_type_id);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}
}
