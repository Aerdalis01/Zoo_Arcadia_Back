<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EmployeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $employe1 = new Employe();
        $employe1->setUsername('employe1');
        $employe1->setPassword('password1');
        $employe1->setEmail('employe1@example.com');
        // Set other fields as needed
        $manager->persist($employe1);
        $this->addReference('employe1', $employe1);

        $employe2 = new Employe();
        $employe2->setUsername('employe2');
        $employe2->setPassword('password2');
        $employe2->setEmail('employe2@example.com');
        // Set other fields as needed
        $manager->persist($employe2);
        $this->addReference('employe2', $employe2);

        $manager->flush();
    }
}
