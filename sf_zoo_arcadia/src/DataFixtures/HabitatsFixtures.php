<?php

namespace App\DataFixtures;

use App\Entity\Habitats;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class HabitatsFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $zoo = $this->getReference('zoo_arcadia');
        
        
        $image1 = $this->getReference('Marais');
        $image2 = $this->getReference('Savane');
        $image3 = $this->getReference('Jungle');

        $habitat1 = new Habitats();
        $habitat1->setNom('Marais');
        $habitat1->setDescription('Large open area with grasslands.');
        $habitat1->setCreatedAt(new \DateTimeImmutable());
        $habitat1->setZooArcadia($zoo);
        $habitat1->addImage($image1); 
        $manager->persist($habitat1);

        $habitat2 = new Habitats();
        $habitat2->setNom('Savane');
        $habitat2->setDescription('Dense forest with high humidity.');
        $habitat2->setCreatedAt(new \DateTimeImmutable());
        $habitat2->setZooArcadia($zoo);
        $habitat2->addImage($image2);
        $manager->persist($habitat2);
        
        $habitat3 = new Habitats();
        $habitat3->setNom('Jungle');
        $habitat3->setDescription('Dense forest with high humidity.');
        $habitat3->setCreatedAt(new \DateTimeImmutable());
        $habitat3->setZooArcadia($zoo);
        $habitat3->addImage($image3);
        $manager->persist($habitat3);

        $manager->flush();

        $this->addReference('habitat_marais', $habitat1);
        $this->addReference('habitat_savane', $habitat2);
        $this->addReference('habitat_jungle', $habitat3);
    }

    public function getDependencies()
    {
        return [
            ZooArcadiaFixtures::class,
            ImagesFixtures::class,
        ];
    }
    public static function getGroups(): array
    {
        return ['group_habitats'];
    }
}