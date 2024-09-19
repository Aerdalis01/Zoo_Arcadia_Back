<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EmployeFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $existingEmploye = $manager->getRepository(Employe::class)
        ->findOneBy(['email' => 'employe1@example.com']);

    if (!$existingEmploye) {
        // Créer l'employé s'il n'existe pas
        $employe = new Employe();
        $employe->setUsername('employe1');
        $employe->setEmail('employe1@example.com');
        $employe->setPassword($this->passwordHasher->hashPassword($employe, 'password'));
        $employe->setRoles(['ROLE_EMPLOYE']);
        $employe->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($employe);

        // Ajouter une référence pour utiliser dans ContactFixtures
        $this->addReference('employe1', $employe);

        $manager->flush();
    } else {
        // Ajouter une référence pour l'employé existant
        $this->addReference('employe1', $existingEmploye);
    }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            AdminFixtures::class,
        ];
    }
    public static function getGroups(): array
    {
        return ['group_employe'];
    }
}
