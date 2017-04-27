<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pickup extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Pickup_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		$pickups = $this->pickup_library->get($filters, $fields, $order_by, $limit, $offset, $modules);
		$this->setResponseElement('success', true);
		$this->setResponseElement('pickups', $pickups);
		$this->sendResponse();
	}

	public function add() {
		$pickup_data = $this->input->post('pickup_data');
		if ($pickup_id = $this->pickup_library->add($pickup_data)) {
			$this->setResponseElement('pickup_id', $pickup_id);
		} else {
			$this->setResponseElement('pickup_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$pickup_id = $this->input->post('pickup_id');
		$pickup_data = $this->input->post('pickup_data');
		$success = $this->pickup_library->update($pickup_id, $pickup_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->pickup_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}
}
