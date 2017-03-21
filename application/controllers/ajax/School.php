<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class School extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('School_library');
		$this->load->library('School_admin_library');
		$this->load->library('Account_type_library');
		$this->load->library('Principal_library');
		$this->load->library('Classroom_library');
		$this->load->library('Student_library');
		$this->load->library('Classroom_library');
		$this->load->library('Teacher_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ? $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($schools = $this->school_library->get($filters, $fields, $order_by, $limit, $offset, $modules)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('schools', $schools);
		}else{
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function addSchool(){
		$add_school_data = array(
			'account_type_id' => $this->input->post('account_type_id'),
			'name' => $this->input->post('school_name'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => '',
			'city' => $this->input->post('city'),
			'state' => 'DKI Jakarta',
			'zipcode' => $this->input->post('zipcode'),
			'country' => 'Indonesia',
			'phone_1' => $this->input->post('phone_1'),
			'phone_2' => '',
			'branch' => '',
			'email' => $this->input->post('school_email'),
			'url' => '',
			'code' => 1,
			'active' => 1,
			'deleted' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($school_id = $this->school_library->add($add_school_data)){
			$this->setResponseElement('success', true);
			$this->setResponseElement('school_id', $school_id);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function update(){
		$school_id = $this->input->post('id');
		$update_school_data = array(
			'account_type_id' => $this->input->post('account_type'),
			'name' => $this->input->post('name'),
			'address_1' => $this->input->post('address_1'),
			'address_2' => '',
			'city' => $this->input->post('city'),
			'state' => 'DKI Jakarta',
			'zipcode' => $this->input->post('zipcode'),
			'country' => 'Indonesia',
			'phone_1' => $this->input->post('phone_1'),
			'phone_2' => '',
			'branch' => '',
			'email' => $this->input->post('email'),
			'url' => '',
			'code' => 1,
			'active' => 1,
			'deleted' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($school = $this->school_library->update($school_id, $update_school_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('school_id', $school_id);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}


	public function displayTable() {

		$table_data = array();
		if ($school_obj = $this->school_library->get(array(), array(), array(), null, null, array('account_type'=>true))){
			foreach($school_obj as $s){
				$num_principal = $this->principal_library->getActiveCountBySchoolId($s['id']);
				$num_school_admin = $this->school_admin_library->getActiveCountBySchoolId($s['id']);
				$num_teacher = $this->teacher_library->getActiveCountBySchoolId($s['id']);
				$num_student = $this->student_library->getActiveCountBySchoolId($s['id']);
				$classroom_obj = $this->classroom_library->get(['school' => $s['id']]);

				$data = array(
					'id' => $s['id'],
					'name' => $s['name'],
					'num_principal' => $num_principal,
					'num_school_admin' => $num_school_admin,
					'num_teacher' => $num_teacher,
					'num_student' => $num_student,
					'num_classroom' => isset($classroom_obj)&& $classroom_obj ? count($classroom_obj) : 0,
					'status' => $s['account_type']['display_name'],
					'action' => $s['id']
				);
				$table_data[] = $data;
			}
		}
		echo json_encode(array('data' => $table_data));
	}
}
