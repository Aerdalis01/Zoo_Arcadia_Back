<?php


namespace App\Service;

use App\Entity\SousService;
use App\Repository\SousServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class SousServiceService
{
    private $entityManager;
    private $sousServiceRepository;

    public function __construct(EntityManagerInterface $entityManager, SousServiceRepository $sousServiceRepository)
    {
        $this->entityManager = $entityManager;
        $this->sousServiceRepository = $sousServiceRepository;
    }

    public function save(SousService $sousService): void
    {
        $this->entityManager->persist($sousService);
        $this->entityManager->flush();
    }

    public function update(SousService $sousService): void
    {
        $this->entityManager->flush();
    }

    public function delete(SousService $sousService): void
    {
        $this->entityManager->remove($sousService);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->sousServiceRepository->findAll();
    }

    public function find(int $id): ?SousService
    {
        return $this->sousServiceRepository->find($id);
    }
}
