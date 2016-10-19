<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	public function index()
	{
		$this->load->model('Login_model');
		$logins = $this->Login_model->get();
		print_r($logins); die();
		echo 'Hello World!';
		exit(0);
	}
}
