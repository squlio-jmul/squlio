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
			redirect('/school_admin/schoolAdminDashboard');
		}
	}

	public function schoolAdminDashboard() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => false,
			'jsControllerParam' => false
		);

		if ($this->cookie->get('id')){
			$this->page->show('admin_ui', 'Squlio - School Admin Dashboard', 'school_admin_dashboard', $data, $data);
		} else {
			redirect('/admin');
		}
	}



}
