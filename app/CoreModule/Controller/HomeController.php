<?php
/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 01:10
 */

namespace Chat\CoreModule\Controller;

use Chat\Common\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
	public function Home($request)
	{
		$content = $this->render($this->getTemplatesDirectory(), __METHOD__, array('name' => 'BenHenda'));
		return new Response(
			$content,
			Response::HTTP_OK,
			array('content-type' => 'text/html')
		);
	}

	/**
	 *
	 * @return string
	 */
	private function getTemplatesDirectory()
	{
		return __DIR__.'/../Resources/Views/';
	}
}