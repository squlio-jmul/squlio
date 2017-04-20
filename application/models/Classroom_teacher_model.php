<?php

require_once(APPPATH."models/Entities/ClassroomTeacher.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/Teacher.php");

class Classroom_teacher_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$classroom_teacher_obj = $this->doctrine->em->getRepository('Entities\ClassroomTeacher')->findBy($filters, $order_by, $limit, $offset);

		$classroom_teachers = array();
		foreach($classroom_teacher_obj as $index => $obj){
			$classroom_teacher = $obj->getData();

			if($fields){
				$temp_classroom_teacher = array();
				$temp_classroom_teacher['id'] = $classroom_teacher['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $classroom_teacher)){
						$temp_classroom_teacher[$field] = $classroom_teacher[$field];
					}
				}
				$classroom_teacher = $temp_classroom_teacher;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['classroom']) && $modules['classroom']) || $modules['all']) $classroom_teacher['classroom'] = $obj->getFormattedObject('classroom');
			if((isset($modules['teacher']) && $modules['teacher']) || $modules['all']) $classroom_teacher['teacher'] = $obj->getFormattedObject('teacher');

			$classroom_teachers[] = $classroom_teacher;
		}
		$this->doctrine->em->clear();
		return $classroom_teachers;
	}

	public function add($classroom_teacher_data) {
		try {
			if (!$classroom_teacher_data['classroom_id'] || !$classroom_teacher_data['teacher_id']) {
				return false;
			}
			$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $classroom_teacher_data['classroom_id']));
			$classroom = $classroom_obj[0];
			$teacher_obj = $this->doctrine->em->getRepository('Entities\Teacher')->findBy(array('id' => $classroom_teacher_data['teacher_id']));
			$teacher = $teacher_obj[0];

			$new_classroom_teacher = new Entities\ClassroomTeacher;
			$new_classroom_teacher->setData($classroom_teacher_data);
			$new_classroom_teacher->classroom = $classroom;
			$new_classroom_teacher->teacher = $teacher;

			$this->doctrine->em->persist($new_classroom_teacher);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_teacher - add - ' . json_encode($new_classroom_teacher->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_classroom_teacher->__get('id');
	}

	public function update($classroom_teacher_id, $classroom_teacher_data){
		try {
			$classroom_teacher = $this->doctrine->em->find('Entities\ClassroomTeacher', $classroom_teacher_id);
			$old_obj = $classroom_teacher->getData();
			$classroom_teacher->setData($classroom_teacher_data);
			$this->doctrine->em->persist($classroom_teacher);
			$new_obj = $classroom_teacher->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('classroom_teacher - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
