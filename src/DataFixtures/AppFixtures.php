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
        $user->setUsername('Byo');
        $user->setEmail('byo@admin.com');
        $user->setPassword('$2y$13$NnXtKbY/pAg4G5u3QgmBEu1uJBiMBmkVOuD/oBAZITqwJJRZeygf2'); // Déjà hashé
        $user->setRoles(['ROLE_ADMIN']);
        $user->setCreatedAt(new DateTimeImmutable()); // Date actuelle
        $user->setState(true);

        $manager->persist($user);
        $manager->flush();
    }
}