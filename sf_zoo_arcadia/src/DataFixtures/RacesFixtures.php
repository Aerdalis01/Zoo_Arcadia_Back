<?php

namespace App\DataFixtures;

use App\Entity\Races;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class RacesFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $racesData = [
            'Cervidé' => 'race_cervide',
            'Éléphantidé' => 'race_elephantide',
        ];

        foreach ($racesData as $raceNom => $reference) {
            $race = new Races($raceNom);
            $manager->persist($race);
            $this->addReference($reference, $race);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group_races'];
    }
}
