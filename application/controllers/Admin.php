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
		$this->load->model('Admin_model');
		$data = array(
			'headerCss' => array(
				//'/public/css/simple-sidebar.css',
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
		$admin_obj = $this->Admin_model->get();
		$admin_id['admin'] = $admin_obj;
		echo "<pre>";
		$total =  count($admin_id);
		echo "console.log($total)";
		echo "</pre>";
		$pageData = $admin_id;
		if ($this->cookie->get('id')){
			$this->page->show('default', 'Squlio - Dashboard', 'dashboard', $pageData, $data);
		}
	}
}
