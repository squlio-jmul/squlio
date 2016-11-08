<?php

require_once(APPPATH."models/Entities/AccountType.php");

class Account_type_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$account_type_obj = $this->doctrine->em->getRepository('Entities\AccountType')->findBy($filters, $order_by, $limit, $offset);

		$account_types = array();
		foreach($account_type_obj as $index => $obj){
			$account_type = $obj->getData();

			if($fields){
				$temp_account_type = array();
				$temp_account_type['id'] = $account_type['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $account_type)){
						$temp_account_type[$field] = $account_type[$field];
					}
				}
				$account_type = $temp_account_type;
			}

			if(!isset($modules['all'])) $modules['all'] = false;

			$account_types[] = $account_type;
		}
		$this->doctrine->em->clear();
		return $account_types;
	}

	public function add($account_type_data) {
		try {
			$new_account_type = new Entities\AccountType;
			$new_account_type->setData($account_type_data);

			$this->doctrine->em->persist($new_account_type);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('account_type - add - ' . json_encode($new_account_type->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_account_type->__get('id');
	}

	public function update($account_type_id, $account_type_data){
		try {
			$account_type = $this->doctrine->em->find('Entities\AccountType', $account_type_id);
			$old_obj = $account_type->getData();
			$account_type->setData($account_type_data);
			$this->doctrine->em->persist($account_type);
			$new_obj = $account_type->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('account_type - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
