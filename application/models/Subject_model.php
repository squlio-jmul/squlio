<?php

require_once(APPPATH."models/Entities/Subject.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/ClassroomGrade.php");

class Subject_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$subject_obj = $this->doctrine->em->getRepository('Entities\Subject')->findBy($filters, $order_by, $limit, $offset);

		$subjects = array();
		foreach($subject_obj as $index => $obj){
			$subject = $obj->getData();

			if($fields){
				$temp_subject = array();
				$temp_subject['id'] = $subject['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $subject)){
						$temp_subject[$field] = $subject[$field];
					}
				}
				$subject = $temp_subject;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $subject['school'] = $obj->getFormattedObject('school');
			if((isset($modules['classroom_grade']) && $modules['classroom_grade']) || $modules['all']) $subject['classroom_grade'] = $obj->getFormattedObject('classroom_grade');

			$subjects[] = $subject;
		}
		$this->doctrine->em->clear();
		return $subjects;
	}

	public function add($subject_data) {
		try {
			if (!$subject_data['school_id'] || !$subject_data['classroom_grade_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $subject_data['school_id']));
			$school = $school_obj[0];
			$classroom_grade_obj = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy(array('id' => $subject_data['classroom_grade_id']));
			$classroom_grade = $classroom_grade_obj[0];


			$new_subject = new Entities\Subject;
			$new_subject->setData($subject_data);
			$new_subject->school = $school;
			$new_subject->classroom_grade = $classroom_grade;

			$this->doctrine->em->persist($new_subject);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('subject - add - ' . json_encode($new_subject->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_subject->__get('id');
	}

	public function update($subject_id, $subject_data){
		try {
			$subject = $this->doctrine->em->find('Entities\Subject', $subject_id);
			$old_obj = $subject->getData();
			$subject->setData($subject_data);

			if (isset($subject_data['classroom_grade_id'])) {
				$classroom_grade_obj = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy(array('id' => $subject_data['classroom_grade_id']));
				$classroom_grade = $classroom_grade_obj[0];
				$subject->classroom_grade = $classroom_grade;
			}
			$this->doctrine->em->persist($subject);
			$new_obj = $subject->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('subject - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
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
			$delete_subject_arr = $this->doctrine->em->getRepository('Entities\Subject')->findBy($filters);
			foreach($delete_subject_arr as $index => $subject){
				$this->doctrine->em->remove($subject);
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
