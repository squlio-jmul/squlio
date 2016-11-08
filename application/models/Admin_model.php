<?php

require_once(APPPATH."models/Entities/Admin.php");
require_once(APPPATH."models/Entities/Login.php");

class Admin_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$admin_obj = $this->doctrine->em->getRepository('Entities\Admin')->findBy($filters, $order_by, $limit, $offset);

		$admins = array();
		foreach($admin_obj as $index => $obj){
			$admin = $obj->getData();

			if($fields){
				$temp_admin = array();
				$temp_admin['id'] = $admin['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $admin)){
						$temp_admin[$field] = $admin[$field];
					}
				}
				$admin = $temp_admin;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['login']) && $modules['login']) || $modules['all']) $admin['login'] = $obj->getFormattedObject('login');

			$admins[] = $admin;
		}
		$this->doctrine->em->clear();
		return $admins;
	}

	public function add($admin_data) {
		try {
			if (!$admin_data['login_id']) {
				return false;
			}
			$login_obj = $this->doctrine->em->getRepository('Entities\Login')->findBy(array('id' => $admin_data['login_id']));
			$login = $login_obj[0];

			$new_admin = new Entities\Admin;
			$new_admin->setData($admin_data);
			$new_admin->login = $login;

			$this->doctrine->em->persist($new_admin);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('admin - add - ' . json_encode($new_admin->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_admin->__get('id');
	}

	public function update($admin_id, $admin_data){
		try {
			$admin = $this->doctrine->em->find('Entities\Admin', $admin_id);
			$old_obj = $admin->getData();
			$admin->setData($admin_data);
			$this->doctrine->em->persist($admin);
			$new_obj = $admin->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('admin - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
