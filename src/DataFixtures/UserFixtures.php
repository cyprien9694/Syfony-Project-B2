<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@skyoftonight.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);
        $this->addReference('user_admin', $admin);

        $user = new User();
        $user->setEmail('astronome@skyoftonight.com');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password123'));
        $manager->persist($user);
        $this->addReference('user_astronome', $user);

        $users = [
            ['email' => 'marie.curie@skyoftonight.com', 'password' => 'etoile123'],
            ['email' => 'galileo@skyoftonight.com', 'password' => 'telescope456'],
            ['email' => 'carl.sagan@skyoftonight.com', 'password' => 'cosmos789'],
            ['email' => 'neil.armstrong@skyoftonight.com', 'password' => 'moonwalk123'],
        ];

        foreach ($users as $index => $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));
            $manager->persist($user);
            $this->addReference('user_' . $index, $user);
        }

        $manager->flush();
    }
}