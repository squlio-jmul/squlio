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
		$email = $this->input->post('username');
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

	public function usernameNotExist() {
		$username = $this->input->post('username');
		if ($login_obj = $this->login_library->get(array('username'=>$username))) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}

	public function emailNotExist() {
		$email = $this->input->post('email');
		if ($login_obj = $this->login_library->get(array('email'=>$email))) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}

	public function editEmailNotExist() {
		$email = $this->input->post('email');
		$user_obj = $this->login_library->get(['id' =>$login_id]);
		var_dump($user_obj);
		if ($user_obj['email'] != $email && $login_obj = $this->login_library->get(array('email'=>$email))) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}
}
