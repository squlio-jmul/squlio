<?php

require_once(APPPATH."models/Entities/SyllabusMaterial.php");
require_once(APPPATH."models/Entities/Syllabus.php");
require_once(APPPATH."models/Entities/Material.php");

class syllabus_material_model extends SQ_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()){
		$order_by = ($order_by) ? $order_by : null;
		$syllabus_material_obj = $this->doctrine->em->getRepository('Entities\SyllabusMaterial')->findBy($filters, $order_by, $limit, $offset);

		$syllabus_materials = array();
		foreach($syllabus_material_obj as $index => $obj){
			$syllabus_material = $obj->getData();

			if($fields){
				$temp_syllabus_material = array();
				$temp_syllabus_material['id'] = $syllabus_material['id'];
				foreach($fields as $field){
					if(array_key_exists($field, $syllabus_material)){
						$temp_syllabus_material[$field] = $syllabus_material[$field];
					}
				}
				$syllabus_material = $temp_syllabus_material;
			}

			if(!isset($modules['all'])) $modules['all'] = false;
			if((isset($modules['syllabus']) && $modules['syllabus']) || $modules['all']) $syllabus_material['syllabus'] = $obj->getFormattedObject('syllabus');
			if((isset($modules['material']) && $modules['material']) || $modules['all']) $syllabus_material['material'] = $obj->getFormattedObject('material');

			$syllabus_materials[] = $syllabus_material;
		}
		$this->doctrine->em->clear();
		return $syllabus_materials;
	}

	public function add($syllabus_material_data) {
		try {
			if (!$syllabus_material_data['classroom_id'] || !$syllabus_material_data['teacher_id'] || !$syllabus_material_data['classroom_subject_id']) {
				return false;
			}
			$syllabus_obj = $this->doctrine->em->getRepository('Entities\Syllabus')->findBy(array('id' => $syllabus_material_data['syllabus_id']));
			$syllabus = $syllabus_obj[0];
			$material_obj = $this->doctrine->em->getRepository('Entities\Material')->findBy(array('id' => $syllabus_material_data['material_id']));
			$material = $material_obj[0];

			$new_syllabus_material = new Entities\SyllabusMaterial;
			$new_syllabus_material->setData($syllabus_material_data);
			$new_syllabus_material->syllabus = $syllabus;
			$new_syllabus_material->material = $material;

			$this->doctrine->em->persist($new_syllabus_material);
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('syllabus_material - add - ' . json_encode($new_syllabus_material->getData()));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return $new_syllabus_material->__get('id');
	}

	public function update($syllabus_material_id, $syllabus_material_data){
		try {
			$syllabus_material = $this->doctrine->em->find('Entities\SyllabusMaterial', $syllabus_material_id);
			$old_obj = $syllabus_material->getData();
			$syllabus_material->setData($syllabus_material_data);
			$this->doctrine->em->persist($syllabus_material);
			$new_obj = $syllabus_material->getData();
			$this->doctrine->em->flush();
			$this->doctrine->em->clear();

			$this->logMessage('syllabus_material - update - ' . json_encode($new_obj) . ' - ' . json_encode($old_obj));
		}catch(Exception $err){
			//return false;
			die($err->getMessage());
		}
		return true;
	}
}
