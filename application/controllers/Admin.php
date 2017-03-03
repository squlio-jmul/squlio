<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SQ_Controller{
	public function index() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'admin',
			'jsControllerParam' => false
		);
		if (!$this->cookie->get('id')){
			$this->page->show('default', 'Squlio - Admin', 'admin', $data, $data);
		} else {
			redirect('/admin/dashboard');
		}
	}

	public function dashboard() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => false,
			'jsControllerParam' => false
		);
		if ($this->cookie->get('id')){
			$this->page->show('default', 'Squlio - Dashboard', 'dashboard', $data, $data);
		}
	}
}
