<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Student_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($students = $this->student_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('students', $students);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$student_data = $this->input->post('student_data');
		if ($student_id = $this->student_library->add($student_data)) {
			$this->setResponseElement('student_id', $student_id);
		} else {
			$this->setResponseElement('student_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$student_id = $this->input->post('student_id');
		$student_data = $this->input->post('student_data');
		$success = $this->student_library->update($student_id, $student_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function upload_image() {
		$response = $this->student_library->uploadImage($_FILES['file']);
		$this->setResponseElement('success', $response['success']);
		$this->setResponseElement('error_msg', $response['error_msg']);
		$this->setResponseElement('url_path', $response['url_path']);
		$this->sendResponse();
	}
}
