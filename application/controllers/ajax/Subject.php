<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Subject_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($subjects = $this->subject_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('subjects', $subjects);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$subject_data = $this->input->post('subject_data');
		if ($subject_id = $this->subject_library->add($subject_data)) {
			$this->setResponseElement('subject_id', $subject_id);
		} else {
			$this->setResponseElement('subject_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$subject_id = $this->input->post('subject_id');
		$subject_data = $this->input->post('subject_data');
		$success = $this->subject_library->update($subject_id, $subject_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->subject_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

}
