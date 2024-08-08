<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Entity\Snack;
use App\Entity\CamionGlace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SousServiceFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $serviceRestauration = $this->getReference('Restauration');

        $restaurant = new Restaurant();
        $restaurant->setNomSousService('Restaurant');
        $restaurant->setDescription('Description du restaurant');
        $restaurant->setCreatedAt(new \DateTimeImmutable());
        $restaurant->setService($serviceRestauration);
        $manager->persist($restaurant);
        

        $snack = new Snack();
        $snack->setNomSousService('Snack');
        $snack->setDescription('Description du snack');
        $snack->setCreatedAt(new \DateTimeImmutable());
        $snack->setService($serviceRestauration);
        $manager->persist($snack);
        

        $camionGlace = new CamionGlace();
        $camionGlace->setNomSousService('Camion Glacé');
        $camionGlace->setDescription('Description du camion glacé');
        $camionGlace->setCreatedAt(new \DateTimeImmutable());
        $camionGlace->setService($serviceRestauration);
        $manager->persist($camionGlace);
        

        $manager->flush();

        $this->addReference('Restaurant', $restaurant);
        $this->addReference('Snack', $snack);
        $this->addReference('Camion_glace', $camionGlace);
    }

    public static function getGroups(): array
    {
        return ['group_sous_services'];
    }

    public function getDependencies()
    {
        return [
            ServicesFixtures::class,
        ];
    }
}
