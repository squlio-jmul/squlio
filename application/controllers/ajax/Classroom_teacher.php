<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom_teacher extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Classroom_teacher_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($classroom_teachers = $this->classroom_teacher_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('classroom_teachers', $classroom_teachers);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$classroom_teacher_data = $this->input->post('classroom_teacher_data');
		if ($classroom_teacher_id = $this->classroom_teacher_library->add($classroom_teacher_data)) {
			$this->setResponseElement('classroom_teacher_id', $classroom_teacher_id);
		} else {
			$this->setResponseElement('classroom_teacher_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$classroom_teacher_id = $this->input->post('classroom_teacher_id');
		$classroom_teacher_data = $this->input->post('classroom_teacher_data');
		$success = $this->classroom_teacher_library->update($classroom_teacher_id, $classroom_teacher_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function setPrimary() {
		$classroom_teacher_id = $this->input->post('classroom_teacher_id');
		$success = $this->classroom_teacher_library->setPrimary($classroom_teacher_id);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

}
