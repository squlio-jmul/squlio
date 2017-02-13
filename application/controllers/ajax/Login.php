<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Login_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($logins = $this->login_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('logins', $logins);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function verifyLogin() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$login_response = $this->login_library->verifyLogin($username, $password);

		$this->setResponseElement('success', $login_response['success']);
		if($login_response['success']){
			$this->setResponseElement('redirect_page', $login_response['redirect_page']);
			$this->setResponseElement('id', $login_response['id']);
			$this->cookie->set($login_response['cookie_obj']);
		}
		$this->sendResponse();
	}
}
