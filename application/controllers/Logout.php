<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends SQ_Controller {

	public function index()
	{
		$this->cookie->destroy_all();
		redirect('/login');
	}
}
