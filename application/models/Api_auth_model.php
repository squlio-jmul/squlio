<?php

require_once(APPPATH."models/Entities/ApiAuth.php");

class Api_auth_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$api_auth_obj = $this->doctrine->em->getRepository('Entities\ApiAuth')->findBy($filters, $order_by, $limit, $offset);

		$api_auths = array();
		foreach($api_auth_obj as $index => $obj){
			$api_auth = $obj->getData();

			if($fields){
				$temp_api_auth = array();
				$temp_api_auth['id'] = $api_auth['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $api_auth)){
						$temp_api_auth[$field] = $api_auth[$field];
					}
				}
				$api_auth = $temp_api_auth;
			}

			if(!isset($modules['all'])) $modules['all'] = false;

			$api_auths[] = $api_auth;
		}
		$this->doctrine->em->clear();
		return $api_auths;
	}

	public function add($api_auth_data) {
		try {
			$new_api_auth = new Entities\ApiAuth;
			$new_api_auth->setData($api_auth_data);

			$this->doctrine->em->persist($new_api_auth);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('api_auth - add - ' . json_encode($new_api_auth->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_api_auth->__get('id');
	}

	public function update($api_auth_id, $api_auth_data){
		try {
			$api_auth = $this->doctrine->em->find('Entities\ApiAuth', $api_auth_id);
			$old_obj = $api_auth->getData();
			$api_auth->setData($api_auth_data);
			$this->doctrine->em->persist($api_auth);
			$new_obj = $api_auth->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$old_obj['password'] = 'XXX';
			$new_obj['password'] = ($old_obj['password'] != $new_obj['password']) ? 'YYY' : 'XXX';

			$this->logMessage('api_auth - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
