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
use Chat\UserModule\Services\ServiceMessageManager;
use Chat\UserModule\Services\ServiceUserManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ChatController extends Controller
{
	public function connectedUsers(Request $request)
	{
		$content = $this->render($this->getTemplatesDirectory(), __METHOD__, array('request' => $request));

		return new Response(
			$content,
			Response::HTTP_OK,
			array('content-type' => 'text/html')
		);
	}

	public function ChatRoom(Request $request)
	{
		$user = $this->checkUser();
		$serviceMessageManager = new ServiceMessageManager();
		$serviceUserManager = new ServiceUserManager();
		$archivedMessages = $serviceMessageManager->getArchivedMessages($user);
		$unreadMessages = $serviceMessageManager->getUnreadMessages($user);
		$connectedUsers = $serviceUserManager->getConnectedUsers();
		$content = $this->render($this->getTemplatesDirectory(), __METHOD__, array(
			'messages' => $archivedMessages,
			'unread_messages' => $unreadMessages,
			'connected' => $connectedUsers,
		    'current_user' => $user
		));

		return new Response(
			$content,
			Response::HTTP_OK,
			array('content-type' => 'text/html')
		);
	}

	public function UnreadMessage(Request $request)
	{
		$user = $this->checkUser();
		$archivedMessages = new ServiceMessageManager();
		$unreadMessages = $archivedMessages->getUnreadMessages($user);
		$content = $this->render($this->getTemplatesDirectory(), __METHOD__, array('messages' => $unreadMessages));

		return new Response(
			$content,
			Response::HTTP_OK,
			array('content-type' => 'text/html')
		);
	}

	public function ReceivedMessage(Request $request, $id)
	{
		$user = $this->checkUser();
		$archivedMessages = new ServiceMessageManager();

		$chatMessages = $archivedMessages->getChatMessagesWithUser($id);
		$content = $this->render($this->getTemplatesDirectory(), __METHOD__, array('messages' => $chatMessages, 'current_user' => $user));

		return new Response(
			$content,
			Response::HTTP_OK,
			array('content-type' => 'text/html')
		);
	}

	public function SendMessage(Request $request)
	{
		$user = $this->checkUser();

		$destination = htmlentities($request->request->get('destination'));
		$message = htmlentities($request->request->get('message'));
		$serviceMessage = new ServiceMessageManager();
		$result = $serviceMessage->saveMessage($user, $destination, $message);

		if ($result) {
			return $this->ReceivedMessage($request, $destination);
		}
		return new Response(
			'Error!',
			Response::HTTP_SERVICE_UNAVAILABLE,
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

	/**
	 * @return mixed
	 */
	private function checkUser()
	{
		$session = new Session();
		if (!$session->has('_security_main')) {
			$this->redirect('/');
		}
		$securityToken = $session->get('_security_main');
		/** @var \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken $token */
		$token = unserialize($securityToken);

		return $token->getUser();
	}
}