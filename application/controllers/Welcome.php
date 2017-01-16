<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function __construct()
	{
		parent:: __construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library(array('session'));
		$this->load->database();
	
	}
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function signup()

	{
		$this->load->model('Login_model');
		$this->load->model('School_admin_model');
		$add_data = array(
			'email' => $this->input->post('email'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password'),
			'type' => 'admin',
			'token' => 'blah',
			'active' => 1,
			'deleted' => 0,
			'reset_password' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		//$this->load->model('School_admin_model');
		try {
			if ($login_id = $this->Login_model->add($add_data)) {
				$add_data2 = array(
					'login_id' => $login_id,
					'school_id' => 1,
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'created_on' => new \DateTime('now'),
					'last_updated' => new \DateTime('now')
				);
				$school_admin_id = $this->School_admin_model->add($add_data2);
				var_dump($school_admin_id);
				$logins = $this->Login_model->get();
				$school_admins = $this->School_admin_model->get();
				var_dump($school_admins);
			}
		} catch (Exception $e) {
			die ($e->getMessage());
		}

		//print_r($logins);
		die();
	}
	public function signupform()
	{
		$this->load->view('signupform');
	}
}
