<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Announcement library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Announcement_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Announcement_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Announcement_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($announcement_data){
		try{
			$default_announcement_data = array(
				'start_date' => new \DateTime($announcement_data['start_date']),
				'end_date' => new \DateTime($announcement_data['end_date']),
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			$announcement_data = array_merge($announcement_data, $default_announcement_data);
			if ($announcement_id = $this->_ci->Announcement_model->add($announcement_data)) {
				return $announcement_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($announcement_id, $announcement_data) {
		try {
			if (isset($announcement_data['start_date'])) {
				$announcement_data['start_date'] = new \DateTime($announcement_data['start_date']);
			}
			if (isset($announcement_data['end_date'])) {
				$announcement_data['end_date'] = new \DateTime($announcement_data['end_date']);
			}

			if ($announcement = $this->_ci->Announcement_model->update($announcement_id, $announcement_data)) {
				return $announcement;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function delete($filters) {
		try {
			return $this->_ci->Announcement_model->delete($filters);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

}
