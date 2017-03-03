<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View_syllabus extends SQ_Controller{
	public function index() {
		$this->load->model('Classroom_model');
		$this->load->model('Term_model');
		$data = array(
			'headerCss' => array('/public/css/jquery.dataTables.min.css'),
			'headerJs' => array(),
			'footerJs' => array(),
			'requireJsDataSource' => 'viewsyllabus',
			'jsControllerParam' => false
		);
		$classroom_data = array(
			'classroom' => null
		);
		$term_data = array(
			'term' => null
		);
		$classroom_obj = $this->Classroom_model->get();
		$classroom_data['classroom'] = $classroom_obj;
		$term_obj = $this->Term_model->get();
		$term_data['term'] = $term_obj;
		$pageData = array_merge($classroom_data, $term_data);
		if ($this->cookie->get('id')){
			$this->page->show('default', 'Squlio - View Syllabus', 'viewsyllabus', $pageData, $data);
		} else {
			redirect('/login');
		}

	}
}
