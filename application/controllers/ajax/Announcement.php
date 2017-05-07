<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Announcement_library');
	}

	public function get() {
		$filters = ($this->input->post('filters')) ? $this->input->post('filters') : array();
		$fields = ($this->input->post('fields')) ? $this->input->post('fields') : array();
		$order_by = ($this->input->post('order_by')) ? $this->input->post('order_by') : array();
		$limit = ($this->input->post('limit')) ? $this->input->post('limit') : null;
		$offset = ($this->input->post('offset')) ? $this->input->post('offset') : null;
		$modules = ($this->input->post('modules')) ? $this->input->post('modules') : array();

		$announcements = $this->announcement_library->get($filters, $fields, $order_by, $limit, $offset, $modules);
		$this->setResponseElement('success', true);
		$this->setResponseElement('announcements', $announcements);
		$this->sendResponse();
	}

	public function add() {
		$announcement_data = $this->input->post('announcement_data');
		if ($announcement_id = $this->announcement_library->add($announcement_data)) {
			$this->setResponseElement('announcement_id', $announcement_id);
		} else {
			$this->setResponseElement('announcement_id', null);
		}
		$this->sendResponse();
	}

	public function update() {
		$announcement_id = $this->input->post('announcement_id');
		$announcement_data = $this->input->post('announcement_data');
		$success = $this->announcement_library->update($announcement_id, $announcement_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function delete() {
		$filters = $this->input->post('filters') ? $this->input->post('filters') : array();
		$success = $this->announcement_library->delete($filters);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function addBulk() {
		$announcement_data = $this->input->post('announcement_data');
		$success = $this->announcement_library->addBulk($announcement_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

}
