<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SQ_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('School_model');
		$this->load->model('Principal_model');
	}

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
			'headerCss' => array(
				'/public/css/bootstrap.css',
				'/public/css/bootstrap.min.css'
				),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'dashboard',
			'jsControllerParam' => false
		);
		$admin_id = array(
			'admin' => null
		);
		$school_id = array(
			'school' => null
		);
		$principal_id = array(
			'principal' => null
		);
		$admin_obj = $this->Admin_model->get();
		$admin_id['admin'] = $admin_obj;
		$school_obj = $this->School_model->get();
		$school_id['school'] = $school_obj;
		$principal_obj = $this->Principal_model->get();
		$principal_id['principal'] = $principal_obj;
		foreach ($admin_id as $a) {
			$admin_value = count($a);
		}
		foreach ($school_id as $s) {
			$school_value = count($s);
		}
		foreach ($principal_id as $p) {
			$principal_value = count($p);
		}
		$admin_amount['admin_amount'] = $admin_value;
		$school_amount['school_amount'] = $school_value;
		$principal_amount['principal_amount'] = $principal_value;
		$pageData = array_merge($admin_amount, $school_amount, $principal_amount);
		if ($this->cookie->get('id')){
			$this->page->show('default', 'Squlio - Dashboard', 'dashboard', $pageData, $data);
		}
	}
}