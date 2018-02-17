<?php
/**
 * Created by PhpStorm.
 * Project: chat-project
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 20:04
 */

namespace Chat\UserModule\Services;


use Chat\UserModule\Entity\Message;
use Chat\UserModule\Entity\User;
use Kernel\EntityManager;

class ServiceMessageManager implements ServiceManagerInterface
{
	private $em;
	private $repository;

	public function __construct()
	{
		$entityManager = new EntityManager();
		$this->em = $entityManager->getEntityManager();
		$this->repository = $this->em->getRepository(Message::class);
	}

	/**
	 * Load a message by ID
	 *
	 * @param int $id
	 * @return Message
	 */
	public function load($id)
	{
		return $this->repository->find($id);
	}

	/**
	 * Get all messgaes
	 * @return array
	 */
	public function findAll()
	{
		return $this->repository->findAll();
	}

	/**
	 * Get Archived messages (messages was read)
	 * @param \Chat\UserModule\Entity\User $user
	 *
	 * @return array
	 */
	public function getArchivedMessages( User $user)
	{
		return $this->repository->findBy(['unread' => false, 'destination' => $user], array('createdAt' => 'desc'));
	}

	/**
	 * Get all unread messages
	 * @param \Chat\UserModule\Entity\User $user
	 *
	 * @return array
	 */
	public function getUnreadMessages( User $user)
	{
		return $this->repository->findBy(['unread' => true, 'destination' => $user], array('createdAt' => 'desc'));
	}

	/**
	 * Get the list of message between the current user and the user given as argument
	 * @param int $userId the other user in the chat. Isn't the current user
	 *
	 * @return array
	 */
	public function getChatMessagesWithUser( $userId)
	{
		$qb = $this->em->createQueryBuilder();
		$qb->select(array('m')) // string 'u' is converted to array internally
		->from(Message::class, 'm')
			->where($qb->expr()->orX(
				$qb->expr()->eq('m.user', '?1'),
				$qb->expr()->eq('m.destination', '?1')
			))
			->orderBy('m.createdAt', 'DESC')
			->setParameter(1, $userId);

		return $qb->getQuery()->getResult();
	}

	/**
	 * @param User $sender
	 * @param int $receiver
	 * @param string $message
	 *
	 * @return bool
	 */
	public function saveMessage( $sender, $receiver, $message)
	{
		try {
			$oMessage = new Message();
			$receiverUser = $this->loadUser($receiver);
			$oMessage->setUser($sender);
			$oMessage->setBody($message);
			$oMessage->setDestination($receiverUser);

			$this->em->clear();
			$this->em->merge($oMessage);
			$this->em->flush();

			return true;
		} catch (\Exception $e) {

			return false;
		}

	}

	/**
	 * @param int $id
	 * @return User
	 */
	private function loadUser( $id)
	{
		$serviceUser = new ServiceUserManager();

		return $serviceUser->load($id);
	}


}