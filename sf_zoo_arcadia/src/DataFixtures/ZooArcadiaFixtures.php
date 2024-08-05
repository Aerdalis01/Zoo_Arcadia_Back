<?php

namespace App\DataFixtures;

use App\Entity\ZooArcadia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ZooArcadiaFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        // Create ZooArcadia instance
        $zoo = new ZooArcadia();
        $zoo->setNom('Zoo Arcadia');
        $zoo->setAdresse('123 Rue de l\'Arcadia');
        $zoo->setCreatedAt(new \DateTimeImmutable());
        

        $manager->persist($zoo);
        

        $manager->flush();

        $this->addReference('zoo_arcadia', $zoo);
    }
    public static function getGroups(): array
    {
        return ['group_zoo'];
    }
}
