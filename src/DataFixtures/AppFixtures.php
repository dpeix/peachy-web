<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@mail.com');
        $user->setPassword('$2y$13$2cEEzXimrWh0ueq9In/6TeudC7ZyzA0InLtwWmkJJ5iPYQe3bCwhK'); // Déjà hashé
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCreatedAt(new DateTimeImmutable()); // Date actuelle
        $user->setState(true);

        $manager->persist($user);
        $manager->flush();
    }
}