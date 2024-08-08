<?php

namespace App\Service;

use App\Entity\Services;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;

class ServicesService
{
    private $entityManager;
    private $servicesRepository;

    public function __construct(EntityManagerInterface $entityManager, ServicesRepository $servicesRepository)
    {
        $this->entityManager = $entityManager;
        $this->servicesRepository = $servicesRepository;
    }

    public function save(Services $service): void
    {
        $this->entityManager->persist($service);
        $this->entityManager->flush();
    }

    public function update(Services $service): void
    {
        $this->entityManager->flush();
    }

    public function delete(Services $service): void
    {
        $this->entityManager->remove($service);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->servicesRepository->findAll();
    }

    public function find(int $id): ?Services
    {
        return $this->servicesRepository->find($id);
    }
}

