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
		$this->load->library('Account_type_library');
		$this->load->library('Classroom_grade_library');
		$this->load->library('Guardian_student_library');
		$this->load->library('Guardian_library');
		$this->load->library('Term_library');
		$this->load->library('Subject_library');
		$this->load->library('Schedule_library');
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
				$data['subjects_count'] = count($this->subject_library->get(array('school'=>$school_admin['school_id'])));

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
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$teacher_limit = 0;
				if ($school_obj = $this->school_library->get(array('id'=>$school_id), array(), array(), null, null, array('account_type'=>true))) {
					$school = $school_obj[0];
					$teacher_limit = $school['account_type']['num_teacher'];
				}
				$teachers_count = count($this->teacher_library->get(array('school'=>$school_id), array('id')));
				if ($teachers_count >= $teacher_limit) {
					redirect('/school_admin/teachers');
				}
				$data['school'] = $school;
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_id));

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
				$teacher_limit = 0;
				if ($school_obj = $this->school_library->get(array('id'=>$school_id), array(), array(), null, null, array('account_type'=>true))) {
					$teacher_limit = $school_obj[0]['account_type']['num_teacher'];
				}
				$teachers_count = count($this->teacher_library->get(array('school'=>$school_id), array('id')));
				$data['teachers_count'] = $teachers_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id, 'teacher_limit' => $teacher_limit));
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
				if ($teacher_obj = $this->teacher_library->get(array('id'=>$teacher_id, 'school'=>$school_id), array(), array(), null, null, array('classroom_teacher'=>true, 'login'=>true))) {
					$teacher = $teacher_obj[0];
					$selected_classroom_ids = array_map(function ($obj) {return $obj['classroom_id'];}, $teacher['classroom_teacher']);

					$classroom_obj = $this->classroom_library->get(array('school'=>$school_id, 'active'=>true, 'deleted'=>false), array(), array('name'=>'asc'));
					$data['teacher'] = $teacher;
					$data['jsControllerParam'] = json_encode(array('teacher_id' => $teacher_id, 'classrooms'=>$classroom_obj, 'selected_classroom_ids'=>$selected_classroom_ids));
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
				$classroom_limit = 0;
				if ($school_obj = $this->school_library->get(array('id'=>$school_id), array(), array(), null, null, array('account_type'=>true))) {
					$school = $school_obj[0];
					$classroom_limit = $school['account_type']['num_classroom'];
				}
				$classrooms_count = count($this->classroom_library->get(array('school'=>$school_id), array('id')));
				if ($classrooms_count >= $classroom_limit) {
					redirect('/school_admin/classes');
				}

				$classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id));
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
				$classroom_limit = 0;
				if ($school_obj = $this->school_library->get(array('id'=>$school_id), array(), array(), null, null, array('account_type'=>true))) {
					$school = $school_obj[0];
					$classroom_limit = $school['account_type']['num_classroom'];
				}
				$classrooms_count = count($this->classroom_library->get(array('school'=>$school_id), array('id')));
				$data['classrooms_count'] = $classrooms_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id, 'classroom_limit' => $classroom_limit));
				$this->page->show('default', 'Squlio - Classrooms', 'school_admin_classrooms', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function edit_classroom($classroom_id) {
		$data = array(
			'headerCss' => array(
				$this->config->item('static_css') . '/jquery-ui.css',
				$this->config->item('static_css') . '/jquery.dataTables.min.css'
			),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_edit_classroom',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Classes',
			'page_subtitle' => 'Edit Class',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				if ($classroom_obj = $this->classroom_library->get(array('id'=>$classroom_id, 'school'=>$school_id), array(), array(), null, null, array('classroom_teacher'=>true, 'student'=>true))) {
					$classroom = $classroom_obj[0];
					$classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id), array(), array('name'=>'asc'));
					$subject_obj = $this->subject_library->get(array('school'=>$school_id, 'classroom_grade'=>$classroom['classroom_grade_id']), array(), array('title'=>'asc'));
					$term_obj = $this->term_library->get(array('school'=>$school_id), array(), array('name'=>'asc'));

					$teacher_obj = $this->teacher_library->get(array('school'=>$school_id), array(), array('first_name'=>'asc', 'last_name'=>'asc'));
					$selected_teacher_ids = array_map(function ($obj) {return $obj['teacher_id'];}, $classroom['classroom_teacher']);
					$primary_teacher_id = null;
					foreach ($classroom['classroom_teacher'] as $ct) {
						if ($ct['is_primary']) {
							$primary_teacher_id = $ct['teacher_id'];
							break;
						}
					}
					$student_obj = $this->student_library->get(array('school'=>$school_id, 'classroom_grade'=>$classroom['classroom_grade_id'], 'active'=>true, 'deleted'=>false), array(), array('first_name'=>'asc', 'last_name'=>'asc'));
					$selected_student_ids = array_map(function ($obj) { return $obj['id'];}, $classroom['student']);

					$data['classroom'] = $classroom;
					$data['classroom_grade'] = $classroom_grade_obj;
					$data['subject'] = $subject_obj;
					$data['student'] = $student_obj;
					$data['selected_student_ids'] = $selected_student_ids;
					$data['term'] = $term_obj;
					$data['jsControllerParam'] = json_encode(array('classroom_id' => $classroom_id, 'teachers'=>$teacher_obj, 'selected_teacher_ids'=>$selected_teacher_ids, 'primary_teacher_id'=>$primary_teacher_id, 'selected_student_ids'=>$selected_student_ids));
					$this->page->show('default', 'Squlio - Edit Classroom', 'school_admin_edit_classroom', $data, $data);
					return;
				}
			}
		}
		redirect('/');
	}

	public function add_student() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_add_student',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Students',
			'page_subtitle' => 'Add Student',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$student_limit = 0;
				if ($school_obj = $this->school_library->get(array('id'=>$school_id), array(), array(), null, null, array('account_type'=>true))) {
					$school = $school_obj[0];
					$student_limit = $school['account_type']['num_student'];
				}
				$students_count = count($this->student_library->get(array('school'=>$school_id), array('id')));
				if ($students_count >= $student_limit) {
					redirect('/school_admin/students');
				}

				$classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id));
				$data['school'] = $school;
				$data['classroom_grade'] = $classroom_grade_obj;
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_id));

				$this->page->show('default', 'Squlio - Add Student', 'school_admin_add_student', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function students() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_students',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Students',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$student_limit = 0;
				if ($school_obj = $this->school_library->get(array('id'=>$school_id), array(), array(), null, null, array('account_type'=>true))) {
					$student_limit = $school_obj[0]['account_type']['num_student'];
				}
				$students_count = count($this->student_library->get(array('school'=>$school_id), array('id')));
				$data['students_count'] = $students_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id, 'student_limit' => $student_limit));
				$this->page->show('default', 'Squlio - Students', 'school_admin_students', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function edit_student($student_id) {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_edit_student',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Students',
			'page_subtitle' => 'Edit Student',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				if ($student_obj = $this->student_library->get(array('id'=>$student_id, 'school'=>$school_id))) {
					$student = $student_obj[0];
					$classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id));
					$classroom_obj = $this->classroom_library->get(array('school'=>$school_id, 'classroom_grade'=>$student['classroom_grade_id'], 'active'=>true, 'deleted'=>false));
					$father = $mother = array();
					$guardian_student_obj = $this->guardian_student_library->get(array('student'=>$student['id']), array('guardian_id'));
					if ($guardian_student_obj) {
						$guardian_ids = array_map(function ($obj) {return $obj['guardian_id'];}, $guardian_student_obj);
						if ($guardian_obj = $this->guardian_library->get(array('id'=>$guardian_ids), array(), array(), null, null, array('login'=>true))) {
							foreach($guardian_obj as $g) {
								if ($g['type'] == 'father') {
									$father = $g;
								} elseif ($g['type'] == 'mother') {
									$mother = $g;
								}
							}
						}
					}

					$data['student'] = $student;
					$data['classroom_grade'] = $classroom_grade_obj;
					$data['classroom'] = $classroom_obj;
					$data['guardian_student'] = $guardian_student_obj;
					$data['father'] = $father;
					$data['mother'] = $mother;
					$data['jsControllerParam'] = json_encode(array('student_id' => $student_id, 'school_id' => $student['school_id']));
					$this->page->show('default', 'Squlio - Edit Student', 'school_admin_edit_student', $data, $data);
					return;
				}
			}
		}
		redirect('/');
	}

	public function add_term() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_add_term',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Terms',
			'page_subtitle' => 'Add Term',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$data['school_id'] = $school_id;
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_id));

				$this->page->show('default', 'Squlio - Add Term', 'school_admin_add_term', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function terms() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_terms',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Terms',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$terms_count = count($this->term_library->get(array('school'=>$school_id), array('id')));
				$data['terms_count'] = $terms_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id));
				$this->page->show('default', 'Squlio - Terms', 'school_admin_terms', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function edit_term($term_id) {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_edit_term',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Terms',
			'page_subtitle' => 'Edit Term',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				if ($term_obj = $this->term_library->get(array('id'=>$term_id, 'school'=>$school_id))) {
					$term = $term_obj[0];
					$data['term'] = $term;
					$data['jsControllerParam'] = json_encode(array('term_id' => $term_id));
					$this->page->show('default', 'Squlio - Edit Term', 'school_admin_edit_term', $data, $data);
					return;
				}
			}
		}
		redirect('/');
	}

	public function add_subject() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_add_subject',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Subjects',
			'page_subtitle' => 'Add Subject',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id));
				$data['school_id'] = $school_id;
				$data['classroom_grade'] = $classroom_grade_obj;
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_id));

				$this->page->show('default', 'Squlio - Add Subject', 'school_admin_add_subject', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function subjects() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_subjects',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Subjects',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$subjects_count = count($this->subject_library->get(array('school'=>$school_id), array('id')));
				$data['subjects_count'] = $subjects_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id));
				$this->page->show('default', 'Squlio - Subjects', 'school_admin_subjects', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function edit_subject($subject_id) {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_edit_subject',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Subjects',
			'page_subtitle' => 'Edit Subject',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				if ($subject_obj = $this->subject_library->get(array('id'=>$subject_id, 'school'=>$school_id))) {
					$subject = $subject_obj[0];

					$classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id));
					$data['subject'] = $subject;
					$data['classroom_grade'] = $classroom_grade_obj;
					$data['jsControllerParam'] = json_encode(array('subject_id' => $subject_id));
					$this->page->show('default', 'Squlio - Edit Subject', 'school_admin_edit_subject', $data, $data);
					return;
				}
			}
		}
		redirect('/');
	}

	public function add_classroom_grade() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_add_classroom_grade',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Classroom Grades',
			'page_subtitle' => 'Add Classroom Grade',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$data['school_id'] = $school_id;
				$data['jsControllerParam'] = json_encode(array('school_id'=>$school_id));

				$this->page->show('default', 'Squlio - Add Classroom Grade', 'school_admin_add_classroom_grade', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function classroom_grades() {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_classroom_grades',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Classroom Grades',
			'page_subtitle' => null,
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				$classroom_grades_count = count($this->classroom_grade_library->get(array('school'=>$school_id), array('id')));
				$data['classroom_grades_count'] = $classroom_grades_count;
				$data['jsControllerParam'] = json_encode(array('school_id' => $school_id));
				$this->page->show('default', 'Squlio - Classroom Grades', 'school_admin_classroom_grades', $data, $data);
				return;
			}
		}
		redirect('/');
	}

	public function edit_classroom_grade($classroom_grade_id) {
		$data = array(
			'headerCss' => array($this->config->item('static_css') . '/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'school_admin_edit_classroom_grade',
			'jsControllerParam' => false,
			'user_obj' => $this->cookie->get('type_info') ? $this->cookie->get('type_info') : array(),
			'page_title' => 'Classroom Grades',
			'page_subtitle' => 'Edit Classroom Grade',
			'login_type' => $this->cookie->get('type') ? $this->cookie->get('type') : null
		);

		if ($this->cookie->get('id') && $this->cookie->get('type') == 'school_admin') {
			$login_id = $this->cookie->get('id');
			$school_admin = $data['user_obj'];
			$school_id = $school_admin['school_id'];
			if ($school_id) {
				if ($classroom_grade_obj = $this->classroom_grade_library->get(array('id'=>$classroom_grade_id, 'school'=>$school_id))) {
					$classroom_grade = $classroom_grade_obj[0];
					$data['classroom_grade'] = $classroom_grade;
					$data['jsControllerParam'] = json_encode(array('classroom_grade_id' => $classroom_grade_id));
					$this->page->show('default', 'Squlio - Edit Classroom Grade', 'school_admin_edit_classroom_grade', $data, $data);
					return;
				}
			}
		}
		redirect('/');
	}

}
