<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Classroom_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($classrooms = $this->classroom_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('classrooms', $classrooms);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$classroom_data = $this->input->post('classroom_data');
		if ($classroom_id = $this->classroom_library->add($classroom_data)) {
			$this->setResponseElement('classroom_id', $classroom_id);
		} else {
			$this->setResponseElement('classroom_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$classroom_id = $this->input->post('classroom_id');
		$classroom_data = $this->input->post('classroom_data');
		$success = $this->classroom_library->update($classroom_id, $classroom_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function upload_image() {
		$response = $this->classroom_library->uploadImage($_FILES['file']);
		$this->setResponseElement('success', $response['success']);
		$this->setResponseElement('error_msg', $response['error_msg']);
		$this->setResponseElement('url_path', $response['url_path']);
		$this->sendResponse();
	}

	public function nameNotExist() {
		$name = $this->input->post('name');
		$school_id = $this->input->post('school_id');
		if ($this->classroom_library->get(array('name'=>$name, 'school'=>$school_id))) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}

	public function editNameNotExist() {
		$name = $this->input->post('name');
		$school_id = $this->input->post('school_id');
		$classroom_id = $this->input->post('classroom_id');
		$classroom_obj = $this->classroom_library->get(array('name'=>$name, 'school'=>$school_id));
		if ($classroom_obj && $classroom_obj[0]['id'] != $classroom_id) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}
}
