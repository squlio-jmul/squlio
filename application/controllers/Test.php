<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
	public function index()
	{
		$this->load->model('Principal_model');
		$num_principal = $this->Principal_model->getActiveCountBySchoolId(3);
		var_dump($num_principal);
		die();
	}
}
