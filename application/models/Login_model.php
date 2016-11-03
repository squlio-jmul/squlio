<?php

require_once(APPPATH."models/Entities/Login.php");

class Login_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$login_obj = $this->doctrine->em->getRepository('Entities\Login')->findBy($filters, $order_by, $limit, $offset);

		$logins = array();
		foreach($login_obj as $index => $l){
			$login = $l->getData();

			if($fields){
				$temp_login = array();
				$temp_login['id'] = $login['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $login)){
						$temp_login[$field] = $login[$field];
					}
				}
				$login = $temp_login;
			}

			if(!isset($modules['all'])) $modules['all'] = false;

			$logins[] = $login;
		}
		$this->doctrine->em->clear();
		return $logins;
	}

	public function add($login_data) {
		try {
			$new_login = new Entities\Login;
			$new_login->setData($login_data);
			$new_login->created_on = new \Datetime('now');

			$this->doctrine->em->persist($new_login);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('login - add - ' . json_encode($new_login->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_login->__get('id');
	}

	public function update($login_id, $login_data){
		try {
			$login = $this->doctrine->em->find('Entities\Login', $login_id);
			$old_obj = $login->getData();
			$login->setData($login_data);
			$this->doctrine->em->persist($login);
			$new_obj = $login->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$old_obj['password'] = 'XXX';
			$new_obj['password'] = ($old_obj['password'] != $new_obj['password']) ? 'YYY' : 'XXX';

			$this->logMessage('login - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
