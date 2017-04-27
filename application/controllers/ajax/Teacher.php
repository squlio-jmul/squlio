<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Teacher_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		$teachers = $this->teacher_library->get($filters, $fields, $order_by, $limit, $offset, $modules);
		$this->setResponseElement('success', true);
		$this->setResponseElement('teachers', $teachers);
		$this->sendResponse();
	}

	public function add() {
		$teacher_data = $this->input->post('teacher_data');
		if ($teacher_id = $this->teacher_library->add($teacher_data)) {
			$this->setResponseElement('teacher_id', $teacher_id);
		} else {
			$this->setResponseElement('teacher_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$teacher_id = $this->input->post('teacher_id');
		$teacher_data = $this->input->post('teacher_data');
		$success = $this->teacher_library->update($teacher_id, $teacher_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function upload_image() {
		$response = $this->teacher_library->uploadImage($_FILES['file']);
		$this->setResponseElement('success', $response['success']);
		$this->setResponseElement('error_msg', $response['error_msg']);
		$this->setResponseElement('url_path', $response['url_path']);
		$this->sendResponse();
	}
}
