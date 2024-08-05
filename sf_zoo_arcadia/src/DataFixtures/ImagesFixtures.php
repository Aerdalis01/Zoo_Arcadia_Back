<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ImagesFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $image1 = new Images();
        $image1->setNom('Jungle');
        $image1->setImagePath('public\uploads\images\habitats\Jungle-66a0f13f677ca.webp');
        $image1->setImageSubDirectory('habitats');

        $manager->persist($image1);

        $image2 = new Images();
        $image2->setNom('Marais');
        $image2->setImagePath('public\uploads\images\habitats\Marais-66a0f0f74ccc8.webp');
        $image2->setImageSubDirectory('habitats');

        $manager->persist($image2);

        $image3 = new Images();
        $image3->setNom('Savane');
        $image3->setImagePath('public\uploads\images\habitats\Savane-66a0f1317db71.webp');
        $image3->setImageSubDirectory('habitats');

        $manager->persist($image3);

        $manager->flush();

        $this->addReference('Marais', $image1);
        $this->addReference('Savane', $image2);
        $this->addReference('Jungle', $image3);
    }
    public static function getGroups(): array
    {
        return ['group_images'];
    }
}
