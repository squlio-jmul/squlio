<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Schedule library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

class Schedule_library extends SQ_Library {

	public function __construct()
	{
		parent::__construct();
		$this->_ci->load->model('Schedule_model');
	}

	public function get($filters = array(), $fields = array(), $order_by = array(), $limit = null, $offset = null, $modules = array()) {
		try {
			return $this->_ci->Schedule_model->get($filters, $fields, $order_by, $limit, $offset, $modules);
		} catch(Exception $err) {
			die($err->getMessage());
		}

	}

	public function add($schedule_data){
		try{
			$default_schedule_data = array(
				'date' => new \DateTime($schedule_data['date']),
				'created_on' => new \DateTime('now'),
				'last_updated' => new \DateTime('now')
			);
			$schedule_data = array_merge($schedule_data, $default_schedule_data);
			if ($schedule_id = $this->_ci->Schedule_model->add($schedule_data)) {
				return $schedule_id;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function update($schedule_id, $schedule_data) {
		try {
			if (isset($schedule_data['date'])) {
				$schedule_data['date'] = new \DateTime($schedule_data['date']);
			}
			if ($schedule = $this->_ci->Schedule_model->update($schedule_id, $schedule_data)) {
				return $schedule;
			}
			return false;
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function delete($filters) {
		try {
			return $this->_ci->Schedule_model->delete($filters);
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

}
