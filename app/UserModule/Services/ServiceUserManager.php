<?php
/**
 * Created by PhpStorm.
 * Project: chat-project
 * User: m.benhenda
 * Date: 16/02/2018
 * Time: 20:04
 */

namespace Chat\UserModule\Services;


use Chat\UserModule\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Kernel\EntityManager;

class ServiceUserManager implements ServiceManagerInterface
{
	private $encoder;
	private $em;
	private $repository;

	public function __construct()
	{
		$this->encoder = new BCryptPasswordEncoder(15);
		$entityManager = new EntityManager();
		$this->em = $entityManager->getEntityManager();
		$this->repository = $this->em->getRepository(User::class);
	}

	/**
	 * load an user by ID
	 * @param int $id
	 *
	 * @return User
	 */
	public function load($id)
	{
		return $this->repository->find($id);
	}

	/**
	 * find all users in the table users
	 * @return array
	 */
	public function findAll()
	{
		return $this->repository->findAll();
	}

	/**
	 * Create a new user based in data submitted from register form
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return boolean
	 */
	public function createUser( Request$request)
	{
		try {
			$plainPassword = $request->get('password');
			//$confirmPassword = $request->get('confirm_password');
			// @todo check if the password and the confirmed password are identical
			//$encoderFactory = new EncoderFactory(['bcrypt']);
			//$encoder = new UserPasswordEncoder($encoderFactory);
			$encoded = $this->encoder->encodePassword($plainPassword, null);
			$user = new User();
			$user->setEmail($request->get('email'));
			$user->setUsername($request->get('username'));
			$user->setFirstName($request->get('firstname'));
			$user->setLastName($request->get('lastname'));
			$user->setSalt(null);
			$user->setRoles('simple_user');
			$user->setPassword($encoded);
			$user->setEnabled(true);

			$this->em->persist($user);
			$this->em->flush();

			return true;
		} catch (\Exception $e) {
			return false;
		}
	}

	/**
	 * Load an user when he/she signin
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 *
	 * @return bool|\Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken
	 */
	public function loadUser( Request $request)
	{
		$username = $request->get('username');
		$password = $request->get('password');
		/** @var User $user */
		$user = $this->repository->findOneBy(['username' => $username]);
		if (!$user) {
			return false;
		}

		$user->setConnected(true);
		$passwordValid = $this->encoder->isPasswordValid($user->getPassword(), $password, null);
		if ($passwordValid) {
			$token  = new UsernamePasswordToken($user, $password, 'main', ['simple_user']);
			$session = new Session();
			$session->start();
			$session->set('_security_main', serialize($token));
			$session->getFlashBag()->add('notice', 'You are logged!');

			return $token;
		}

		return false;
	}

	/**
	 * Get the list of connected users
	 * @return array
	 */
	public function getConnectedUsers()
	{
		return $this->repository->findBy(['connected' => true], ['firstName' => 'asc']);
	}
}