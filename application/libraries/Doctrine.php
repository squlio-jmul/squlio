<?php
// bootstrap.php
require_once(APPPATH . '/third_party/vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Doctrine {
	public $em = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		require(APPPATH . '/config/database.php');

		$paths = array(APPPATH . '/models/Entities');
		$isDevMode = false;

		// the connection configuration
		$dbParams = array(
			'driver'   => 'pdo_mysql',
			'user'     => $db['default']['username'],
			'password' => $db['default']['password'],
			'host'	   => $db['default']['hostname'],
			'dbname'   => $db['default']['database'],
		);

		$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
		$this->em = EntityManager::create($dbParams, $config);
	}
}

?>
