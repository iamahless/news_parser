<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class UserFixtures extends Fixture
{
	/**
	 * @var PasswordHasherFactoryInterface $passwordHasherFactory
	 */
	private PasswordHasherFactoryInterface $passwordHasherFactory;
	/**
	 * @var array|array[]
	 */
	private array $users = [
		[
			'email' => 'admin@symfony.com',
			'role' => ['ROLE_ADMIN', 'ROLE_MODERATOR'],
			'password' => 'password'
		], [
			'email' => 'moderator@symfony.com',
			'role' => ['ROLE_MODERATOR'],
			'password' => 'password'
		]
	];

	public function __construct(PasswordHasherFactoryInterface $passwordHasherFactory)
	{
		$this->passwordHasherFactory = $passwordHasherFactory;
	}

	public function load(ObjectManager $manager): void
	{
		foreach ($this->users as $user) {
			$userEntity = new User();

			$userEntity->setEmail($user['email'])
				->setPassword(
					$this->passwordHasherFactory
						->getPasswordHasher(User::class)
						->hash($user['password'])
				)
				->setRoles($user['role'])
				->setCreatedAt(new DateTime('now'))
				->setUpdatedAt(new DateTime('now'));

			$manager->persist($userEntity);
		}

		$manager->flush();
	}
}
