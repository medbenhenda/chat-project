<?php

/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 01:32
 */
namespace Chat\Common;

use Symfony\Component\HttpFoundation\RedirectResponse;

class Controller
{
	public function render($path, $template, array $variables = [])
	{
		$templateName = $this->getTemplateName($template).'.html.twig';
		$loaderLayout = new \Twig_Loader_Filesystem(__DIR__.'/layouts');
		$loaderTemplate = new \Twig_Loader_Filesystem($path);
		$loader = new \Twig_Loader_Chain(array($loaderLayout, $loaderTemplate));
		$twig = new \Twig_Environment($loader);

		echo $twig->render($templateName, $variables);
	}

	protected function getTemplateName($strMethod)
	{
		$aMethod = explode('::', $strMethod);
		$method = $aMethod[1];
		//Convert the method name from CamelCase to camel_case
		// https://stackoverflow.com/questions/1993721/how-to-convert-camelcase-to-camel-case/19533226#19533226
		return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $method));
	}

	protected function redirect($uri)
	{
		return new RedirectResponse($uri);
	}
}