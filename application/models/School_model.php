<?php

require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/AccountType.php");

class School_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy($filters, $order_by, $limit, $offset);

		$schools = array();
		foreach($school_obj as $index => $obj){
			$school = $obj->getData();

			if($fields){
				$temp_school = array();
				$temp_school['id'] = $school['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $school)){
						$temp_school[$field] = $school[$field];
					}
				}
				$school = $temp_school;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['account_type']) && $modules['account_type']) || $modules['all']) $school['account_type'] = $obj->getFormattedObject('account_type');

			$schools[] = $school;
		}
		$this->doctrine->em->clear();
		return $schools;
	}

	public function add($school_data) {
		try {
			if (!$school_data['account_type_id']) {
				return false;
			}
			$account_type_obj = $this->doctrine->em->getRepository('Entities\AccountType')->findBy(array('id' => $school_data['account_type_id']));
			$account_type = $account_type_obj[0];

			$new_school = new Entities\School;
			$new_school->setData($school_data);
			$new_school->account_type = $account_type;

			$this->doctrine->em->persist($new_school);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('school - add - ' . json_encode($new_school->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_school->__get('id');
	}

	public function update($school_id, $school_data){
		try {
			$school = $this->doctrine->em->find('Entities\School', $school_id);
			$account_type = null;
			if (isset($school_data['account_type_id'])) {
				$account_type = $this->doctrine->em->find('Entities\AccountType', $school_data['account_type_id']);
			}
			$old_obj = $school->getData();
			$school->setData($school_data);
			if ($account_type) {
				$school->account_type = $account_type;
			}
			$this->doctrine->em->persist($school);
			$new_obj = $school->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('school - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
