<?php

namespace App\Service;


use App\Entity\Habitats;
use Doctrine\ORM\EntityManagerInterface;

class HabitatsService
{
    private EntityManagerInterface $entityManager;
    private ImageManagerService $imageManager;

    public function __construct(EntityManagerInterface $entityManager, ImageManagerService $imageManager)
    {
        $this->entityManager = $entityManager;
        $this->imageManager = $imageManager;
    }

    public function createHabitat(string $nom, string $description, ?string $nomImage , ?string $imagePath, ?string $imageSubDirectory ): Habitats
    {
        $habitat = new Habitats();
        $habitat->setNom($nom);
        $habitat->setDescription($description);
        $habitat->setCreatedAt(new \DateTimeImmutable());

        $image = $this->imageManager->manageImage($habitat, $nomImage, $imagePath, $imageSubDirectory);
        if ($image) {
            $habitat->setImage($image);
            $this->entityManager->persist($image);
        }

        $this->entityManager->persist($habitat);
        $this->entityManager->flush();

        return $habitat;
    }

    public function updateHabitat(Habitats $habitat, string $nom, string $description, ?string $nomImage , ?string $imagePath, ?string $imageSubDirectory ): Habitats
    {
        $habitat->setNom($nom);
        $habitat->setDescription($description);
    
        $image = $this->imageManager->manageImage($habitat, $nomImage, $imagePath, $imageSubDirectory);
        if ($image) {
            $habitat->setImage($image);
            $this->entityManager->persist($image);
        }
    
        $this->entityManager->flush();

        return $habitat;
    }

    public function deleteHabitat(Habitats $habitat): void
    {
        $this->entityManager->remove($habitat);
        $this->entityManager->flush();
    }
    
}
