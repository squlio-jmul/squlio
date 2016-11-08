<?php

require_once(APPPATH."models/Entities/Syllabus.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Term.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/ClassroomSubject.php");

class Syllabus_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$syllabus_obj = $this->doctrine->em->getRepository('Entities\Syllabus')->findBy($filters, $order_by, $limit, $offset);

		$syllabuses = array();
		foreach($syllabus_obj as $index => $obj){
			$syllabus = $obj->getData();

			if($fields){
				$temp_syllabus = array();
				$temp_syllabus['id'] = $syllabus['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $syllabus)){
						$temp_syllabus[$field] = $syllabus[$field];
					}
				}
				$syllabus = $temp_syllabus;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $syllabus['school'] = $obj->getFormattedObject('school');
			if((isset($modules['term']) && $modules['term']) || $modules['all']) $syllabus['term'] = $obj->getFormattedObject('term');
			if((isset($modules['classroom']) && $modules['classroom']) || $modules['all']) $syllabus['classroom'] = $obj->getFormattedObject('classroom');
			if((isset($modules['classroom_subject']) && $modules['classroom_subject']) || $modules['all']) $syllabus['classroom_subject'] = $obj->getFormattedObject('classroom_subject');

			$syllabuses[] = $syllabus;
		}
		$this->doctrine->em->clear();
		return $syllabuses;
	}

	public function add($syllabus_data) {
		try {
			if (!$syllabus_data['school_id'] || !$syllabus_data['term_id'] || !$syllabus_data['classroom_id'] || !$syllabus_data['classroom_subject_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $syllabus_data['school_id']));
			$school = $school_obj[0];
			$term_obj = $this->doctrine->em->getRepository('Entities\Term')->findBy(array('id' => $syllabus_data['term_id']));
			$term = $term_obj[0];
			$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $syllabus_data['classroom_id']));
			$classroom = $classroom_obj[0];
			$classroom_subject_obj = $this->doctrine->em->getRepository('Entities\ClassroomSubject')->findBy(array('id' => $syllabus_data['classroom_subject_id']));
			$classroom_subject = $classroom_subject_obj[0];

			$new_syllabus = new Entities\Syllabus;
			$new_syllabus->setData($syllabus_data);
			$new_syllabus->school = $school;
			$new_syllabus->term = $term;
			$new_syllabus->classroom = $classroom;
			$new_syllabus->classroom_subject = $classroom_subject;

			$this->doctrine->em->persist($new_syllabus);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('syllabus - add - ' . json_encode($new_syllabus->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_syllabus->__get('id');
	}

	public function update($syllabus_id, $syllabus_data){
		try {
			$syllabus = $this->doctrine->em->find('Entities\Syllabus', $syllabus_id);
			$old_obj = $syllabus->getData();
			$syllabus->setData($syllabus_data);

			if ($syllabus_data['term_id']) {
				$term_obj = $this->doctrine->em->getRepository('Entities\Term')->findBy(array('id' => $syllabus_data['term_id']));
				$term = $term_obj[0];
				$syllabus->term = $term;
			}
			if ($syllabus_data['classroom_id']) {
				$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $syllabus_data['classroom_id']));
				$classroom = $classroom_obj[0];
				$syllabus->classroom = $classroom;
			}
			if ($syllabus_data['classroom_subject_id']) {
				$classroom_subject_obj = $this->doctrine->em->getRepository('Entities\ClassroomSubject')->findBy(array('id' => $syllabus_data['classroom_subject_id']));
				$classroom_subject = $classroom_subject_obj[0];
				$syllabus->classroom_subject = $classroom_subject;
			}
			$this->doctrine->em->persist($syllabus);
			$new_obj = $syllabus->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('syllabus - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
