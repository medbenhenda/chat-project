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

class RegisterController extends Controller
{
	public function SignUp(Request $request)
	{
		//@todo: Instead of instantiate a class use dependency injection
		$serviceUserManager = new ServiceUserManager();
		$result = $serviceUserManager->createUser($request);
		//@todo: Use session to display the result, and redirect to success page in case the result is true
		return $this->redirect('/');
	}
}