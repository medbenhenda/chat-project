<?php
/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 12:30
 */

namespace Kernel;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as EM;
use Routing\YamlRouteLoader;
use Symfony\Component\Config\FileLocator;

class EntityManager
{
	private $paths = [__DIR__.'/../app/UserModule/Entity'];
	private $entityManager;
	public function     __construct()
	{
		$proxyDir = __DIR__.'/../cache';
		$mysqlConfig = $this->getConfigs();
		$dbParams = array(
			'driver'   => $mysqlConfig['mysql']['driver'],
			'user'     => $mysqlConfig['mysql']['user'],
			'password' => $mysqlConfig['mysql']['password'],
			'dbname'   => $mysqlConfig['mysql']['dbname'],
		);
		$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/app/UserModule/Entity'), true, $proxyDir, null, false);
		$config->setAutoGenerateProxyClasses(true);
		/** @var \Doctrine\ORM\EntityManager entityManager */
		$this->entityManager = EM::create($dbParams, $config);
	}

	private function getConfigs()
	{
		$configDirectories = [__DIR__ . '/../config/database'];
		$locator = new FileLocator($configDirectories);
		$yamlConfigFiles = $locator->locate('mysql.yml', null, false);
		$ymlConfigs = new YamlRouteLoader($locator);

		return $ymlConfigs->load($yamlConfigFiles[0]);
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	public function getEntityManager()
	{
		return $this->entityManager;
	}

	public function addPath($path)
	{
		$this->paths[] = $path;
	}
}