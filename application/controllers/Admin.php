<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends SQ_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('School_admin_model');
		$this->load->model('School_model');
		$this->load->model('Principal_model');
		$this->load->model('Account_type_model');
		$this->load->model('Login_model');
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
				'/public/css/bootstrap.min.css'
				),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'dashboard',
			'jsControllerParam' => false
		);
		$schoo_admin_id = array(
			'school_admin' => null
		);
		$school_id = array(
			'school' => null
		);
		$principal_id = array(
			'principal' => null
		);
		$school_admin_obj = $this->School_admin_model->get();
		$school_admin_id['school_admin'] = $school_admin_obj;
		$school_obj = $this->School_model->get();
		$school_id['school'] = $school_obj;
		$principal_obj = $this->Principal_model->get();
		$principal_id['principal'] = $principal_obj;
		foreach ($school_admin_id as $a) {
			$school_admin_value = count($a);
		}
		foreach ($school_id as $s) {
			$school_value = count($s);
		}
		foreach ($principal_id as $p) {
			$principal_value = count($p);
		}
		$school_admin_amount['school_admin_amount'] = $school_admin_value;
		$school_amount['school_amount'] = $school_value;
		$principal_amount['principal_amount'] = $principal_value;
		$pageData = array_merge($school_admin_amount, $school_amount, $principal_amount);
		if ($this->cookie->get('id')){
			$this->page->show('admin_ui', 'Squlio - Dashboard', 'dashboard', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

	public function settings() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'settings',
			'jsControllerParam' => false
		);

		$account_type_data = array (
			'account_type' => null
		);
		$account_type_obj = $this->Account_type_model->get();
		$account_type_data['account_type'] = $account_type_obj;
		$pageData = $account_type_data;

		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Apps Settings', 'settings', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

	public function addType() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' =>'addAccountType' ,
			'jqControllerParam' => false
		);
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Add New Type', 'add_type', $data, $data);
		} else {
			redirect('/admin');
		}
	}

	public function editType() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'editAccountType',
			'jsControllerParam' => false
		);

		$get_type_id = $this->input->get('id');
		$account_type_obj = $this->Account_type_model->get(['id'=>$get_type_id]);
		$account_type_data = array (
			'account_type' => null
		);
		$account_type_data['account_type'] =  $account_type_obj;
		$pageData = $account_type_data;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Edit Account Type', 'edit_type', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

	public function school() {
		$data = array(
			'headerCss' => array('/public/css/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school',
			'jsControllerParam' => false
		);

		$school_id = array(
			'school' => null
		);
		$school_obj = $this->School_model->get();
		$school_id['school'] = $school_obj;
		foreach ($school_id as $sid) {
			$school_value = count($sid);
		}
		$school_amount['school_amount'] = $school_value;
		$pageData = $school_amount;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Schools', 'school', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

	public function addSchool() {
		$data = array(
			'headerCss' => array('/public/css/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'addSchool',
			'jsControllerParam' => false
		);
		$account_type = array(
			'account_type' => null
		);
		$account_type_obj = $this->Account_type_model->get();
		$account_type['account_type'] = $account_type_obj;
		$pageData = $account_type;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Add School', 'add_school', $pageData, $data);
		} else {
			redirect('admin');
		}
	}

	public function editSchool() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'editSchool',
			'jsControllerParam' => false
		);

		$get_type_id = $this->input->get('id');
			$school_data = array (
			'school' => null
		);
		$account_type = array (
			'account_type' => null
		);
		$principal = array (
			'principal' => null
		);
		$school_admin = array (
			'school_admin' =>null
		);
		$login = array (
			'login' => null
		);

		$school_obj = $this->School_model->get(['id'=>$get_type_id]);
		$account_type_obj = $this->Account_type_model->get();
		$principal_obj = $this->Principal_model->get(['school'=>$get_type_id]);
		$school_admin_obj = $this->School_admin_model->get(['school'=>$get_type_id]);
		$login_obj = $this->Login_model->get(['id' => $get_type_id]);

		$school_data['school'] =  $school_obj;
		$account_type['account_type'] = $account_type_obj;
		$principal['principal'] = $principal_obj;
		$school_admin['school_admin'] = $school_admin_obj;
		$login['login'] = $login_obj;

		$pageData = array_merge($school_data, $account_type, $principal, $school_admin);
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Edit School', 'edit_school', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}


}
