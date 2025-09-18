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
        // Byo
        $byo = new User();
        $byo->setUsername('Byo');
        $byo->setEmail('byo@admin.com');
        $byo->setPassword('$2y$13$NnXtKbY/pAg4G5u3QgmBEu1uJBiMBmkVOuD/oBAZITqwJJRZeygf2'); // Déjà hashé
        $byo->setRoles(['ROLE_ADMIN']);
        $byo->setCreatedAt(new DateTimeImmutable()); // Date actuelle
        $byo->setState(true);
        $manager->persist($byo);

        // Admin
        $admin = new User();
        $admin->setUsername('Admin');
        $admin->setEmail('admin@admin.com');
        $admin->setPassword('$2y$13$NZel34VzpEgP52cEGEOlbOOLxE21AxF30cbZ9JYR.m8dWTQ1qSsES'); // Déjà hashé
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setCreatedAt(new DateTimeImmutable()); // Date actuelle
        $admin->setState(true);
        $manager->persist($admin);

        // User
        $user = new User();
        $user->setUsername('User');
        $user->setEmail('user@user.com');
        $user->setPassword('$2y$13$NZel34VzpEgP52cEGEOlbOOLxE21AxF30cbZ9JYR.m8dWTQ1qSsES'); // Déjà hashé
        $user->setRoles(['ROLE_USER']);
        $user->setCreatedAt(new DateTimeImmutable()); // Date actuelle
        $user->setState(true);
        $manager->persist($user);

        $manager->flush();
    }
}