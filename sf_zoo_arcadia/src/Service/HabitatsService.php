<?php

namespace App\Service;

use App\Entity\Admin;
use App\Entity\Habitats;
use Doctrine\ORM\EntityManagerInterface;

class HabitatsService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createHabitat(string $nom, string $description, $zooArcadia,Admin $admin): Habitats
    {
        $habitat = new Habitats();
        $habitat->setNom($nom);
        $habitat->setDescription($description);
        $habitat->setCreatedAt(new \DateTimeImmutable());
        $habitat->setZooArcadia($zooArcadia);
        $habitat->setAdmin($admin);

        $this->entityManager->persist($habitat);
        $this->entityManager->flush();

        return $habitat;
    }

    public function updateHabitat(Habitats $habitat, array $data): Habitats
    {
        if (isset($data['nom'])) {
            $habitat->setNom($data['nom']);
        }
        if (isset($data['description'])) {
            $habitat->setDescription($data['description']);
        }
        $habitat->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();

        return $habitat;
    }

    public function deleteHabitat(Habitats $habitat): void
    {
        $this->entityManager->remove($habitat);
        $this->entityManager->flush();
    }
}
