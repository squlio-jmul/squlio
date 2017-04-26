<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classroom_grade extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Classroom_grade_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($classroom_grades = $this->classroom_grade_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('classroom_grades', $classroom_grades);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$classroom_grade_data = $this->input->post('classroom_grade_data');
		if ($classroom_grade_id = $this->classroom_grade_library->add($classroom_grade_data)) {
			$this->setResponseElement('classroom_grade_id', $classroom_grade_id);
		} else {
			$this->setResponseElement('classroom_grade_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$classroom_grade_id = $this->input->post('classroom_grade_id');
		$classroom_grade_data = $this->input->post('classroom_grade_data');
		$success = $this->classroom_grade_library->update($classroom_grade_id, $classroom_grade_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->classroom_grade_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function nameNotExist() {
		$name = $this->input->post('name');
		$school_id = $this->input->post('school_id');
		if ($classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id, 'name'=>$name))) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}

	public function editNameNotExist() {
		$name = $this->input->post('name');
		$school_id = $this->input->post('school_id');
		$classroom_grade_id = $this->input->post('classroom_grade_id');
		if ($classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id, 'name'=>$name))) {
			if ($classroom_grade_obj[0]['id'] != $classroom_grade_id) {
				echo 'false';
			} else {
				echo 'true';
			}
		} else {
			echo 'true';
		}
		return;
	}

}
