<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImagesFixtures extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $restaurant = $this->getReference('Restaurant');
        $snack = $this->getReference('Snack');
        $camionGlace = $this->getReference('Camion_glace');
        

        //Elements de verification
        echo 'Restaurant: ' . ($restaurant ? 'found' : 'not found') . PHP_EOL;
        echo 'Snack: ' . ($snack ? 'found' : 'not found') . PHP_EOL;
        echo 'Camion_glace: ' . ($camionGlace ? 'found' : 'not found') . PHP_EOL;

        if (!$restaurant || !$snack || !$camionGlace) {
            throw new \Exception("Sous-service manquant");
        }
        $imageRestaurant = new Images();
        $imageRestaurant->setNom('Restaurant');
        $imageRestaurant->setImagePath('public/uploads/images/services/Rectangle-1.webp');
        $imageRestaurant->setImageSubDirectory('services');
        $imageRestaurant->setSousService($restaurant);
        $manager->persist($imageRestaurant);

        $imageSnack = new Images();
        $imageSnack->setNom('Snack');
        $imageSnack->setImagePath('public/uploads/images/services/Rectangle-1.webp');
        $imageSnack->setImageSubDirectory('services');
        $imageSnack->setSousService($snack);
        $manager->persist($imageSnack);


        $imageCamionGlace = new Images();
        $imageCamionGlace->setNom('Camion glacé');
        $imageCamionGlace->setImagePath('public/uploads/images/services/Rectangle-2.webp');
        $imageCamionGlace->setImageSubDirectory('services');
        $imageCamionGlace->setSousService($camionGlace);
        $manager->persist($imageCamionGlace);

        $carteZoo = new Images();
        $carteZoo->setNom('Carte du Zoo');
        $carteZoo->setImagePath('public/uploads/images/carte_zoo.png');
        $carteZoo->setImageSubDirectory('images');

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

        $imageRestauration = new Images();
        $imageRestauration->setNom('Restauration');
        $imageRestauration->setImagePath('public\uploads\images\services\Background(20).webp');
        $imageRestauration->setImageSubDirectory('services');
        $manager->persist($imageRestauration);

        $imageVisiteGuidee = new Images();
        $imageVisiteGuidee->setNom('Visite Guidée');
        $imageVisiteGuidee->setImagePath('public\uploads\images\services\Background(21).webp');
        $imageVisiteGuidee->setImageSubDirectory('services');
        $manager->persist($imageVisiteGuidee);

        $imagePetitTrain = new Images();
        $imagePetitTrain->setNom('Petit Train');
        $imagePetitTrain->setImagePath('public\uploads\images\services\Background(22).webp');
        $imagePetitTrain->setImageSubDirectory('services');
        $manager->persist($imagePetitTrain);

        

        $manager->flush();

        $this->addReference('Jungle', $image1);
        $this->addReference('Marais', $image2);
        $this->addReference('Savane', $image3);
        if (!$this->hasReference('Restauration')) {
            $this->addReference('Restauration', $imageRestauration);
        }
        if (!$this->hasReference('Visite_guidee')) {
            $this->addReference('Visite_guidee', $imageVisiteGuidee);
        }
        if (!$this->hasReference('Petit_train')) {
            $this->addReference('Petit_train', $imagePetitTrain);
        }
    }
    public static function getGroups(): array
    {
        return ['group_images'];
    }
    public function getDependencies()
    {
        return [
            SousServiceFixtures::class,
        ];
    }
}
