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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class HomeController extends Controller
{
	public function Home(Request $request)
	{
		$tokenSecurity = $request->getSession()->get('_security_main');
		$token = unserialize($tokenSecurity);
		if ($token instanceof UsernamePasswordToken) {
			return $this->redirect('/chat');
		}
		$content = $this->render($this->getTemplatesDirectory(), __METHOD__, array());
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