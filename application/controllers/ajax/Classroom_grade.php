<?php
defined('BASEPATH') OR exit('No direct script allowed');

class Classroom_grade extends SQ_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Classroom_grade_library');
	}

	public function get() {
		$filters = ($this->getInputPost('filters')) ? $this->getInputPost('filters') : array();
		$fields = ($this->getInputPost('fields')) ? $this->getInputPost('fields') : array();
		$order_by = ($this->getInputPost('order_by')) ?  $this->getInputPost('order_by') : array();
		$limit = ($this->getInputPost('limit')) ? $this->getInputPost('limit') : null;
		$offset = ($this->getInputPost('offset')) ? $this->getInputPost('offset') : null;
		$modules = ($this->getInputPost('modules')) ? $this->getInputPost('modules') : array();

		if($classroom_grades = $this->classroom_grade_library->get($filters, $fields, $order_by, $limit, $offset, $modules)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('classroom_grades', $classroom_grades);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	public function add() {
		$add_classroom_grade_data = array (
			'school_id' => $this->input->post('school_id'),
			'name' => $this->input->post('name'),
			'display_name' => $this->input->post('display_name'),
			'active' => 1,
			'deleted' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($classroom_grade_id = $this->classroom_grade_library->add($add_classroom_grade_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('classroom_grade_id', $classroom_grade_id);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}

	/*public function update(){
		$account_type_id = $this->input->post('id');
		$update_account_type_data = array(
			'name' => $this->input->post('name'),
			'display_name' => $this->input->post('display_name'),
			'num_principal' => $this->input->post('num_principal'),
			'num_school_admin' => $this->input->post('num_school_admin'),
			'num_teacher' => $this->input->post('num_teacher'),
			'num_classroom' => $this->input->post('num_classroom'),
			'num_guardian' => $this->input->post('num_guardian'),
			'num_student' => $this->input->post('num_student'),
			'active' => 1,
			'deleted' => 0,
			'created_on' => new \DateTime('now'),
			'last_updated' => new \DateTime('now')
		);
		if ($account_type = $this->account_type_library->update($account_type_id, $update_account_type_data)) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('account_type', $account_type);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}*/

	public function displayTable() {
		$school_id = $this->input->post('school_id');
		$table_data = array();
		if ($classroom_grade_obj = $this->classroom_grade_library->get(array('school'=>$school_id), array(), array(), null, null, array('school'=>true))){
			foreach($classroom_grade_obj as $ca){

				$data = array(
					'id' => $ca['id'],
					'school_name' => $ca['school']['name'],
					'display_name' => $ca['display_name'],
					'action' => $ca['id']
				);
				$table_data[] = $data;
			}
		}
		//echo json_encode(array('data' => $table_data));
		if ($table_data) {
			$this->setResponseElement('success', true);
			$this->setResponseElement('classroom_grade_data', $table_data);
		} else {
			$this->setResponseElement('success', false);
		}
		$this->sendResponse();
	}
}
