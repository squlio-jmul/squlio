<?php

require_once(APPPATH."models/Entities/SchoolAdminTeacherContact.php");
require_once(APPPATH."models/Entities/SchoolAdmin.php");
require_once(APPPATH."models/Entities/Teacher.php");

class School_admin_teacher_contact_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$school_admin_teacher_contact_obj = $this->doctrine->em->getRepository('Entities\SchoolAdminTeacherContact')->findBy($filters, $order_by, $limit, $offset);

		$school_admin_teacher_contacts = array();
		foreach($school_admin_teacher_contact_obj as $index => $obj){
			$school_admin_teacher_contact = $obj->getData();

			if($fields){
				$temp_school_admin_teacher_contact = array();
				$temp_school_admin_teacher_contact['id'] = $school_admin_teacher_contact['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $school_admin_teacher_contact)){
						$temp_school_admin_teacher_contact[$field] = $school_admin_teacher_contact[$field];
					}
				}
				$school_admin_teacher_contact = $temp_school_admin_teacher_contact;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school_admin']) && $modules['school_admin']) || $modules['all']) $school_admin_teacher_contact['school_admin'] = $obj->getFormattedObject('school_admin');
			if((isset($modules['teacher']) && $modules['teacher']) || $modules['all']) $school_admin_teacher_contact['teacher'] = $obj->getFormattedObject('teacher');

			$school_admin_teacher_contacts[] = $school_admin_teacher_contact;
		}
		$this->doctrine->em->clear();
		return $school_admin_teacher_contacts;
	}

	public function add($school_admin_teacher_contact_data) {
		try {
			if (!$school_admin_teacher_contact_data['school_admin_id'] || !$school_admin_teacher_contact_data['teacher_id']) {
				return false;
			}
			$school_admin_obj = $this->doctrine->em->getRepository('Entities\SchoolAdmin')->findBy(array('id' => $school_admin_teacher_contact_data['school_admin_id']));
			$school_admin = $school_admin_obj[0];
			$teacher_obj = $this->doctrine->em->getRepository('Entities\Teacher')->findBy(array('id' => $school_admin_teacher_contact_data['teacher_id']));
			$teacher = $teacher_obj[0];

			$new_school_admin_teacher_contact = new Entities\SchoolAdminTeacherContact;
			$new_school_admin_teacher_contact->setData($school_admin_teacher_contact_data);
			$new_school_admin_teacher_contact->school_admin = $school_admin;
			$new_school_admin_teacher_contact->teacher = $teacher;

			$this->doctrine->em->persist($new_school_admin_teacher_contact);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('school_admin_teacher_contact - add - ' . json_encode($new_school_admin_teacher_contact->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_school_admin_teacher_contact->__get('id');
	}

	public function update($school_admin_teacher_contact_id, $school_admin_teacher_contact_data){
		try {
			$school_admin_teacher_contact = $this->doctrine->em->find('Entities\SchoolAdminTeacherContact', $school_admin_teacher_contact_id);
			$old_obj = $school_admin_teacher_contact->getData();
			$school_admin_teacher_contact->setData($school_admin_teacher_contact_data);
			$this->doctrine->em->persist($school_admin_teacher_contact);
			$new_obj = $school_admin_teacher_contact->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('school_admin_teacher_contact - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
