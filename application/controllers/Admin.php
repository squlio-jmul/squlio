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
			'headerCss' => array('/public/css/bootstrap.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'dashboard',
			'jsControllerParam' => false
		);

		$school_admin_obj['school_admin'] = $this->Login_model->get(array('type'=>'school_admin', 'active'=>true, 'deleted'=>false));
		$school_obj['school'] = $this->School_model->get();
		$principal_obj['principal'] = $this->Login_model->get(array('type'=>'principal', 'active'=>true, 'deleted'=>false));

		foreach ($school_admin_obj as $sa) {
			$school_admin_amount['school_admin_amount'] = count($sa);
		}
		foreach ($school_obj as $s) {
			$school_amount['school_amount'] = count($s);
		}
		foreach ($principal_obj as $p) {
			$principal_amount['principal_amount'] = count($p);
		}

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

		$account_type_obj['account_type'] = $this->Account_type_model->get(['id'=>$this->input->get('id')]);
		$pageData = $account_type_obj;

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

		$school_obj['school'] = $this->School_model->get();
		foreach ($school_obj as $s) {
			$school_amount['school_amount'] = count($s);
		}

		$pageData = $school_amount;

		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Schools', 'school', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

	public function addSchool() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'addSchool',
			'jsControllerParam' => false
		);
		$account_type_obj['account_type'] = $this->Account_type_model->get();
		$pageData = $account_type_obj;
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
		$school_obj['school'] = $this->School_model->get(['id'=>$get_type_id]);
		$account_type_obj['account_type'] = $this->Account_type_model->get();
		$principal_obj['principal'] = $this->Principal_model->getActivePrincipal($get_type_id);
		$school_admin_obj['school_admin'] = $this->School_admin_model->getActiveSchoolAdmin($get_type_id);
		$pageData = array_merge($school_obj, $account_type_obj, $principal_obj, $school_admin_obj);
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Edit School', 'edit_school', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

	public function classroomGrade() {
		$data = array(
			'headerCss' => array('/public/css/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'classroomGrade',
			'jsControllerParam' => false
		);

		$school_obj['school'] = $this->School_model->get();
		$pageData = $school_obj;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Classroom Grade', 'classroom_grade', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

	public function addClassroomGrade() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'addClassroomGrade',
			'jsControllerParam' => false
		);

		$school_obj['school'] = $this->School_model->get();
		$pageData = $school_obj;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Classroom Grade', 'add_classroom_grade', $pageData, $data);
		} else {
			redirect('/admin');
		}
	}

}
