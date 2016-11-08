<?php

require_once(APPPATH."models/Entities/Material.php");
require_once(APPPATH."models/Entities/School.php");
require_once(APPPATH."models/Entities/ClassroomSubject.php");

class Material_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$material_obj = $this->doctrine->em->getRepository('Entities\Material')->findBy($filters, $order_by, $limit, $offset);

		$materials = array();
		foreach($material_obj as $index => $obj){
			$material = $obj->getData();

			if($fields){
				$temp_material = array();
				$temp_material['id'] = $material['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $material)){
						$temp_material[$field] = $material[$field];
					}
				}
				$material = $temp_material;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['school']) && $modules['school']) || $modules['all']) $material['school'] = $obj->getFormattedObject('school');
			if((isset($modules['classroom_subject']) && $modules['classroom_subject']) || $modules['all']) $material['classroom_subject'] = $obj->getFormattedObject('classroom_subject');

			$materials[] = $material;
		}
		$this->doctrine->em->clear();
		return $materials;
	}

	public function add($material_data) {
		try {
			if (!$material_data['school_id'] || !$material_data['classroom_subject_id']) {
				return false;
			}
			$school_obj = $this->doctrine->em->getRepository('Entities\School')->findBy(array('id' => $material_data['school_id']));
			$school = $school_obj[0];
			$classroom_subject_obj = $this->doctrine->em->getRepository('Entities\ClassroomSubject')->findBy(array('id' => $material_data['classroom_subject_id']));
			$classroom_subject = $classroom_subject_obj[0];

			$new_material = new Entities\Material;
			$new_material->setData($material_data);
			$new_material->school = $school;
			$new_material->classroom_subject = $classroom_subject;

			$this->doctrine->em->persist($new_material);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('material - add - ' . json_encode($new_material->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_material->__get('id');
	}

	public function update($material_id, $material_data){
		try {
			$material = $this->doctrine->em->find('Entities\Material', $material_id);
			$old_obj = $material->getData();
			$material->setData($material_data);

			if ($material_data['classroom_subject_id']) {
				$classroom_subject_obj = $this->doctrine->em->getRepository('Entities\ClassroomSubject')->findBy(array('id' => $material_data['classroom_subject_id']));
				$classroom_subject = $classroom_subject_obj[0];
				$material->classroom_subject = $classroom_subject;
			}
			$this->doctrine->em->persist($material);
			$new_obj = $material->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('material - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
