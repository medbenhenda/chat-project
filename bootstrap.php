<?php
/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 12:51
 */
require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


$paths = [__DIR__.'/app/UserModule/Entity'];
$proxyDir = __DIR__.'/cache';
$isDevMode = false;

// the connection configuration
$dbParams = array(
	'driver'   => 'pdo_mysql',
	'user'     => 'root',
	'password' => '',
	'dbname'   => 'chat',
);

$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__.'/app/UserModule/Entity'), $isDevMode, $proxyDir, null, false);
$entityManager = EntityManager::create($dbParams, $config);
