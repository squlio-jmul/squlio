<?php

require_once(APPPATH."models/Entities/ClassroomGrade.php");
require_once(APPPATH."models/Entities/School.php");

class Classroom_grade_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$classroom_grade_obj = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy($filters, $order_by, $limit, $offset);

		$classroom_grades = array();
		foreach($classroom_grade_obj as $index => $obj){
			$classroom_grade = $obj->getData();

			if($fields){
				$temp_classroom_grade = array();
				$temp_classroom_grade['id'] = $classroom_grade['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $classroom_grade)){
						$temp_classroom_grade[$field] = $classroom_grade[$field];
					}
				}
				$classroom_grade = $temp_classroom_grade;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $classroom_grade['school'] = $obj->getFormattedObject('school');

			$classroom_grades[] = $classroom_grade;
		}
		$this->doctrine->em->clear();
		return $classroom_grades;
	}

	public function add($classroom_grade_data) {
		try {
			if (!$classroom_grade_data['school_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $classroom_grade_data['school_id']));
			$school = $school_obj[0];

			$new_classroom_grade = new Entities\ClassroomGrade;
			$new_classroom_grade->setData($classroom_grade_data);
			$new_classroom_grade->school = $school;

			$this->doctrine->em->persist($new_classroom_grade);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_grade - add - ' . json_encode($new_classroom_grade->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_classroom_grade->__get('id');
	}

	public function update($classroom_grade_id, $classroom_grade_data){
		try {
			$classroom_grade = $this->doctrine->em->find('Entities\ClassroomGrade', $classroom_grade_id);
			$old_obj = $classroom_grade->getData();
			$classroom_grade->setData($classroom_grade_data);
			$this->doctrine->em->persist($classroom_grade);
			$new_obj = $classroom_grade->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_grade - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
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
			$delete_classroom_grade_arr = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy($filters);
			foreach($delete_classroom_grade_arr as $index => $classroom_grade){
				$this->doctrine->em->remove($classroom_grade);
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
