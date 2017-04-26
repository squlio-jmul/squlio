<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Schedule_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		if($schedules = $this->schedule_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('schedules', $schedules);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$schedule_data = $this->input->post('schedule_data');
		if ($schedule_id = $this->schedule_library->add($schedule_data)) {
			$this->setResponseElement('schedule_id', $schedule_id);
		} else {
			$this->setResponseElement('schedule_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$schedule_id = $this->input->post('schedule_id');
		$schedule_data = $this->input->post('schedule_data');
		$success = $this->schedule_library->update($schedule_id, $schedule_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->schedule_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

}
