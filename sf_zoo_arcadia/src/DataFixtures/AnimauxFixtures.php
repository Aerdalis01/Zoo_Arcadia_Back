<?php

namespace App\DataFixtures;

use App\Entity\Animaux;
use App\Entity\Races;
use App\Entity\Habitats;
use App\Entity\ZooArcadia;
use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class AnimauxFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {

        $habitat1 = $this->getReference('habitat_marais');
        $habitat2 = $this->getReference('habitat_savane');
        $zooArcadia = $this->getReference('zoo_arcadia');


        $raceCervide = $this->getReference('race_cervide');
        $raceElephantide = $this->getReference('race_elephantide');

        if (!$habitat1 || !$habitat2 || !$zooArcadia || !$raceCervide || !$raceElephantide) {
            throw new \InvalidArgumentException('L\'une des références est nulle');
        }


        $animauxData = [
            [
                'prenom' => 'René le cerf',
                'race' => $raceCervide,
                'imageNom' => 'Rene_le_cerf',
                'imagePath' => 'uploads/images/animals/aerdalis01-photrealistic-a-white-cerf-selfie-386cd011-80ef-44a9-8ca4-4be08c9ca9ba-fotor-2024052112256-66a105106d5b7.webp',
                'imageSubDirectory' => 'animals',
                'habitat' => $habitat1,
                'zooArcadia' => $zooArcadia,
            ],
            [
                'prenom' => 'Basile l\'éléphant',
                'race' => $raceElephantide,
                'imageNom' => 'elephant-66a1066c99a48.webps',
                'imagePath' => 'public/uploads/images/animals/elephant-66a1066c99a48.webp',
                'imageSubDirectory' => 'animals',
                'habitat' => $habitat2,
                'zooArcadia' => $zooArcadia,
            ],
        ];


        foreach ($animauxData as $animalData) {
            error_log('Création de l\'animal: ' . $animalData['prenom'] . ' avec la race: ' . $animalData['race']->getNom());
            $image = new Images();
            $image->setNom($animalData['imageNom']);
            $image->setImagePath($animalData['imagePath']);
            $image->setImageSubDirectory($animalData['imageSubDirectory']);
            $manager->persist($image);

            $animal = new Animaux();
            $animal->setPrenom($animalData['prenom']);
            $animal->setCreatedAt(new \DateTimeImmutable());
            $animal->setRace($animalData['race']);
            $animal->setImage($image);
            $animal->setHabitats($animalData['habitat']);
            $animal->setZooArcadia($animalData['zooArcadia']);

            $manager->persist($animal);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            HabitatsFixtures::class,
            ZooArcadiaFixtures::class,
            RacesFixtures::class,
        ];
    }

    public static function getGroups(): array
    {
        return ['group_animaux'];
    }
}
