<?php

require_once(APPPATH."models/Entities/GuardianStudent.php");
require_once(APPPATH."models/Entities/Guardian.php");
require_once(APPPATH."models/Entities/Student.php");

class Guardian_student_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$guardian_student_obj = $this->doctrine->em->getRepository('Entities\GuardianStudent')->findBy($filters, $order_by, $limit, $offset);

		$guardian_students = array();
		foreach($guardian_student_obj as $index => $obj){
			$guardian_student = $obj->getData();

			if($fields){
				$temp_guardian_student = array();
				$temp_guardian_student['id'] = $guardian_student['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $guardian_student)){
						$temp_guardian_student[$field] = $guardian_student[$field];
					}
				}
				$guardian_student = $temp_guardian_student;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['guardian']) && $modules['guardian']) || $modules['all']) $guardian_student['guardian'] = $obj->getFormattedObject('guardian');
			if((isset($modules['student']) && $modules['student']) || $modules['all']) $guardian_student['student'] = $obj->getFormattedObject('student');

			$guardian_students[] = $guardian_student;
		}
		$this->doctrine->em->clear();
		return $guardian_students;
	}

	public function add($guardian_student_data) {
		try {
			if (!$guardian_student_data['guardian_id'] || !$guardian_student_data['student_id']) {
				return false;
			}
			$guardian_obj = $this->doctrine->em->getRepository('Entities\Guardian')->findBy(array('id' => $guardian_student_data['guardian_id']));
			$guardian = $guardian_obj[0];
			$student_obj = $this->doctrine->em->getRepository('Entities\Student')->findBy(array('id' => $guardian_student_data['student_id']));
			$student = $student_obj[0];

			$new_guardian_student = new Entities\GuardianStudent;
			$new_guardian_student->setData($guardian_student_data);
			$new_guardian_student->guardian = $guardian;
			$new_guardian_student->student = $student;

			$this->doctrine->em->persist($new_guardian_student);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('guardian_student - add - ' . json_encode($new_guardian_student->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_guardian_student->__get('id');
	}

	public function update($guardian_student_id, $guardian_student_data){
		try {
			$guardian_student = $this->doctrine->em->find('Entities\GuardianStudent', $guardian_student_id);
			$old_obj = $guardian_student->getData();
			$guardian_student->setData($guardian_student_data);
			$this->doctrine->em->persist($guardian_student);
			$new_obj = $guardian_student->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('guardian_student - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
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
			$delete_guardian_student_arr = $this->doctrine->em->getRepository('Entities\GuardianStudent')->findBy($filters);
			foreach($delete_guardian_student_arr as $index => $guardian_student){
				$this->doctrine->em->remove($guardian_student);
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
