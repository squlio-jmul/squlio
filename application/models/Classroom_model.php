<?php

require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/ClassroomGrade.php");

class Classroom_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy($filters, $order_by, $limit, $offset);

		$classrooms = array();
		foreach($classroom_obj as $index => $obj){
			$classroom = $obj->getData();

			if($fields){
				$temp_classroom = array();
				$temp_classroom['id'] = $classroom['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $classroom)){
						$temp_classroom[$field] = $classroom[$field];
					}
				}
				$classroom = $temp_classroom;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $classroom['school'] = $obj->getFormattedObject('school');
			if((isset($modules['classroom_grade']) && $modules['classroom_grade']) || $modules['all']) $classroom['classroom_grade'] = $obj->getFormattedObject('classroom_grade');
			if((isset($modules['classroom_teacher']) && $modules['classroom_teacher']) || $modules['all']) $classroom['classroom_teacher'] = $obj->getFormattedObject('classroom_teacher');

			$classrooms[] = $classroom;
		}
		$this->doctrine->em->clear();
		return $classrooms;
	}

	public function add($classroom_data) {
		try {
			if (!$classroom_data['school_id'] || !$classroom_data['classroom_grade_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $classroom_data['school_id']));
			$school = $school_obj[0];
			$classroom_grade_obj = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy(array('id' => $classroom_data['classroom_grade_id']));
			$classroom_grade = $classroom_grade_obj[0];

			$new_classroom = new Entities\Classroom;
			$new_classroom->setData($classroom_data);
			$new_classroom->school = $school;
			$new_classroom->classroom_grade = $classroom_grade;

			$this->doctrine->em->persist($new_classroom);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom - add - ' . json_encode($new_classroom->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_classroom->__get('id');
	}

	public function update($classroom_id, $classroom_data){
		try {
			$classroom = $this->doctrine->em->find('Entities\Classroom', $classroom_id);
			$old_obj = $classroom->getData();
			$classroom->setData($classroom_data);

			if (isset($classroom_data['classroom_grade_id'])) {
				$classroom_grade_obj = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy(array('id' => $classroom_data['classroom_grade_id']));
				$classroom_grade = $classroom_grade_obj[0];
				$classroom->classroom_grade = $classroom_grade;
			}
			$this->doctrine->em->persist($classroom);
			$new_obj = $classroom->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
