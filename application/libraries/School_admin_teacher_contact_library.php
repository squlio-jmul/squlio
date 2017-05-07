<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * School_admin_teacher_contact library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class School_admin_teacher_contact_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('School_admin_teacher_contact_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->School_admin_teacher_contact_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($school_admin_teacher_contact_data){
		try{
			$default_school_admin_teacher_contact_data = array(
				'message_read' => 0,
				'created_on' => new \DateTime('now')
			);

			$school_admin_teacher_contact_data = array_merge($school_admin_teacher_contact_data, $default_school_admin_teacher_contact_data);

			if ($school_admin_teacher_contact_id = $this->_ci->School_admin_teacher_contact_model->add($school_admin_teacher_contact_data)) {
				return $school_admin_teacher_contact_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($school_admin_teacher_contact_id, $school_admin_teacher_contact_data) {
		try {
			if ($school_admin_teacher_contact = $this->_ci->School_admin_teacher_contact_model->update($school_admin_teacher_contact_id, $school_admin_teacher_contact_data)) {
				return $school_admin_teacher_contact;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}
}
