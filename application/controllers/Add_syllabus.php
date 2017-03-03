<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_syllabus extends SQ_Controller {
	public function index() {
		$this->load->model('Term_model');
		$this->load->model('Classroom_model');
		$this->load->model('Classroom_subject_model');

		$data = array(
			'headerCss' => array('/public/css/jquery-ui.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'addsyllabus',
			'jsControllerParam' => false
		);

		$term_data = array(
			'term' => null
		);
		$classroom_data = array(
			'classroom' => null
		);
		$classroom_subject_data = array(
			'classroom_subject' => null
		);

		$term_obj = $this->Term_model->get();
		$term_data['term'] = $term_obj;
		$classroom_obj = $this->Classroom_model->get();
		$classroom_data['classroom'] = $classroom_obj;
		$classroom_subject_obj = $this->Classroom_subject_model->get();
		$classroom_subject_data['classroom_subject'] = $classroom_subject_obj;
		$pageData = array_merge($term_data, $classroom_data, $classroom_subject_data);

		if ($this->cookie->get('id')){
			$this->page->show('default', 'Squlio - Add Syllabus', 'addSyllabus', $pageData, $data);
		} else {
			redirect('/login');
		}
	}
}
