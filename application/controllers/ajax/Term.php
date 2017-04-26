<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Term extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Term_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($terms = $this->term_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('terms', $terms);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$term_data = $this->input->post('term_data');
		if ($term_id = $this->term_library->add($term_data)) {
			$this->setResponseElement('term_id', $term_id);
		} else {
			$this->setResponseElement('term_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$term_id = $this->input->post('term_id');
		$term_data = $this->input->post('term_data');
		$success = $this->term_library->update($term_id, $term_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->term_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function nameNotExist() {
		$name = $this->input->post('name');
		$school_id = $this->input->post('school_id');
		if ($term_obj = $this->term_library->get(array('school'=>$school_id, 'name'=>$name))) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}
}
