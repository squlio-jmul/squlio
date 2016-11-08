<?php

require_once(APPPATH."models/Entities/SchoolAdmin.php");
require_once(APPPATH."models/Entities/Login.php");
require_once(APPPATH."models/Entities/School.php");

class School_admin_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$school_admin_obj = $this->doctrine->em->getRepository('Entities\SchoolAdmin')->findBy($filters, $order_by, $limit, $offset);

		$school_admins = array();
		foreach($school_admin_obj as $index => $obj){
			$school_admin = $obj->getData();

			if($fields){
				$temp_school_admin = array();
				$temp_school_admin['id'] = $school_admin['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $school_admin)){
						$temp_school_admin[$field] = $school_admin[$field];
					}
				}
				$school_admin = $temp_school_admin;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['login']) && $modules['login']) || $modules['all']) $school_admin['login'] = $obj->getFormattedObject('login');
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $school_admin['school'] = $obj->getFormattedObject('school');

			$school_admins[] = $school_admin;
		}
		$this->doctrine->em->clear();
		return $school_admins;
	}

	public function add($school_admin_data) {
		try {
			if (!$school_admin_data['login_id'] || !$school_admin_data['school_id']) {
				return false;
			}
			$login_obj = $this->doctrine->em->getRepository('Entities\Login')->findBy(array('id' => $school_admin_data['login_id']));
			$login = $login_obj[0];
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $school_admin_data['school_id']));
			$school = $school_obj[0];

			$new_school_admin = new Entities\SchoolAdmin;
			$new_school_admin->setData($school_admin_data);
			$new_school_admin->login = $login;
			$new_school_admin->school = $school;

			$this->doctrine->em->persist($new_school_admin);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('school_admin - add - ' . json_encode($new_school_admin->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_school_admin->__get('id');
	}

	public function update($school_admin_id, $school_admin_data){
		try {
			$school_admin = $this->doctrine->em->find('Entities\SchoolAdmin', $school_admin_id);
			$old_obj = $school_admin->getData();
			$school_admin->setData($school_admin_data);
			$this->doctrine->em->persist($school_admin);
			$new_obj = $school_admin->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('school_admin - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
