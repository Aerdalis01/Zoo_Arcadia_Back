<?php

namespace App\Service;

use App\Entity\Admin;
use App\Entity\Animaux;
use App\Entity\Habitats;
use App\Entity\Images;
use App\Entity\Races;
use App\Entity\ZooArcadia;
use Doctrine\ORM\EntityManagerInterface;

class AnimauxService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAnimal(string $prenom, string $raceNom, ?string $imagePath, ?string $imageSubDirectory, ?Habitats $habitat, ?ZooArcadia $zooArcadia, ?Admin $admin): Animaux
    {
        $race = $this->entityManager->getRepository(Races::class)->findOneBy(['nom' => $raceNom]);
        if (!$race) {
            throw new \InvalidArgumentException('Race not found: ' . $raceNom);
        }

        $image = new Images();
        $image->setImagePath($imagePath);
        $image->setImageSubDirectory($imageSubDirectory);

        $animal = new Animaux();
        $animal->setPrenom($prenom);
        $animal->setCreatedAt(new \DateTimeImmutable()); 
        $animal->setRace($race);
        $animal->setImage($image);
        $animal->setHabitats($habitat);
        $animal->setZooArcadia($zooArcadia);
        $animal->setAdmin($admin);

        $this->entityManager->persist($image);
        $this->entityManager->persist($animal);
        $this->entityManager->flush();

        return $animal;
    }
}
