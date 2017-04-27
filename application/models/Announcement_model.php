<?php

require_once(APPPATH."models/Entities/Announcement.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/Classroom.php");

class Announcement_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$announcement_obj = $this->doctrine->em->getRepository('Entities\Announcement')->findBy($filters, $order_by, $limit, $offset);

		$announcements = array();
		foreach($announcement_obj as $index => $obj){
			$announcement = $obj->getData();

			if($fields){
				$temp_announcement = array();
				$temp_announcement['id'] = $announcement['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $announcement)){
						$temp_announcement[$field] = $announcement[$field];
					}
				}
				$announcement = $temp_announcement;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $announcement['school'] = $obj->getFormattedObject('school');
			if((isset($modules['classroom']) && $modules['classroom']) || $modules['all']) $announcement['classroom'] = $obj->getFormattedObject('classroom');

			$announcements[] = $announcement;
		}
		$this->doctrine->em->clear();
		return $announcements;
	}

	public function add($announcement_data) {
		try {
			if (!$announcement_data['school_id'] || !$announcement_data['classroom_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $announcement_data['school_id']));
			$school = $school_obj[0];
			$classroom_obj = $this->doctrine->em->getRepository('Entities\Classroom')->findBy(array('id' => $announcement_data['classroom_id']));
			$classroom = $classroom_obj[0];

			$new_announcement = new Entities\Announcement;
			$new_announcement->setData($announcement_data);
			$new_announcement->school = $school;
			$new_announcement->classroom = $classroom;

			$this->doctrine->em->persist($new_announcement);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('announcement - add - ' . json_encode($new_announcement->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_announcement->__get('id');
	}

	public function update($announcement_id, $announcement_data){
		try {
			$announcement = $this->doctrine->em->find('Entities\Announcement', $announcement_id);
			$old_obj = $announcement->getData();
			$announcement->setData($announcement_data);
			$this->doctrine->em->persist($announcement);
			$new_obj = $announcement->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('announcement - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
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
			$delete_announcement_arr = $this->doctrine->em->getRepository('Entities\Announcement')->findBy($filters);
			foreach($delete_announcement_arr as $index => $announcement){
				$this->doctrine->em->remove($announcement);
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
