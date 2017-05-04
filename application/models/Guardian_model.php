<?php

require_once(APPPATH."models/Entities/Guardian.php");
require_once(APPPATH."models/Entities/Login.php");
require_once(APPPATH."models/Entities/School.php");

class Guardian_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$guardian_obj = $this->doctrine->em->getRepository('Entities\Guardian')->findBy($filters, $order_by, $limit, $offset);

		$guardians = array();
		foreach($guardian_obj as $index => $obj){
			$guardian = $obj->getData();

			if($fields){
				$temp_guardian = array();
				$temp_guardian['id'] = $guardian['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $guardian)){
						$temp_guardian[$field] = $guardian[$field];
					}
				}
				$guardian = $temp_guardian;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['login']) && $modules['login']) || $modules['all']) $guardian['login'] = $obj->getFormattedObject('login');
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $guardian['school'] = $obj->getFormattedObject('school');

			$guardians[] = $guardian;
		}
		$this->doctrine->em->clear();
		return $guardians;
	}

	public function add($guardian_data) {
		try {
			if (!$guardian_data['login_id'] || !$guardian_data['school_id']) {
				return false;
			}
			$login_obj = $this->doctrine->em->getRepository('Entities\Login')->findBy(array('id' => $guardian_data['login_id']));
			$login = $login_obj[0];
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $guardian_data['school_id']));
			$school = $school_obj[0];

			$new_guardian = new Entities\Guardian;
			$new_guardian->setData($guardian_data);
			$new_guardian->login = $login;
			$new_guardian->school = $school;

			$this->doctrine->em->persist($new_guardian);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('guardian - add - ' . json_encode($new_guardian->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_guardian->__get('id');
	}

	public function update($guardian_id, $guardian_data){
		try {
			$guardian = $this->doctrine->em->find('Entities\Guardian', $guardian_id);
			$old_obj = $guardian->getData();
			$guardian->setData($guardian_data);
			$this->doctrine->em->persist($guardian);
			$new_obj = $guardian->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('guardian - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
