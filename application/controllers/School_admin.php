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
		$this->load->model('Classroom_teacher_model');
		$this->load->model('Classroom_grade_model');
	}

	public function index() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'default',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Dashboard',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			if ($school_admin_obj = $this->school_admin_library->get(array('login'=>$login_id), array(), array(), null, null, array('school'=>true))) {
				$school_admin = $school_admin_obj[0];
				$data['school_admin'] = $school_admin;
				$data['classes_count'] = count($this->classroom_library->get(array('school'=>$school_admin['school_id']), array('id')));
				$data['teachers_count'] = count($this->teacher_library->get(array('school'=>$school_admin['school_id'])));
				$data['students_count'] = count($this->student_library->get(array('school'=>$school_admin['school_id'])));
				$data['materials_count'] = 0;

				$this->page->show('default', 'Squlio - Dashboard', 'school_admin_dashboard', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function school_settings() {
		$data = array(
			'headerCss' => array(),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_school_settings',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'School Settings',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			if ($school_admin_obj = $this->school_admin_library->get(array('login'=>$login_id), array(), array(), null, null, array('school'=>true))) {
				$school_admin = $school_admin_obj[0];
				$data['school'] = $school_admin['school'];
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_admin['school_id']));

				$this->page->show('default', 'Squlio - School Settings', 'school_admin_school_settings', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function add_teacher() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_add_teacher',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Teachers',
			'page_subtitle' => 'Add Teacher',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			if ($school_admin_obj = $this->school_admin_library->get(array('login'=>$login_id), array(), array(), null, null, array('school'=>true))) {
				$school_admin = $school_admin_obj[0];
				$data['school'] = $school_admin['school'];
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_admin['school_id']));

				$this->page->show('default', 'Squlio - Add Teacher', 'school_admin_add_teacher', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function teachers() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_teachers',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Teachers',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$teachers_count = count($this->teacher_library->get(array('school'=>$school_id), array('id')));
				$data['teachers_count'] = $teachers_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id));
				$this->page->show('default', 'Squlio - Teachers', 'school_admin_teachers', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function edit_teacher($teacher_id) {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_edit_teacher',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Teachers',
			'page_subtitle' => 'Edit Teacher',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				if ($teacher_obj = $this->teacher_library->get(array('id'=>$teacher_id, 'school'=>$school_id))) {
					$teacher = $teacher_obj[0];
					$data['teacher'] = $teacher;
					$data['jsControllerParam'] = json_encode(array('teacher_id' => $teacher_id));
					$this->page->show('default', 'Squlio - Edit Teacher', 'school_admin_edit_teacher', $data, $data);
					return;
				}
			}
		}
		redirect('/');
	}

	public function add_classroom() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_add_classroom',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Classes',
			'page_subtitle' => 'Add Class',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$classroom_grade_obj = $this->Classroom_grade_model->get(array('school'=>$school_id));
				$data['school_id'] = $school_id;
				$data['classroom_grade'] = $classroom_grade_obj;
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_id));

				$this->page->show('default', 'Squlio - Add Classroom', 'school_admin_add_classroom', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function classes() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_classrooms',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Classes',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$classrooms_count = count($this->classroom_library->get(array('school'=>$school_id), array('id')));
				$data['classrooms_count'] = $classrooms_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id));
				$this->page->show('default', 'Squlio - Classrooms', 'school_admin_classrooms', $data, $data);
				return;
			}
		}
		redirect('/');
	}


	/*
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

	 */
}
