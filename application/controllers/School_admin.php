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
		$this->load->library('Account_type_library');
	}

	public function index() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'schoolAdminDashboard',
			'jsControllerParam' => false
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$data['login_type'] = $this->cookie->get('type');
			$data['left_panel_type'] = 'school-admin';
			$data['page_title'] = 'Dashboard';
			if ($school_admin_obj = $this->school_admin_library->get(array('login'=>$login_id), array(), array(), null, null, array('school'=>true))) {
				$school_admin = $school_admin_obj[0];
				$data['school_admin'] = $school_admin;
				$data['user_obj'] = $school_admin;
				$this->page->show('default', 'Squlio - School Admin Dashboard', 'school_admin_dashboard', $data, $data);
				return;
			}
		}
		redirect('/');

		$login_id = $this->cookie->get('id');
		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $login_id), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$material_obj = $this->material_library->get(array('school' => $sa['school']['id']));
				$page_data = array(
					'username' => $sa['username'],
					'school' => $sa['school']['name'],
					'address' => $sa['school']['address_1'],
					'teachers'  => $this->teacher_library->getActiveCountBySchoolId($sa['school']['id']),
					'students' => $this->student_library->getActiveCountBySchoolId($sa['school']['id']),
					'classes' => count($this->classroom_library->get(array('school' => $sa['school']['id']))),
					'materials' => isset($material_obj) && $material_obj ? count($material_obj) : 0
				);
			}
		}
		if ($this->cookie->get('id')){
			$this->page->show('school_admin', 'Squlio - School Admin Dashboard', 'school_admin_dashboard', $page_data, $data);
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
				$page_data = array(
					'username' => $sa['username'],
					'teachers' => $this->teacher_library->getActiveCountBySchoolId($sa['school']['id']),
					'school_id' => $sa['school']['id'],
					'school' => $this->school_library->get(array('id'=>$sa['school']['id']))
				);
			}
		}

		if ($this->cookie->get('id')){
			$this->page->show('school_admin_ui', 'Squlio - Teacher', 'teacher', $page_data, $data);
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
				$school_id['school_id'] = $sa['school']['id'];
				$username['username'] = $sa['username'];
				$teachers['teachers'] = $this->teacher_library->getActiveCountBySchoolId($sa['school']['id']);
			}
		}
		if ($school_obj = $this->school_library->get(array('id' => $school_id), array(), array(), null, null, array('account_type'=>true))) {
			foreach ($school_obj as $s) {
				$num_teacher['num_teacher'] = $s['account_type']['num_teacher'];
			}
		}
		$page_data = array_merge($school_id, $username, $num_teacher, $teachers);
		if ($this->cookie->get('id')) {
			$this->page->show('school_admin_ui', 'Squlio - Add Teacher', 'add_teacher', $page_data, $data);
		} else {
			redirect('/school_admin');
		}
	}

	public function editTeacher() {
		$data = array(
			'headerCss' => array('/public/css/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'editTeacher',
			'jsControllerParam' => false
		);

		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $this->cookie->get('id')), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$page_data = array (
					'username' => $sa['username'],
					'school_id' => $sa['school']['id'],
					'teacher' => $this->teacher_library->get(array('id'=> $this->input->get('id')), array(), array(), null, null, array('login'=>true))
				);
			}
		}

		if ($this->cookie->get('id')) {
			$this->page->show('school_admin_ui', 'Squlio - Edit Teacher', 'edit_teacher', $page_data, $data);
		} else {
			redirect('/school_admin');
		}
	}

	public function student() {
		$data = array(
			'headerCss' => array('/public/css/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'viewStudent',
			'jsControllerParam' => false
		);

		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $this->cookie->get('id')), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$username['username'] = $sa['username'];
				$students['students'] = $this->student_library->getActiveCountBySchoolId($sa['school']['id']);

			}
		}
		$page_data = array_merge($username, $students);

		if ($this->cookie->get('id')){
			$this->page->show('school_admin_ui', 'Squlio - Student', 'student', $page_data, $data);
		} else {
			redirect('/school_admin');
		}
	}

	public function addStudent() {
		$data  = array(
			'headerCss' => array('/public/css/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'addStudent',
			'jsControllerParam' => false
		);

		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $this->cookie->get('id')), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$school_id['school_id'] = $sa['school']['id'];
				$username['username'] = $sa['username'];
				$students['students'] = $this->student_library->getActiveCountBySchoolId($sa['school']['id']);
			}
		}
		if ($school_obj = $this->school_library->get(array('id' => $school_id), array(), array(), null, null, array('account_type'=>true))) {
			foreach ($school_obj as $s) {
				$num_student['num_student'] = $s['account_type']['num_student'];
			}
		}
		$classroom_obj['classroom'] = $this->classroom_library->get(array('school' => $school_id));
		$page_data = array_merge($school_id, $username, $num_student, $students, $classroom_obj);
		if ($this->cookie->get('id')) {
			$this->page->show('school_admin_ui', 'Squlio - Add Student', 'add_student', $page_data, $data);
		} else {
			redirect('/school_admin');
		}
	}

	public function classroom() {
		$data = array(
			'headerCss' => array('/public/css/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'viewClassroom',
			'jsControllerParam' => false
		);

		if ($school_admin_obj = $this->school_admin_library->get(array('login' => $this->cookie->get('id')), array(), array(), null, null, array('school'=>true))) {
			foreach ($school_admin_obj as $sa) {
				$username['username'] = $sa['username'];
				$school_id['school_id'] = $sa['school']['id'];
			}
		}

		$page_data = array_merge($username, $school_id);
		if ($this->cookie->get('id')){
			$this->page->show('school_admin_ui', 'Squlio - Classes', 'classroom', $page_data, $data);
		} else {
			redirect('/school_admin');
		}
	}
}
