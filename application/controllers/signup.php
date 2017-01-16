<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Hello extends CI_Controller {

	public function index()
	{
		//echo "<h1>"."TEST PAGE"."<h1/>";
		//echo "<br>"."<br/>";
		//echo "<h2>". "Hello World"."<h2/>";
		$this->load->view('signupform');
	}
}
