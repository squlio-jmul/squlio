<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Oauth library
 *
 * @package Oauth
 */
require_once(APPPATH . 'libraries/BW_Library.php');

require_once(APPPATH . '/third_party/vendor/autoload.php');
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;

class Oauth_Library extends BW_Library {
	public function __construct() {
		parent::__construct();
		$this->_ci->load->library('encrypt');
		$this->_ci->load->model('Teacher_model');
		$this->_ci->load->model('Guardian_model');
	}

	public function teacherAuthenticated($id, $jwt_token) {
		try {
			$signer = new Sha256();
			$token = (new Parser())->parse((string) $jwt_token); // Parses from a string

			// first verify signature
			if($token->verify($signer, $this->_ci->config->item('api_salt'))){
				if ($teacher_obj = $this->_ci->Teacher_model->get(array('id' => $id))) {
					$teacher = $teacher_obj[0];

					// now make sure that the id in the jwt token is the same as the teacher we are dealing with
					if($teacher['id'] == $token->getClaim('id')){
						$data = new ValidationData();
						$data->setIssuer($this->_ci->config->item('main_url'));
						$data->setId($teacher['token']);

						// now validate the issuer and the id of the jwt token
						if($token->validate($data)){
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

	public function guardianAuthenticated($id, $jwt_token) {
		try {
			$signer = new Sha256();
			$token = (new Parser())->parse((string) $jwt_token); // Parses from a string

			// first verify signature
			if($token->verify($signer, $this->_ci->config->item('api_salt'))){
				if ($guardian_obj = $this->_ci->Guardian_model->get(array('id' => $id))) {
					$guardian = $guardian_obj[0];

					// now make sure that the id in the jwt token is the same as the guardian we are dealing with
					if($guardian['id'] == $token->getClaim('id')){
						$data = new ValidationData();
						$data->setIssuer($this->_ci->config->item('main_url'));
						$data->setId($guardian['token']);

						// now validate the issuer and the id of the jwt token
						if($token->validate($data)){
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				return false;
			}
		} catch(Exception $err) {
			die($err->getMessage());
		}
	}

}
