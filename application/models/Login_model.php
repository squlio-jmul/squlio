<?php

require_once(APPPATH."models/Entities/Login.php");

class Login_model extends CI_Model {

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
}
