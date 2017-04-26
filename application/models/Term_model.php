<?php

require_once(APPPATH."models/Entities/Term.php");
require_once(APPPATH."models/Entities/School.php");

class Term_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$term_obj = $this->doctrine->em->getRepository('Entities\Term')->findBy($filters, $order_by, $limit, $offset);

		$terms = array();
		foreach($term_obj as $index => $obj){
			$term = $obj->getData();

			if($fields){
				$temp_term = array();
				$temp_term['id'] = $term['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $term)){
						$temp_term[$field] = $term[$field];
					}
				}
				$term = $temp_term;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $term['school'] = $obj->getFormattedObject('school');

			$terms[] = $term;
		}
		$this->doctrine->em->clear();
		return $terms;
	}

	public function add($term_data) {
		try {
			if (!$term_data['school_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $term_data['school_id']));
			$school = $school_obj[0];

			$new_term = new Entities\Term;
			$new_term->setData($term_data);
			$new_term->school = $school;

			$this->doctrine->em->persist($new_term);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('term - add - ' . json_encode($new_term->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_term->__get('id');
	}

	public function update($term_id, $term_data){
		try {
			$term = $this->doctrine->em->find('Entities\Term', $term_id);
			$old_obj = $term->getData();
			$term->setData($term_data);
			$this->doctrine->em->persist($term);
			$new_obj = $term->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('term - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}

	public function delete($filters = array()){
		if(!$filters){
			return false;
		}

		try{
			$delete_term_arr = $this->doctrine->em->getRepository('Entities\Term')->findBy($filters);
			foreach($delete_term_arr as $index => $term){
				$this->doctrine->em->remove($term);
			}
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}

}
