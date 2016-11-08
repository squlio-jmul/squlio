<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index()
	{
		$this->load->model('Login_model');
		$add_data = array(
			'email' => 'johan.mulyono@gmail.com',
			'username' => 'johan',
			'password' => 'blah',
			'type' => 'admin',
			'token' => 'blah',
			'active' => 1,
			'deleted' => 0,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		$login_id = $this->Login_model->add($add_data);
		var_dump($login_id);
		$logins = $this->Login_model->get();
		print_r($logins);
		die();
	}
}
