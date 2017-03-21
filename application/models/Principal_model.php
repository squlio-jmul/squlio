<?php

require_once(APPPATH."models/Entities/Principal.php");
require_once(APPPATH."models/Entities/Login.php");
require_once(APPPATH."models/Entities/School.php");

class Principal_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$principal_obj = $this->doctrine->em->getRepository('Entities\Principal')->findBy($filters, $order_by, $limit, $offset);
		$principals = array();
		foreach($principal_obj as $index => $obj){
			$principal = $obj->getData();

			if($fields){
				$temp_principal = array();
				$temp_principal['id'] = $principal['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $principal)){
						$temp_principal[$field] = $principal[$field];
					}
				}
				$principal = $temp_principal;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['login']) && $modules['login']) || $modules['all']) $principal['login'] = $obj->getFormattedObject('login');
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $principal['school'] = $obj->getFormattedObject('school');

			$principals[] = $principal;
		}
		$this->doctrine->em->clear();
		return $principals;
	}

	public function add($principal_data) {
		try {
			if (!$principal_data['login_id'] || !$principal_data['school_id']) {
				return false;
			}
			$login_obj = $this->doctrine->em->getRepository('Entities\Login')->findBy(array('id' => $principal_data['login_id']));
			$login = $login_obj[0];
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $principal_data['school_id']));
			$school = $school_obj[0];

			$new_principal = new Entities\Principal;
			$new_principal->setData($principal_data);
			$new_principal->login = $login;
			$new_principal->school = $school;

			$this->doctrine->em->persist($new_principal);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('principal - add - ' . json_encode($new_principal->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_principal->__get('id');
	}

	public function update($principal_id, $principal_data){
		try {
			$principal = $this->doctrine->em->find('Entities\Principal', $principal_id);
			$old_obj = $principal->getData();
			$principal->setData($principal_data);
			$this->doctrine->em->persist($principal);
			$new_obj = $principal->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('principal - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}

	public function getActiveCountBySchoolId($school_id) {
		$params = array('school_id' => $school_id, 'active'=>true, 'deleted'=>false);
		$query = $this->doctrine->em->createQuery('SELECT COUNT(p.id) AS num_principal FROM Entities\Principal p JOIN p.school s JOIN p.login l WHERE s.id = :school_id AND l.active = :active AND l.deleted =:deleted')->setParameters($params);
		$result = $query->getSingleResult();
		if ($result['num_principal']) {
			return (int) $result['num_principal'];
		}
		return 0;
	}
}
