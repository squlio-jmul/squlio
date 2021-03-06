<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Admin_library');
	}

	public function get() {
		$filsters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if ($admins = $this->admin_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$tthis->setResponseElement('success', true);
			$this->setResponseElement('admins', $admins);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}
}
