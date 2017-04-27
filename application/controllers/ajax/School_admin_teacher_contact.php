<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_admin_teacher_contact extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('School_admin_teacher_contact_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		$school_admin_teacher_contacts = $this->school_admin_teacher_contact_library->get($filters, $fields, $order_by, $limit, $offset, $modules);
		$this->setResponseElement('success', true);
		$this->setResponseElement('school_admin_teacher_contacts', $school_admin_teacher_contacts);
		$this->sendResponse();
	}

	public function add() {
		$school_admin_teacher_contact_data = $this->input->post('school_admin_teacher_contact_data');
		if ($school_admin_teacher_contact_id = $this->school_admin_teacher_contact_library->add($school_admin_teacher_contact_data)) {
			$this->setResponseElement('school_admin_teacher_contact_id', $school_admin_teacher_contact_id);
		} else {
			$this->setResponseElement('school_admin_teacher_contact_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$school_admin_teacher_contact_id = $this->input->post('school_admin_teacher_contact_id');
		$school_admin_teacher_contact_data = $this->input->post('school_admin_teacher_contact_data');
		$success = $this->school_admin_teacher_contact_library->update($school_admin_teacher_contact_id, $school_admin_teacher_contact_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->school_admin_teacher_contact_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}
}
