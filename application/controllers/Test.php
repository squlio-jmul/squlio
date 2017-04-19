<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index()
	{
		$this->load->model('Teacher_model');
		$this->Teacher_model->update(15, array('birthday'=> new \DateTime('1990-01-10')));
		die();
	}
}
