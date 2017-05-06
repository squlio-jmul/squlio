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

		$logins = $this->login_library->get($filters, $fields, $order_by, $limit, $offset, $modules);
		$this->setResponseElement('success', true);
		$this->setResponseElement('logins', $logins);
		$this->sendResponse();
	}

	public function verifyLogin() {
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$login_response = $this->login_library->verifyLogin($email, $password);

		$this->setResponseElement('success', $login_response['success']);
		if($login_response['success']){
			$this->setResponseElement('redirect_page', $login_response['redirect_page']);
			$this->setResponseElement('id', $login_response['id']);
			$this->cookie->set($login_response['cookie_obj']);
		}
		$this->sendResponse();
	}

	public function update() {
		$login_id = $this->input->post('login_id');
		$login_data = $this->input->post('login_data');
		$success = $this->login_library->update($login_id, $login_data);
		$this->setResponseElement('success', $success);
		$this->sendResponse();
	}

	public function emailExist() {
		$email = $this->input->post('email');
		$exist = $this->login_library->emailExist($email);
		if ($exist) {
			echo 'true';
		} else {
			echo 'false';
		}
		die();
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
		$login_id = $this->input->post('login_id');
		$email_obj = $this->login_library->get(array('email'=>$email));
		if ($email_obj && $email_obj[0]['id'] != $login_id) {
			echo 'false';
		} else {
			echo 'true';
		}
		return;
	}

	public function passwordMatch() {
		$old_password = $this->input->post('old_password');
		$login_id = $this->input->post('login_id');
		$login_obj = $this->login_library->get(array('id'=>$login_id));
		if ($old_password == $login_obj[0]['password']) {
			echo 'true';
		} else {
			echo 'false';
		}
		return;
	}
}
