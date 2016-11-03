<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class SQ_Model extends CI_Model {
	public function __construct()
	{
		parent::__construct();

		$this->logMessage(get_called_class(), 'LOAD');
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
		$logMessage = '[MODEL] - ';
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
