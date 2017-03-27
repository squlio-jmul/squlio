<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_admin extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('School_admin_library');
	}

	public function index() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin',
			'jsControllerParam' => false
		);
		if (!$this->cookie->get('id')){
			$this->page->show('default', 'Squlio - School Admin', 'school_admin', $data, $data);
		} else {
			redirect('/admin/dashboard');
		}

	}
}
