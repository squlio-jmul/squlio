<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SQ_Controller extends CI_Controller {
	private $_response_string;

	public function __construct() {
		parent::__construct();
		$this->_resetResponse();
	}

	/**
	 * Reset internal JSON response string
	 *
	 */
	private function _resetResponse() {
		$this->_response_string = array();
	}

	/**
	 * Add a key/value pair to JSON response
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	protected function setResponseElement($key, $value) {
		$this->_response_string[$key] = $value;
	}

	/**
	 * Output JSON response string
	 *
	 */
	protected function sendResponse() {
		echo json_encode($this->_response_string);
		$this->_resetResponse();
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
	protected function logMessage($message, $logLevel = '') {
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
