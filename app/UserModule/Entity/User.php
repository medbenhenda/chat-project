<?php
/**
 * Created by PhpStorm.
 * Project: chat
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 03:16
 */

namespace Chat\UserModule\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User implements UserInterface
{
	/**
	 * @var $id
	 * @ORM\Id()
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var $firstName
	 *
	 * @ORM\Column(type="string", length=64)
	 */
	private $firstName;

	/**
	 * @var $lastName
	 *
	 * @ORM\Column(type="string", length=64)
	 */
	private $lastName;

	/**
	 * @var $email
	 *
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=255, unique=true)
	 */
	private $username;

	private $plainPassword;

	/**
	 * @ORM\Column(type="string", length=64)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $salt;

	/**
	 * @ORM\Column(type="string", length=32)
	 */
	private $roles;

	/**
	 * @ORM\OneToMany(targetEntity="Message", mappedBy="user")
	 */
	private $messages;

	/**
	 * @ORM\OneToMany(targetEntity="Message", mappedBy="destination")
	 */
	private $messagesDestination;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $enabled;

	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $connected;

	/**
	 * @return mixed
	 */
	public function getConnected()
	{
		return $this->connected;
	}

	/**
	 * @param mixed $connected
	 */
	public function setConnected( $connected )
	{
		$this->connected = $connected;
	}

	/**
	 * @return mixed
	 */
	public function getEnabled()
	{
		return $this->enabled;
	}

	/**
	 * @param mixed $enabled
	 */
	public function setEnabled( $enabled )
	{
		$this->enabled = $enabled;
	}

	/**
	 * @return mixed
	 */
	public function getMessagesDestination()
	{
		return $this->messagesDestination;
	}

	/**
	 * @param mixed $messagesDestination
	 */
	public function setMessagesDestination( $messagesDestination )
	{
		$this->messagesDestination = $messagesDestination;
	}

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
	public function getFirstName()
	{
		return $this->firstName;
	}

	/**
	 * @param mixed $firstName
	 */
	public function setFirstName( $firstName )
	{
		$this->firstName = $firstName;
	}

	/**
	 * @return mixed
	 */
	public function getLastName()
	{
		return $this->lastName;
	}

	/**
	 * @param mixed $lastName
	 */
	public function setLastName( $lastName )
	{
		$this->lastName = $lastName;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param mixed $email
	 */
	public function setEmail( $email )
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername( $username )
	{
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getPlainPassword()
	{
		return $this->plainPassword;
	}

	/**
	 * @param mixed $plainPassword
	 */
	public function setPlainPassword( $plainPassword )
	{
		$this->plainPassword = $plainPassword;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword( $password )
	{
		$this->password = $password;
	}

	/**
	 * @return mixed
	 */
	public function getMessages()
	{
		return $this->messages;
	}

	/**
	 * @param mixed $messages
	 */
	public function setMessages( $messages )
	{
		$this->messages = $messages;
	}

	public function getRoles()
	{
		return $this->roles;
	}

	/**
	 * @param mixed $roles
	 */
	public function setRoles( $roles )
	{
		$this->roles = $roles;
	}

	public function getSalt()
	{
		return $this->salt;
	}

	/**
	 * @param mixed $salt
	 */
	public function setSalt( $salt )
	{
		$this->salt = $salt;
	}

	public function eraseCredentials()
	{

	}
}