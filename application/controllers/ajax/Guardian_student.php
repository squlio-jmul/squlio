<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Guardian_student extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Guardian_student_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		$guardian_students = $this->guardian_student_library->get($filters, $fields, $order_by, $limit, $offset, $modules);
		$this->setResponseElement('success', true);
		$this->setResponseElement('guardian_students', $guardian_students);
		$this->sendResponse();
	}

	public function add() {
		$guardian_student_data = $this->input->post('guardian_student_data');
		if ($guardian_student_id = $this->guardian_student_library->add($guardian_student_data)) {
			$this->setResponseElement('guardian_student_id', $guardian_student_id);
		} else {
			$this->setResponseElement('guardian_student_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$guardian_student_id = $this->input->post('guardian_student_id');
		$guardian_student_data = $this->input->post('guardian_student_data');
		$success = $this->guardian_student_library->update($guardian_student_id, $guardian_student_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->guardian_student_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}
}
