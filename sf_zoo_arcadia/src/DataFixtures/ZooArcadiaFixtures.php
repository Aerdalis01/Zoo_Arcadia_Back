<?php

namespace App\DataFixtures;

use App\Entity\ZooArcadia;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ZooArcadiaFixtures extends Fixture
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
}
