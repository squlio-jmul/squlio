<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cookie library
 *
 * @package Libraries
 */

require_once(APPPATH . 'libraries/SQ_Library.php');

/**
 * Generates pages within the app
 *
 */
class Cookie extends SQ_Library {
	private $prepend;

	public function __construct()
	{
		parent::__construct();
		$this->prepend = 'SQ_';
	}

	public function set($name, $value = null) {
		if (is_array($name)) {
			foreach ($name as $key => $val) {
				setcookie($this->prepend . $key, json_encode($val), time() + (60*60*24*7), '/');
				$_COOKIE[$this->prepend.$key] = json_encode($val);
			}
			return true;
		} elseif (setcookie($this->prepend . $name, json_encode($value), time() + (60*60*24*7), '/')) {
			$_COOKIE[$this->prepend.$name] = json_encode($value);
			return true;
		}
		return false;
	}

	public function destroy($name) {
		setcookie($this->prepend . $name, '', time() - (60*60*24*100), '/');
		unset($_COOKIE[$this->prepend . $name]);
		return true;
	}

	public function get($name) {
		$$name = (isset($_COOKIE[$this->prepend . $name])) ? json_decode($_COOKIE[$this->prepend . $name], true) : false;
		return $$name;
	}

	public function get_all() {
		$return = array();
		if (isset($_COOKIE)) {
			foreach($_COOKIE as $key => $value) {
				if (substr($key, 0, strlen($this->prepend)) === $this->prepend) {
					$key = substr($key, strlen($this->prepend));
				}
				$return[$key] = json_decode($value, true);
			}
		}
		return $return;
	}

	public function destroy_all() {
		if (isset($_COOKIE)) {
			foreach($_COOKIE as $key => $value) {
				if (substr($key, 0, strlen($this->prepend)) === $this->prepend) {
					setcookie($key, '', time() - (60*60*24*100), '/');
					unset($_COOKIE[$key]);
				}
			}
		}
		return true;
	}
}
