<?php

namespace App\Service;

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

    public function createAnimal(string $prenom, string $raceName, ?string $imagePath, ?string $imageSubDirectory, ?Habitats $habitat, ?ZooArcadia $zooArcadia): Animaux
    {
        $race = $this->entityManager->getRepository(Races::class)->findOneBy(['name' => $raceName]);
        if (!$race) {
            throw new \InvalidArgumentException('Invalid race name specified.');
        }

        $image = new Images();
        $image->setImagePath($imagePath);
        $image->setImageSubDirectory($imageSubDirectory);

        $animal = new Animaux();
        $animal->setPrenom($prenom);
        $animal->setCreatedAt(new \DateTimeImmutable()); // Date automatique
        $animal->setRace($race);
        $animal->setImage($image);
        $animal->setHabitats($habitat);
        $animal->setZooArcadia($zooArcadia);

        $this->entityManager->persist($image);
        $this->entityManager->persist($animal);
        $this->entityManager->flush();

        return $animal;
    }

    public function updateAnimal(Animaux $animal, array $newData): Animaux
    {
        $animal->setPrenom($newData['prenom']);
        $animal->setCreatedAt(new \DateTimeImmutable($newData['createdAt']));
        
        $race = $this->entityManager->getRepository(Races::class)->findOneBy(['name' => $newData['raceName']]);
        if (!$race) {
            throw new \InvalidArgumentException('Invalid race name specified.');
        }
        $animal->setRace($race);

        $image = $animal->getImage();
        if ($image) {
            $image->setImagePath($newData['imagePath']);
            $image->setImageSubDirectory($newData['imageSubDirectory']);
        } else {
            $image = new Images();
            $image->setImagePath($newData['imagePath']);
            $image->setImageSubDirectory($newData['imageSubDirectory']);
            $animal->setImage($image);
            $this->entityManager->persist($image);
        }

        $animal->setHabitats($newData['habitat']);
        $animal->setZooArcadia($newData['zooArcadia']);

        $this->entityManager->flush();

        return $animal;
    }

    public function deleteAnimal(Animaux $animal): void
    {
        $this->entityManager->remove($animal);
        $this->entityManager->flush();
    }
}