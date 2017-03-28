<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Material library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Material_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Material_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			$modules['all'] = (isset($modules['all']) && filter_var($modules['all'], FILTER_VALIDATE_BOOLEAN)) ? true : false;

			if($materials = $this->_ci->Material_model->get($filters, $fields, $order_by, $limit, $offset, $modules)){
				return $materials;
			}else{
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($material_data){
		try{
			if ($material_id = $this->_ci->Material_model->add($material_data)) {
				return $material_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
