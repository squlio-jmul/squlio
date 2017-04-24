<?php

require_once(APPPATH."models/Entities/Student.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/ClassroomGrade.php");

class Student_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$student_obj = $this->doctrine->em->getRepository('Entities\Student')->findBy($filters, $order_by, $limit, $offset);

		$students = array();
		foreach($student_obj as $index => $obj){
			$student = $obj->getData();

			if($fields){
				$temp_student = array();
				$temp_student['id'] = $student['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $student)){
						$temp_student[$field] = $student[$field];
					}
				}
				$student = $temp_student;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $student['school'] = $obj->getFormattedObject('school');
			if((isset($modules['classroom']) && $modules['classroom']) || $modules['all']) $student['classroom'] = $obj->getFormattedObject('classroom');
			if((isset($modules['classroom_grade']) && $modules['classroom_grade']) || $modules['all']) $student['classroom_grade'] = $obj->getFormattedObject('classroom_grade');

			$students[] = $student;
		}
		$this->doctrine->em->clear();
		return $students;
	}

	public function add($student_data) {
		try {
			if (!$student_data['school_id'] || !$student_data['classroom_grade_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $student_data['school_id']));
			$school = $school_obj[0];
			$classroom_grade_obj = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy(array('id' => $student_data['classroom_grade_id']));
			$classroom_grade = $classroom_grade_obj[0];
			$classroom = null;
			if (isset($student_data['classroom_id']) && $student_data['classroom_id']) {
				$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $student_data['classroom_id']));
				$classroom = $classroom_obj[0];
			}

			$new_student = new Entities\Student;
			$new_student->setData($student_data);
			$new_student->school = $school;
			$new_student->classroom_grade = $classroom_grade;
			if ($classroom) {
				$new_student->classroom = $classroom;
			}

			$this->doctrine->em->persist($new_student);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('student - add - ' . json_encode($new_student->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_student->__get('id');
	}

	public function update($student_id, $student_data){
		try {
			$student = $this->doctrine->em->find('Entities\Student', $student_id);
			$old_obj = $student->getData();
			$student->setData($student_data);
			if ($student_data['classroom_grade_id']) {
				$classroom_grade_obj = $this->doctrine->em->getRepository('Entities\ClassroomGrade')->findBy(array('id' => $student_data['classroom_grade_id']));
				$classroom_grade = $classroom_grade_obj[0];
				$student->classroom_grade = $classroom_grade;
			}
			if ($student_data['classroom_id']) {
				$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $student_data['classroom_id']));
				$classroom = $classroom_obj[0];
				$student->classroom = $classroom;
			}
			if (isset($student_data['birthday'])) {
				$student_data['birthday'] = new \DateTime($student_data['birthday']);
			}
			$this->doctrine->em->persist($student);
			$new_obj = $student->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('student - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
