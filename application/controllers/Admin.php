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
		$this->load->model('Classroom_grade_model');
		$this->load->model('Classroom_model');
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

		$page_data = array(
			'school_admin_count' => count($this->Login_model->get(array('type'=>'school_admin', 'active'=>true, 'deleted'=>false))),
			'school_count' => count($this->School_model->get(array('active'=>true, 'deleted'=>false))),
			'principal_count' => count($this->Login_model->get(array('type'=>'principal', 'active'=>true, 'deleted'=>false)))
		);

		if ($this->cookie->get('id')){
			$this->page->show('admin_ui', 'Squlio - Dashboard', 'dashboard', $page_data, $data);
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
		$page_data = $account_type_data;

		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Apps Settings', 'settings', $page_data, $data);
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
		$page_data = $account_type_obj;

		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Edit Account Type', 'edit_type', $page_data, $data);
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
		$page_data = array(
			'school_count' => count($this->School_model->get(array('active'=>true, 'deleted'=>false)))
		);

		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Schools', 'school', $page_data, $data);
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
		$page_data = $account_type_obj;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Add School', 'add_school', $page_data, $data);
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
		$page_data = array (
			'school' => $this->School_model->get(['id'=>$this->input->get('id')]),
			'account_type' => $this->Account_type_model->get(),
			'principal' => $this->Principal_model->getActivePrincipal($this->input->get('id')),
			'school_admin' => $this->School_admin_model->getActiveSchoolAdmin($this->input->get('id'))
		);
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Edit School', 'edit_school', $page_data, $data);
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
		$page_data = $school_obj;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Classroom Grade', 'classroom_grade', $page_data, $data);
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
		$page_data = $school_obj;
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Classroom Grade', 'add_classroom_grade', $page_data, $data);
		} else {
			redirect('/admin');
		}
	}

	public function editClassroomGrade() {
		$data = array(
			'headerCss' => array('/public/css/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'editClassroomGrade',
			'jsControllerParam' => false
		);
		if ($classroom_grade_obj = $this->Classroom_grade_model->get(array('id'=>$this->input->get('id')), array(), array(), null, null, array('school'=> true))) {
			foreach ($classroom_grade_obj as $cg) {
				$classroom_grade['classroom_grade'] = $classroom_grade_obj;
				$school_name['school_name'] = $cg['school']['name'];
				$classroom_count['classroom_count'] = count($this->Classroom_model->get(array('classroom_grade'=>$this->input->get('id'))));
			}
		}
		$page_data = array_merge($classroom_grade, $school_name, $classroom_count);
		if ($this->cookie->get('id')) {
			$this->page->show('admin_ui', 'Squlio - Edit School', 'edit_classroom_grade', $page_data, $data);
		} else {
			redirect('/admin');
		}

	}

}
