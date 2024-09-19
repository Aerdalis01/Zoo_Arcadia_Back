<?php

namespace App\Service;


use App\Entity\Animaux;
use App\Entity\Habitats;
use App\Entity\Images;
use App\Entity\Races;
use Doctrine\ORM\EntityManagerInterface;

class AnimauxService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAnimal(string $prenom, int $raceId, ?string $nom , ?string $imagePath, ?string $imageSubDirectory, int $habitatId): Animaux
    {
    $race = $this->findRace($raceId);
    $habitat = $this->findHabitat($habitatId);

        $image = new Images();
        $image->setNom($nom);
        $image->setImagePath($imagePath);
        $image->setImageSubDirectory($imageSubDirectory);

        $animal = new Animaux();
        $animal->setPrenom($prenom);
        $animal->setCreatedAt(new \DateTimeImmutable()); 
        $animal->setRace($race);
        $animal->setHabitats($habitat);

        $image = $this->manageImage($animal, $nom, $imagePath, $imageSubDirectory);
        if ($image) {
            $animal->setImage($image);
            $this->entityManager->persist($image);
        }

        $this->entityManager->persist($animal);
        $this->entityManager->flush();

        return $animal;
    }
    public function updateAnimal(Animaux $animal, string $prenom, int $raceId, ?string $nom , ?string $imagePath, ?string $imageSubDirectory, int $habitatId): Animaux
    {
    
    $race = $this->findRace($raceId);
    $habitat = $this->findHabitat($habitatId);

    $animal->setPrenom($prenom);
    $animal->setRace($race);
    $animal->setHabitats($habitat);

    $image = $this->manageImage($animal, $nom, $imagePath, $imageSubDirectory);

    if ($image) {
        $animal->setImage($image);
        $this->entityManager->persist($image);
    }

    $this->entityManager->flush();

    return $animal;
}
    public function deleteAnimal(Animaux $animal): void
    {
    $this->entityManager->remove($animal);
    $this->entityManager->flush();
    }
    
    private function findRace(int $raceId): Races
    {
        $race = $this->entityManager->getRepository(Races::class)->findOneBy(['id' => $raceId]);
        if (!$race) {
            throw new \InvalidArgumentException('Race not found: ' . $raceId);
        }
        return $race;
    }

    private function findHabitat(int $habitatId): Habitats
    {
        $habitat = $this->entityManager->getRepository(Habitats::class)->findOneBy(['id' => $habitatId]);
        if (!$habitat) {
            throw new \InvalidArgumentException('Habitat not found: ' . $habitatId);
        }
        return $habitat;
    }

    private function manageImage(Animaux $animal, ?string $nom, ?string $imagePath, ?string $imageSubDirectory): ?Images
    {
        $image = $animal->getImage();


        if ($image) {
            $image->setNom($nom);
            $image->setImagePath($imagePath);
            $image->setImageSubDirectory($imageSubDirectory);
        } else {

            if ($nom || $imagePath || $imageSubDirectory) {
                $image = new Images();
                $image->setNom($nom);
                $image->setImagePath($imagePath);
                $image->setImageSubDirectory($imageSubDirectory);
            }
        }

        return $image;
    }
}
