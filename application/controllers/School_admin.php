<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class School_admin extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('School_admin_library');
		$this->load->library('School_library');
		$this->load->library('Classroom_library');
		$this->load->library('Teacher_library');
		$this->load->library('Student_library');
		$this->load->library('Material_library');
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
			'requireJsDataSource' => 'schoolAdminDashboard',
			'jsControllerParam' => false
		);

		$login_id = $this->cookie->get('id');
		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $login_id), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$username['username'] = $sa['username'];
				$school['school'] = $sa['school']['name'];
				$address['address'] = $sa['school']['address_1'];
				$teachers['teachers'] = $this->teacher_library->getActiveCountBySchoolId($sa['school']['id']);
				$students['students'] = $this->student_library->getActiveCountBySchoolId($sa['school']['id']);
				if ($classroom_obj = $this->classroom_library->get(array('school' => $sa['school']['id']))){
					$classes['classes'] = count($classroom_obj);
				} else {
					$classes['classes'] = "0";
				}
				if ($material_obj = $this->material_library->get(array('school' => $sa['school']['id']))) {
					$materials['materials'] = count($material_obj);
				} else {
					$materials['materials'] = "0";
				}
			}
		}
		$pageData = array_merge($username, $school, $address, $teachers, $students, $classes, $materials); 
		if ($login_id){
			$this->page->show('school_admin_ui', 'Squlio - School Admin Dashboard', 'school_admin_dashboard', $pageData, $data);
		} else {
			redirect('/school_admin');
		}
	}

	public function teacher () {
		$data = array(
			'headerCss' => array('/public/css/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'viewTeacher',
			'jsControllerParam' => false
		);

		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $this->cookie->get('id')), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$username['username'] = $sa['username'];
				$teachers['teachers'] = $this->teacher_library->getActiveCountBySchoolId($sa['school']['id']);

			}
		}
		$pageData = array_merge($username, $teachers);

		if ($this->cookie->get('id')){
			$this->page->show('school_admin_ui', 'Squlio - School Admin', 'teacher', $pageData, $data);
		} else {
			redirect('/school_admin');
		}
	}

	public function addTeacher() {
		$data  = array(
			'headerCss' => array('/public/css/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'addTeacher',
			'jsControllerParam' => false
		);

		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $this->cookie->get('id')), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$school['school'] = $sa['school']['id'];
				$username['username'] = $sa['username'];
			}
		}
		$pageData = array_merge($school, $username);
		if ($this->cookie->get('id')) {
			$this->page->show('school_admin_ui', 'Squlio - Add Teacher', 'add_teacher', $pageData, $data);
		} else {
			redirect('/school_admin');
		}
	}
}
