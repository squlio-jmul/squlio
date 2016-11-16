<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SQ_Controller extends CI_Controller {
	public $input_data;
	public $start_time;

	public function __construct() {
		parent::__construct();
		$this->load->library('Oauth_Library');
		$this->load->model('Api_auth_model');

		$this->start_time = microtime(true);
		if ($data = json_decode(file_get_contents('php://input'), true)) {
			$this->input_data = $data;
		} else {
			$this->input_data = $_REQUEST;
			if ($_FILES) {
				$this->input_data = array_merge($this->input_data, $_FILES);
			}
		}

		if (!isset($this->input_data['limit']) || !$this->input_data['limit'] || intVal($this->input_data['limit']) > 25) {
			$this->input_data['limit'] = 25;
		}
	}

	public function apiAuthorized() {
		if (!isset($this->input_data['api_token']) || !isset($this->input_data['api_password'])) {
			return false;
		} else {
			$auth_obj = $this->Api_auth_model->get(array('token' => $this->input_data['api_token'], 'password' => $this->input_data['api_password']));
			if (!$auth_obj) {
				return false;
			} else {
				return true;
			}
		}
	}

	public function teacherAuthenticated() {
		if (!isset($this->input_data['oauth_token']) || !isset($this->input_data['uid'])) {
			return false;
		} else {
			return $this->Oauth_Library->teacherAuthenticated($this->input_data['uid'], $this->input_data['oauth_token']);
		}
	}

	public function guardianAuthenticated() {
		if (!isset($this->input_data['oauth_token']) || !isset($this->input_data['uid'])) {
			return false;
		} else {
			return $this->Oauth_Library->guardianAuthenticated($this->input_data['uid'], $this->input_data['oauth_token']);
		}
	}

	public function returnPayload($inputs, $payload_type, $payload) {
		$data = array(
			'status' => 'SUCCESS',
			'status_code' => 200,
			'response_time' => (microtime(true) - $this->start_time),
			'request_datetime' => new \Datetime('now')
		);

		foreach($inputs as $key => $val){
			$data[$key] = $val;
		}

		$data['payload']['num_results'] = count($payload);
		$data['payload'][$payload_type] = $payload;

		header('Content-Type: application/json');
		echo json_encode($data);
		exit(0);
	}

	public function returnSuccess($inputs = null, $returns = null) {
		$data = array(
			'status' => 'SUCCESS',
			'status_code' => 200,
			'response_time' => (microtime(true) - $this->start_time),
			'request_datetime' => new \Datetime('now')
		);

		if ($inputs) {
			foreach($inputs as $key => $val) {
				$data['inputs'][$key] = $val;
			}
		}

		if ($returns) {
			foreach($returns as $key => $val) {
				$data['returns'][$key] = $val;
			}
		}

		header('Content-Type: application/json');
		echo json_encode($data);
		exit(0);
	}

	public function returnError($code, $message) {
		$data = array(
			'status' => 'ERROR',
			'status_code' => $code,
			'response_time' => (microtime(true) - $this->start_time),
			'request_datetime' => new \Datetime('now'),
			'error_msg' => $message
		);

		header('Content-Type: application/json');
		echo json_encode($data);
		exit(0);
	}

	/**
	 * Log a message using CodeIgniter's built in logging feature
	 *
	 * Example usage:
	 *   $this->logMessage('This message will be logged.');
	 *
	 * @param string $message
	 * @param string $logLevel Can be info, debug, error
	 */
	protected function logMessage($message, $logLevel = '')
	{
		// make sure we have the appropriate log level
		if (!in_array($logLevel, array('info', 'debug', 'error'))) {
			$logLevel = $this->config->item('default_log_level');
		}

		$method = $this->router->fetch_class() . '::' . $this->router->fetch_method();

		// build the logged message
		$logMessage = '[CONTROLLER] - ';
		if ($this->input->is_cli_request()) {
			$logMessage.= 'CLI';
		} else {
			$logMessage.= $this->input->ip_address();
		}
		$logMessage.=  ' - ' . $method;
		$logMessage.= ' - ' . $message;

		log_message($logLevel, $logMessage);
	}
}
