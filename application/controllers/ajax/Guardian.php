<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guardian extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Guardian_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($guardians = $this->guardian_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('guardians', $guardians);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$guardian_data = $this->input->post('guardian_data');
		if ($guardian_id = $this->guardian_library->add($guardian_data)) {
			$this->setResponseElement('guardian_id', $guardian_id);
		} else {
			$this->setResponseElement('guardian_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$guardian_id = $this->input->post('guardian_id');
		$guardian_data = $this->input->post('guardian_data');
		$success = $this->guardian_library->update($guardian_id, $guardian_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}
}
