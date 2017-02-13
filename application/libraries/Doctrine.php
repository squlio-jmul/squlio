<?php
// bootstrap.php
require_once(APPPATH . '/third_party/vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Configuration;

class Doctrine {
	public $em = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		require(APPPATH . '/config/database.php');

		$cache = new \Doctrine\Common\Cache\ArrayCache;

		$config = new Configuration;
		$config->setMetadataCacheImpl($cache);
		$driverImpl = $config->newDefaultAnnotationDriver(APPPATH . '/models/Entities');
		$config->setMetadataDriverImpl($driverImpl);
		$config->setQueryCacheImpl($cache);
		$config->setProxyDir(APPPATH . '/models/proxies');
		$config->setProxyNamespace('Proxies');

		$config->setAutoGenerateProxyClasses(true);

		// the connection configuration
		$dbParams = array(
			'driver'   => 'pdo_mysql',
			'user'     => $db['default']['username'],
			'password' => $db['default']['password'],
			'host'	   => $db['default']['hostname'],
			'dbname'   => $db['default']['database'],
		);

		$this->em = EntityManager::create($dbParams, $config);
	}
}

?>
