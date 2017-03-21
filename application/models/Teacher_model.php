<?php

require_once(APPPATH."models/Entities/Teacher.php");
require_once(APPPATH."models/Entities/Login.php");
require_once(APPPATH."models/Entities/School.php");

class Teacher_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$teacher_obj = $this->doctrine->em->getRepository('Entities\Teacher')->findBy($filters, $order_by, $limit, $offset);

		$teachers = array();
		foreach($teacher_obj as $index => $obj){
			$teacher = $obj->getData();

			if($fields){
				$temp_teacher = array();
				$temp_teacher['id'] = $teacher['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $teacher)){
						$temp_teacher[$field] = $teacher[$field];
					}
				}
				$teacher = $temp_teacher;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['login']) && $modules['login']) || $modules['all']) $teacher['login'] = $obj->getFormattedObject('login');
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $teacher['school'] = $obj->getFormattedObject('school');

			$teachers[] = $teacher;
		}
		$this->doctrine->em->clear();
		return $teachers;
	}

	public function add($teacher_data) {
		try {
			if (!$teacher_data['login_id'] || !$teacher_data['school_id']) {
				return false;
			}
			$login_obj = $this->doctrine->em->getRepository('Entities\Login')->findBy(array('id' => $teacher_data['login_id']));
			$login = $login_obj[0];
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $teacher_data['school_id']));
			$school = $school_obj[0];

			$new_teacher = new Entities\Teacher;
			$new_teacher->setData($teacher_data);
			$new_teacher->login = $login;
			$new_teacher->school = $school;

			$this->doctrine->em->persist($new_teacher);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('teacher - add - ' . json_encode($new_teacher->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_teacher->__get('id');
	}

	public function update($teacher_id, $teacher_data){
		try {
			$teacher = $this->doctrine->em->find('Entities\Teacher', $teacher_id);
			$old_obj = $teacher->getData();
			$teacher->setData($teacher_data);
			$this->doctrine->em->persist($teacher);
			$new_obj = $teacher->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('teacher - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}

	public function getActiveCountBySchoolId($school_id) {
		$params = array('school_id' => $school_id, 'active'=>true, 'deleted'=>false);
		$query = $this->doctrine->em->createQuery('SELECT COUNT(t.id) AS num_teacher FROM Entities\Teacher t JOIN t.school s JOIN t.login l WHERE s.id = :school_id AND l.active = :active AND l.deleted =:deleted')->setParameters($params);
		$result = $query->getSingleResult();
		if ($result['num_teacher']) {
			return (int) $result['num_teacher'];
		}
		return 0;
	}

}
