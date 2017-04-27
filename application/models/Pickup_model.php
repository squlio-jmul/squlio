<?php

require_once(APPPATH."models/Entities/Pickup.php");
require_once(APPPATH."models/Entities/Student.php");

class Pickup_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$pickup_obj = $this->doctrine->em->getRepository('Entities\Pickup')->findBy($filters, $order_by, $limit, $offset);

		$pickups = array();
		foreach($pickup_obj as $index => $obj){
			$pickup = $obj->getData();

			if($fields){
				$temp_pickup = array();
				$temp_pickup['id'] = $pickup['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $pickup)){
						$temp_pickup[$field] = $pickup[$field];
					}
				}
				$pickup = $temp_pickup;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['student']) && $modules['student']) || $modules['all']) $pickup['student'] = $obj->getFormattedObject('student');

			$pickups[] = $pickup;
		}
		$this->doctrine->em->clear();
		return $pickups;
	}

	public function add($pickup_data) {
		try {
			if (!$pickup_data['student_id']) {
				return false;
			}
			$student_obj = $this->doctrine->em->getRepository('Entities\Student')->findBy(array('id' => $pickup_data['student_id']));
			$student = $student_obj[0];

			$new_pickup = new Entities\Pickup;
			$new_pickup->setData($pickup_data);
			$new_pickup->student = $student;

			$this->doctrine->em->persist($new_pickup);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('pickup - add - ' . json_encode($new_pickup->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_pickup->__get('id');
	}

	public function update($pickup_id, $pickup_data){
		try {
			$pickup = $this->doctrine->em->find('Entities\Pickup', $pickup_id);
			$old_obj = $pickup->getData();
			$pickup->setData($pickup_data);
			$this->doctrine->em->persist($pickup);
			$new_obj = $pickup->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('pickup - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
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
			$delete_pickup_arr = $this->doctrine->em->getRepository('Entities\Pickup')->findBy($filters);
			foreach($delete_pickup_arr as $index => $pickup){
				$this->doctrine->em->remove($pickup);
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
