<?php

namespace App\DataFixtures;

use App\Entity\RapportAlimentation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RapportAlimentationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $employe = $this->getReference('employe_reference'); 
        $animal = $this->getReference('animal_reference'); 

        $rapport1 = new RapportAlimentation();
        $rapport1->setDate(new \DateTime('2024-08-01'));
        $rapport1->setHeure(new \DateTime('12:00:00'));
        $rapport1->setNourriture('Foin');
        $rapport1->setQuantite(5.0);
        $rapport1->setEmploye($employe);
        $rapport1->setAnimal($animal);
        $rapport1->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($rapport1);

        $rapport2 = new RapportAlimentation();
        $rapport2->setDate(new \DateTime('2024-08-02'));
        $rapport2->setHeure(new \DateTime('08:00:00'));
        $rapport2->setNourriture('Carottes');
        $rapport2->setQuantite(2.5);
        $rapport2->setEmploye($employe);
        $rapport2->setAnimal($animal);
        $rapport2->setCreatedAt(new \DateTimeImmutable());

        $manager->persist($rapport2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            EmployeFixtures::class,
            AnimauxFixtures::class,
        ];
    }
}
