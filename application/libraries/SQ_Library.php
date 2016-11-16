<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SQ_Library {
    protected $_ci; // CodeIgniter object

    public function __construct()
    {
        // retreive CI instance
        $this->_ci =& get_instance();

        self::logMessage(get_called_class(), 'LOAD');
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
			$logLevel = $this->_ci->config->item('default_log_level');
		}

		$method = $this->_ci->router->fetch_class() . '::' . $this->_ci->router->fetch_method();

		// build the logged message
		$logMessage = '[LIBRARY] - ';
		if ($this->_ci->input->is_cli_request()) {
			$logMessage.= 'CLI';
		} else {
			$logMessage.= $this->_ci->input->ip_address();
		}
		$logMessage.=  ' - ' . $method;
		$logMessage.= ' - ' . $message;

		log_message($logLevel, $logMessage);
	}
}
