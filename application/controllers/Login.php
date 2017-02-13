<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends SQ_Controller {

	public function index()
	{
		$data = array(
			'headerCss' => array(
			),
			'headerJs' => array(
			),
			'footerJs' => array(),
			'requireJsDataSource' => 'login',
			'jsControllerParam' => false
		);
		if (!$this->cookie->get('id')) {
			$this->page->show('default', 'Squlio - Login', 'login', $data, $data);
		} else {
			redirect('/welcome');
		}
	}
}
