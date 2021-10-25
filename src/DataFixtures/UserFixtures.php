<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface
     */
    private $passwordHasher;

    /**
     * @param \Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface $encoder
     */
    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->passwordHasher = $encoder;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setEmail('InitialUser@hexistest.com');
        $user->setRoles([self::ROLE_USER]);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'abcd1234'));

        $manager->persist($user);
        $manager->flush();
    }
}
