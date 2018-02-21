<?php
/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 02:52
 */

namespace Chat\UserModule\Controller;

use Chat\Common\Controller;
use Chat\UserModule\Services\ServiceUserManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class SignInController extends Controller
{
	public function SignIn(Request $request)
	{
		$serviceUserManager = new ServiceUserManager();
		$result = $serviceUserManager->loadUser($request);

		if (!$result) {
			$session = new Session();
			$session->getFlashBag()->set('warning', 'Username or Password not valid.');

			return $this->redirect('/');
		} elseif($result->getUser()) {
			/** @var \Chat\UserModule\Entity\User $user */
			$user = $result->getUser();
			// @todo use eventlistener to set the user connected
			$serviceUserManager->setConnected($user, 1);
		}

		return $this->redirect('/chat');
	}


	public function Logout(Request $request)
	{
		$serviceUserManager = new ServiceUserManager();
		$session = $request->getSession();
		$tokenSecurity = $session->get('_security_main');
		$token = unserialize($tokenSecurity);
		if ($token instanceof UsernamePasswordToken) {
			return $this->redirect('/chat');
		}
		$user = $token->getUser();
		$serviceUserManager->setConnected($user, 0);

		$session->remove('_security_main');

		return $this->redirect('/');
	}
}