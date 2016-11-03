<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index()
	{
		$this->load->model('Login_model');
		$logins = $this->Login_model->get();
		echo 'here';
	}
}
