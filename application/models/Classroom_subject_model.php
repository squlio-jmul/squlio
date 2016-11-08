<?php

require_once(APPPATH."models/Entities/ClassroomSubject.php");
require_once(APPPATH."models/Entities/School.php");

class Classroom_subject_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$classroom_subject_obj = $this->doctrine->em->getRepository('Entities\ClassroomSubject')->findBy($filters, $order_by, $limit, $offset);

		$classroom_subjects = array();
		foreach($classroom_subject_obj as $index => $obj){
			$classroom_subject = $obj->getData();

			if($fields){
				$temp_classroom_subject = array();
				$temp_classroom_subject['id'] = $classroom_subject['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $classroom_subject)){
						$temp_classroom_subject[$field] = $classroom_subject[$field];
					}
				}
				$classroom_subject = $temp_classroom_subject;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $classroom_subject['school'] = $obj->getFormattedObject('school');

			$classroom_subjects[] = $classroom_subject;
		}
		$this->doctrine->em->clear();
		return $classroom_subjects;
	}

	public function add($classroom_subject_data) {
		try {
			if (!$classroom_subject_data['school_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $classroom_subject_data['school_id']));
			$school = $school_obj[0];

			$new_classroom_subject = new Entities\ClassroomSubject;
			$new_classroom_subject->setData($classroom_subject_data);
			$new_classroom_subject->school = $school;

			$this->doctrine->em->persist($new_classroom_subject);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_subject - add - ' . json_encode($new_classroom_subject->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_classroom_subject->__get('id');
	}

	public function update($classroom_subject_id, $classroom_subject_data){
		try {
			$classroom_subject = $this->doctrine->em->find('Entities\ClassroomSubject', $classroom_subject_id);
			$old_obj = $classroom_subject->getData();
			$classroom_subject->setData($classroom_subject_data);
			$this->doctrine->em->persist($classroom_subject);
			$new_obj = $classroom_subject->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_subject - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
