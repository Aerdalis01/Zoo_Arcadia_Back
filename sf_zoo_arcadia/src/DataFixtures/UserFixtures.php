<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Employe;
use App\Entity\Veterinaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        for ($i = 1; $i <= 5; $i++) {
            $employe = new Employe();
            $employe->setEmail("employe$i@example.com");
            $employe->setUsername("employe$i@example.com");
            $employe->setPassword($this->passwordHasher->hashPassword($employe, 'password'));
            $employe->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($employe);
        }


        for ($i = 1; $i <= 5; $i++) {
            $veterinaire = new Veterinaire();
            $veterinaire->setEmail("veterinaire$i@example.com");
            $veterinaire->setUsername("veterinaire$i@example.com");
            $veterinaire->setPassword($this->passwordHasher->hashPassword($veterinaire, 'password'));
            $veterinaire->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($veterinaire);
        }


        $manager->flush();
    }
}
