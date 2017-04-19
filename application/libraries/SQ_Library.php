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

	public function uploadImage($file) {
		$error = false;
		$error_msg = $url_path = null;
		$valid_extensions = array('jpeg', 'jpg', 'png');
		if (isset($file['type'])) {
			$temporary = explode('.', $file['name']);
			$file_extension = end($temporary);
			if ((($file['type'] == 'image/png') || ($file['type'] == 'image/jpg') || ($file['type'] == 'image/jpeg')
				) && ($file['size'] < (2000*1024)) && in_array($file_extension, $valid_extensions)) {
					if ($file['error'] > 0) {
						$error = true;
						$error_msg = $file['error'];
					} else {
						$uniqid = uniqid(strtotime('now'));
						$url_path = $this->_ci->config->item('upload_img_dir') . '/' . $uniqid;
						$handle = fopen($url_path, 'w');
						$img = file_get_contents($file['tmp_name']);
						fwrite($handle, $img);
						fclose($handle);
						if (file_exists($url_path)) {
							$error = false;
						} else {
							$error = true;
							$error_msg = 'Unable to upload file';
						}
					}
				}
		} else {
			$error = true;
			$error_msg = 'Invalid file size (Max 2MB) or type (has to be jpg, jpeg or png)';
		}
		return array('success'=>!$error, 'error_msg'=>$error_msg, 'url_path'=>$this->_ci->config->item('main_url') . '/' . $url_path);
	}


}
