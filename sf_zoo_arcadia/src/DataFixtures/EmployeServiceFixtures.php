<?php

namespace App\DataFixtures;

use App\Entity\Avis;
use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EmployeServiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $employe = $this->getReference('employe1');

        // Valider l'avis 1
        $avis1 = $manager->getRepository(Avis::class)->find(1);
        if ($avis1 && $avis1->getEmploye() === $employe) {
            $avis1->setValide(true);
            $manager->persist($avis1);
        }

        // Invalider l'avis 2
        $avis2 = $manager->getRepository(Avis::class)->find(2);
        if ($avis2 && $avis2->getEmploye() === $employe) {
            $avis2->setValide(false);
            $manager->persist($avis2);
        }

        // Répondre au contact 1
        $contact1 = $manager->getRepository(Contact::class)->find(1);
        if ($contact1 && $contact1->getEmploye() === $employe) {
            // Ici vous pourriez utiliser un service pour envoyer un email par exemple
            $contact1->setCommentaire('Réponse à votre contact.');
            $manager->persist($contact1);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AvisFixtures::class,
            ContactFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['group_serviceEmploye'];
    }
}
