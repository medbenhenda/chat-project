<?php
// cli-config.php
require_once 'bootstrap.php';
// Any way to access the EntityManager from  your application
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
