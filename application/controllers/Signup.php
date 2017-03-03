<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends SQ_Controller{
	public function index(){
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'signup',
			'jsControllerParam' => false
		);
		$this->page->show('default', 'Squlio - Signup', 'signup', $data, $data);
	}
}
