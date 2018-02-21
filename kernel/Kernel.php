<?php

/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 00:25
 */

namespace Kernel;

use Symfony\Component\Config\FileLocator;
use Routing\YamlRouteLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

class Kernel
{
	protected $routes = array();

	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @throws \RuntimeException
	 * @throws \InvalidArgumentException
	 */
	public function handle( Request $request)
	{
		$session = new Session();
		$session->start();
		$request->setSession($session);
		//@todo : Making the collection route in the cache to optimizing the app.
		// Get all defined route in config/routes/routes.yml
		$definedRoutes = $this->getDefinedRoutes();
		// Get the collection route. An iterable class that contains all routes deined in the config YML.
		$this->routes = $this->getCollectionRoute($definedRoutes);
		// Check if the current url exists in our collection route and if exists get the default controller
		$defaults = $this->getDefaultsOfRoute($request);
		$controller = new $defaults['_controller']();
		$action = $defaults['action'];
		$args = [];
		foreach ($defaults as $key => $value) {
			if (!in_array($key, ['_controller', 'action', '_route'])) {
				$args[] = $value;
			}
		}

		return $controller->$action($request, ...$args);
	}

	/**
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	private function getDefinedRoutes()
	{
		$configDirectories = [__DIR__ . '/../config/routes'];
		$locator = new FileLocator($configDirectories);
		$yamlRouteFiles = $locator->locate('routes.yml', null, false);
		$ymlRoutes = new YamlRouteLoader($locator);

		return $ymlRoutes->load($yamlRouteFiles[0]);
	}

	/**
	 * @param array $definedRoutes
	 *
	 * @return \Symfony\Component\Routing\RouteCollection
	 */
	private function getCollectionRoute( array $definedRoutes )
	{
		$routes = new RouteCollection();
		foreach ($definedRoutes as $key => $configRoute) {
			$route = new Route($configRoute['path'], ['_controller' => $configRoute['controller'],
			                                          'action' => $configRoute['action']]
			);
			$routes->add($key, $route);
		}

		return $routes;
	}


	/**
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return array
	 * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
	 * @throws \Symfony\Component\Routing\Exception\NoConfigurationException
	 * @throws \Symfony\Component\Routing\Exception\MethodNotAllowedException
	 */
	private function getDefaultsOfRoute( Request $request )
	{
		$currentUri = $request->getRequestUri();
		$context = new RequestContext($currentUri);
		$matcher = new UrlMatcher($this->routes, $context);

		return $matcher->match($currentUri);

	}
}