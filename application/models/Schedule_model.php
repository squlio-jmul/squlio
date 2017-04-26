<?php

require_once(APPPATH."models/Entities/Schedule.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Term.php");
require_once(APPPATH."models/Entities/Classroom.php");
require_once(APPPATH."models/Entities/Subject.php");

class Schedule_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$schedule_obj = $this->doctrine->em->getRepository('Entities\Schedule')->findBy($filters, $order_by, $limit, $offset);

		$schedules = array();
		foreach($schedule_obj as $index => $obj){
			$schedule = $obj->getData();

			if($fields){
				$temp_schedule = array();
				$temp_schedule['id'] = $schedule['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $schedule)){
						$temp_schedule[$field] = $schedule[$field];
					}
				}
				$schedule = $temp_schedule;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $schedule['school'] = $obj->getFormattedObject('school');
			if((isset($modules['term']) && $modules['term']) || $modules['all']) $schedule['term'] = $obj->getFormattedObject('term');
			if((isset($modules['classroom']) && $modules['classroom']) || $modules['all']) $schedule['classroom'] = $obj->getFormattedObject('classroom');
			if((isset($modules['subject']) && $modules['subject']) || $modules['all']) $schedule['subject'] = $obj->getFormattedObject('subject');

			$schedules[] = $schedule;
		}
		$this->doctrine->em->clear();
		return $schedules;
	}

	public function add($schedule_data) {
		try {
			if (!$schedule_data['school_id'] || !$schedule_data['term_id'] || !$schedule_data['classroom_id'] || !$schedule_data['subject_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $schedule_data['school_id']));
			$school = $school_obj[0];
			$term_obj = $this->doctrine->em->getRepository('Entities\Term')->findBy(array('id' => $schedule_data['term_id']));
			$term = $term_obj[0];
			$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $schedule_data['classroom_id']));
			$classroom = $classroom_obj[0];
			$subject_obj = $this->doctrine->em->getRepository('Entities\Subject')->findBy(array('id' => $schedule_data['subject_id']));
			$subject = $subject_obj[0];

			$new_schedule = new Entities\Schedule;
			$new_schedule->setData($schedule_data);
			$new_schedule->school = $school;
			$new_schedule->term = $term;
			$new_schedule->classroom = $classroom;
			$new_schedule->subject = $subject;

			$this->doctrine->em->persist($new_schedule);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('schedule - add - ' . json_encode($new_schedule->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_schedule->__get('id');
	}

	public function update($schedule_id, $schedule_data){
		try {
			$schedule = $this->doctrine->em->find('Entities\Schedule', $schedule_id);
			$old_obj = $schedule->getData();
			$schedule->setData($schedule_data);

			if ($schedule_data['term_id']) {
				$term_obj = $this->doctrine->em->getRepository('Entities\Term')->findBy(array('id' => $schedule_data['term_id']));
				$term = $term_obj[0];
				$schedule->term = $term;
			}
			if ($schedule_data['classroom_id']) {
				$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $schedule_data['classroom_id']));
				$classroom = $classroom_obj[0];
				$schedule->classroom = $classroom;
			}
			if ($schedule_data['subject_id']) {
				$subject_obj = $this->doctrine->em->getRepository('Entities\Subject')->findBy(array('id' => $schedule_data['subject_id']));
				$subject = $subject_obj[0];
				$schedule->subject = $subject;
			}

			$this->doctrine->em->persist($schedule);
			$new_obj = $schedule->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('schedule - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
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
			$delete_schedule_arr = $this->doctrine->em->getRepository('Entities\Schedule')->findBy($filters);
			foreach($delete_schedule_arr as $index => $schedule){
				$this->doctrine->em->remove($schedule);
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
