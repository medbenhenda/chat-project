<?php

/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 15/02/2018
 * Time: 23:50
 */
namespace Routing;

use Symfony\Component\Config\Loader\FileLoader;
use Symfony\Component\Yaml\Yaml;

class YamlRouteLoader extends FileLoader
{
	public function load($resource, $type = null)
	{
		return Yaml::parse(file_get_contents($resource));
	}

	public function supports($resource, $type = null)
	{
		return is_string($resource) && 'yml' === pathinfo(
				$resource,
				PATHINFO_EXTENSION
			);
	}
}