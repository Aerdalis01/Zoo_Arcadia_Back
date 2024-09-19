<?php

namespace App\DataFixtures;

use App\Entity\Carousel;
use App\Entity\CarouselSlide;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarouselFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un nouveau Carousel
        $carousel = new Carousel();
        $carousel->setCreatedaT(new \DateTimeImmutable());

        // Création de plusieurs slides pour le carousel
        for ($i = 1; $i <= 4; $i++) {
            $slide = new CarouselSlide();
            $slide->setImageLarge('large-image-' . $i . '.jpg');
            $slide->setImageMedium('medium-image-' . $i . '.jpg');
            $slide->setImageSmall('small-image-' . $i . '.jpg');
            $slide->setDescription('Description for slide ' . $i);
            $createdAt = new \DateTimeImmutable();
            $slide->setCreatedAt($createdAt);

            // Debug output
            error_log('Setting createdAt: ' . $createdAt->format('Y-m-d H:i:s'));

            $carousel->addCarouselSlide($slide);
        }

        // Persistence du carousel
        $manager->persist($carousel);

        // Sauvegarde en base de données
        $manager->flush();
    }
}
