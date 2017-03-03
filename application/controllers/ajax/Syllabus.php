<?php
//defined('BSEPATH') OR exit('No direct script access allowed');

class Syllabus extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Syllabus_library');

	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($thit->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($syllabuses = $this->syllabus_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success',true);
			$this->setResponseElement('syllabuses',$syllabuses);
		} else {
			$this->setResponseElement('success',false);
		}
		$this->sendResponse();
	}

	public function displayTable(){

		if($this->input->post('term_id')){
			$syllabus_data = array(
				'classroom' => $this->input->post('classroom_id'),
				'term' => $this->input->post('term_id')
			);
		} else {
			$syllabus_data = array(
				'classroom' => $this->input->post('classroom_id')
			);
		}

		$table_data = array();
		if ($syllabus_obj = $this->syllabus_library->get($syllabus_data)){
			foreach($syllabus_obj as $s) {
				$row = array();
				$row[] = $s['id'];
				$row[] = $s['school_id'];
				$row[] = $s['term_id'];
				$row[] = $s['classroom_id'];
				$row[] = $s['classroom_subject_id'];
				$row[] = $s['title'];
				$row[] = $s['description'];
				$row[] = $s['created_on']->format('Y/m/d h:i:s');
				$row[] = $s['last_updated']->format('Y/m/d h:i:s');

				$table_data[] = $row;
			}
		}

		if ($table_data){
			$this->setResponseElement('success', true);
			$this->setResponseElement('syllabus_data', $table_data);
			$this->setResponseElement('classroom_id', $syllabus_data);
			$this->setResponseElement('term_id', $syllabus_data);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add(){

		$get_term_value  = array(
			'term' => $this->input->post('term_id')
		);
		$get_classroom_value = array(
			'classroom' => $this->input->post('classroom_id')
		);
		$get_classroom_subject_value = array(
			'classroom_subject' => $this->input->post('classroom_subject_id')
		);

		$add_syllabus_data = array(
			'school_id' => 1,
			'term_id' =>  $get_term_value,
			'classroom_id' => $get_classroom_value,
			'classroom_subject_id' => $get_classroom_subject_value,
			'title' => $this->input->post('title'),
			'description' => $this->input->post('description'),
			'date' => $this->input->post('date'),
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($syllabus_id = $this->syllabus_library->add($add_syllabus_data)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('syllabus_id', $syllabus_id);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}
}
