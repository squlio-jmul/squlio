<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends SQ_Controller {
	public function index() {
		$data = array(
			'headerCss' => array(
			),
			'headerJs' => array(
			),
			'footerJs' => array(),
			'requireJsDataSource' => 'login',
			'jsControllerParam' => false
		);
		if ($this->cookie->get('id')) {
			$id = $this->cookie->get('id');
			$type = $this->cookie->get('type');
			switch($type) {
				case 'admin':
					redirect('/admin');
					break;
				case 'school_admin':
					redirect('/school_admin');
					break;
				default:
					$this->cookie->destroy_all();
					break;
			}
		}
		$this->page->show('default_no_footer', 'Squlio - Login', 'login', $data, $data);
	}
}
