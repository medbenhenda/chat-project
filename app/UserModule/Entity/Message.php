<?php
/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 03:23
 */

namespace Chat\UserModule\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity()
 * @ORM\Table(name="messages")
 * @ORM\HasLifecycleCallbacks()
 */
class Message
{
	/**
	 * @var $id
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var $body
	 *
	 * @ORM\Column(type="text")
	 */
	private $body;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
	 * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
	 */
	private $user;

	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="messagesDestination")
	 * @ORM\JoinColumn(name="destination_id", referencedColumnName="id")
	 */
	private $destination;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $unread;

	/**
	 * @return mixed
	 */
	public function getUnread()
	{
		return $this->unread;
	}

	/**
	 * @param mixed $unread
	 */
	public function setUnread( $unread )
	{
		$this->unread = $unread;
	}

	/**
	 * @ORM\PrePersist
	 */
	public function setNewItem()
	{
		$this->createdAt = new \DateTime();
		$this->unread = true;
	}

	/**
	 * @return mixed
	 */
	public function getDestination()
	{
		return $this->destination;
	}

	/**
	 * @param mixed $destination
	 */
	public function setDestination( $destination )
	{
		$this->destination = $destination;
	}

	/**
	 * @var \DateTime $createdAt
	 * @ORM\Column(type="datetime")
	 */
	private $createdAt;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId( $id )
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody( $body )
	{
		$this->body = $body;
	}

	/**
	 * @return mixed
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * @param mixed $user
	 */
	public function setUser( $user )
	{
		$this->user = $user;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	 * @param \DateTime $createdAt
	 */
	public function setCreatedAt( $createdAt )
	{
		$this->createdAt = $createdAt;
	}
}