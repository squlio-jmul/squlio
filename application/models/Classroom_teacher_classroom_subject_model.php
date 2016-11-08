<?php

require_once(APPPATH."models/Entities/ClassroomTeacherClassroomSubject.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/Teacher.php");
require_once(APPPATH."models/Entities/ClassroomSubject.php");

class Classroom_teacher_classroom_subject_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$classroom_teacher_classroom_subject_obj = $this->doctrine->em->getRepository('Entities\ClassroomTeacherClassroomSubject')->findBy($filters, $order_by, $limit, $offset);

		$classroom_teacher_classroom_subjects = array();
		foreach($classroom_teacher_classroom_subject_obj as $index => $obj){
			$classroom_teacher_classroom_subject = $obj->getData();

			if($fields){
				$temp_classroom_teacher_classroom_subject = array();
				$temp_classroom_teacher_classroom_subject['id'] = $classroom_teacher_classroom_subject['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $classroom_teacher_classroom_subject)){
						$temp_classroom_teacher_classroom_subject[$field] = $classroom_teacher_classroom_subject[$field];
					}
				}
				$classroom_teacher_classroom_subject = $temp_classroom_teacher_classroom_subject;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['classroom']) && $modules['classroom']) || $modules['all']) $classroom_teacher_classroom_subject['classroom'] = $obj->getFormattedObject('classroom');
			if((isset($modules['teacher']) && $modules['teacher']) || $modules['all']) $classroom_teacher_classroom_subject['teacher'] = $obj->getFormattedObject('teacher');
			if((isset($modules['classroom_subject']) && $modules['classroom_subject']) || $modules['all']) $classroom_teacher_classroom_subject['classroom_subject'] = $obj->getFormattedObject('classroom_subject');

			$classroom_teacher_classroom_subjects[] = $classroom_teacher_classroom_subject;
		}
		$this->doctrine->em->clear();
		return $classroom_teacher_classroom_subjects;
	}

	public function add($classroom_teacher_classroom_subject_data) {
		try {
			if (!$classroom_teacher_classroom_subject_data['classroom_id'] || !$classroom_teacher_classroom_subject_data['teacher_id'] || !$classroom_teacher_classroom_subject_data['classroom_subject_id']) {
				return false;
			}
			$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $classroom_teacher_classroom_subject_data['classroom_id']));
			$classroom = $classroom_obj[0];
			$teacher_obj = $this->doctrine->em->getRepository('Entities\Teacher')->findBy(array('id' => $classroom_teacher_classroom_subject_data['teacher_id']));
			$teacher = $teacher_obj[0];
			$classroom_subject_obj = $this->doctrine->em->getRepository('Entities\ClassroomSubject')->findBy(array('id' => $classroom_teacher_classroom_subject_data['classroom_subject_id']));
			$classroom_subject = $classroom_subject_obj[0];

			$new_classroom_teacher_classroom_subject = new Entities\ClassroomTeacherClassroomSubject;
			$new_classroom_teacher_classroom_subject->setData($classroom_teacher_classroom_subject_data);
			$new_classroom_teacher_classroom_subject->classroom = $classroom;
			$new_classroom_teacher_classroom_subject->teacher = $teacher;
			$new_classroom_teacher_classroom_subject->classroom_subject = $classroom_subject;

			$this->doctrine->em->persist($new_classroom_teacher_classroom_subject);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_teacher_classroom_subject - add - ' . json_encode($new_classroom_teacher_classroom_subject->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_classroom_teacher_classroom_subject->__get('id');
	}

	public function update($classroom_teacher_classroom_subject_id, $classroom_teacher_classroom_subject_data){
		try {
			$classroom_teacher_classroom_subject = $this->doctrine->em->find('Entities\ClassroomTeacherClassroomSubject', $classroom_teacher_classroom_subject_id);
			$old_obj = $classroom_teacher_classroom_subject->getData();
			$classroom_teacher_classroom_subject->setData($classroom_teacher_classroom_subject_data);
			$this->doctrine->em->persist($classroom_teacher_classroom_subject);
			$new_obj = $classroom_teacher_classroom_subject->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_teacher_classroom_subject - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
