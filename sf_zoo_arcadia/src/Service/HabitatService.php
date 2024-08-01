<?php

namespace App\Service;

use App\Entity\Habitats;
use Doctrine\ORM\EntityManagerInterface;

class HabitatService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createHabitat(string $nom, string $description): Habitats
    {
        $habitat = new Habitats();
        $habitat->setNom($nom);
        $habitat->setDescription($description);
        $habitat->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($habitat);
        $this->entityManager->flush();

        return $habitat;
    }

    public function updateHabitat(Habitats $habitat, array $newData)
    {
        if (isset($newData['nom'])) {
            $habitat->setNOm($newData['nom']);
        }

        if (isset($newData['description'])) {
            $habitat->setDescription($newData['description']);
        }

        $habitat->setUpdatedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
    }

    public function deleteHabitat(Habitats $habitat)
    {
        $this->entityManager->remove($habitat);
        $this->entityManager->flush();
    }
}
