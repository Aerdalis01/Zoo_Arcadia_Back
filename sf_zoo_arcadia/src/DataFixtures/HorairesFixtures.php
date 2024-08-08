<?php

namespace App\DataFixtures;

use App\Entity\Horaires;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HorairesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        foreach ($jours as $jour) {
            $horaires = new Horaires();
            $horaires->setJour($jour);
            $horaires->setHeureOuvertureZoo(new \DateTimeImmutable('09:00:00'));
            $horaires->setHeureFermetureZoo(new \DateTimeImmutable('18:00:00'));
            $horaires->setHorairesServices(['10:00', '12:00', '14:00', '16:00']);
            $horaires->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($horaires);
        }

        $manager->flush();
    }
}
