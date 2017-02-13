<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SQ_Controller {

	public function index()
	{
		$data = array(
			'headerCss' => array(
			),
			'headerJs' => array(
			),
			'footerJs' => array(),
			'requireJsDataSource' => false,
			'jsControllerParam' => false
		);
		if (!$this->cookie->get('id')) {
			redirect('/');
		} else {
			$this->page->show('default', 'Squlio - Welcome', 'home', $data, $data);
		}
	}
}
