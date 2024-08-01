<?php

namespace App\Service;

use App\Entity\Animaux;
use App\Entity\Races;
use App\Entity\Images;
use Doctrine\ORM\EntityManagerInterface;

class AnimauxService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createAnimal(string $prenom, string $createdAt, string $raceId, string $imagePath, string $imageSubDirectory): Animaux
    {
        $race = $this->entityManager->getRepository(Races::class)->find($raceId);
        if (!$race) {
            throw new \InvalidArgumentException('Invalid race ID specified.');
        }

        $image = new Images();
        $image->setImagePath($imagePath);
        $image->setImageSubDirectory($imageSubDirectory);

        $animal = new Animaux();
        $animal->setPrenom($prenom);
        $animal->setCreatedAt(new \DateTimeImmutable($createdAt));
        $animal->setRace($race);
        $animal->setImage($image);

        $this->entityManager->persist($animal);
        $this->entityManager->flush();

        return $animal;
    }

    public function updateAnimal(Animaux $animal, array $newData)
    {
        if (isset($newData['prenom']) && $animal->getPrenom() !== $newData['prenom']) {
            $animal->setPrenom($newData['prenom']);
        }

        if (isset($newData['createdAt'])) {
            $animal->setCreatedAt(new \DateTimeImmutable($newData['createdAt']));
        }

        if (isset($newData['raceId'])) {
            $race = $this->entityManager->getRepository(Races::class)->find($newData['raceId']);
            if ($race) {
                $animal->setRace($race);
            } else {
                throw new \InvalidArgumentException('Invalid race ID specified.');
            }
        }

        if (isset($newData['imagePath']) || isset($newData['imageSubDirectory'])) {
            $image = $animal->getImage();
            if (!$image) {
                $image = new Images();
                $animal->setImage($image);
            }

            if (isset($newData['imagePath'])) {
                $image->setImagePath($newData['imagePath']);
            }

            if (isset($newData['imageAlt'])) {
                $image->setImageSubDirectory($newData['imageSubDirectory']);
            }
        }

        $animal->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
    }

    public function deleteAnimal(Animaux $animal)
    {
        $this->entityManager->remove($animal);
        $this->entityManager->flush();
    }
}
