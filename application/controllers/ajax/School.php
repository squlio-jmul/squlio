<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('School_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($schools = $this->school_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('schools', $schools);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add(){
		$get_account_type_value = array(
			'account_type' => $this->input->post('account_type_id')
		);
		$add_school_data = array(
			'account_type_id' => $get_account_type_value,
			'name' => $this->input->post('school_name'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => '',
			'city' => $this->input->post('city'),
			'state' => 'DKI Jakarta',
			'zipcode' => $this->input->post('zipcode'),
			'country' => 'Indonesia',
			'phone_1' => $this->input->post('phone_1'),
			'phone_2' => '',
			'branch' => '',
			'email' => $this->input->post('school_email'),
			'url' => '',
			'code' => 1,
			'active' => 1,
			'deleted' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($school_id = $this->school_library->add($add_school_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('school_id', $school_id);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function displayTable() {
	}
}
