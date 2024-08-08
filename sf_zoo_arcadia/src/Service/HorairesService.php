<?php

namespace App\Service;

use App\Entity\Horaires;
use App\Repository\HorairesRepository;
use Doctrine\ORM\EntityManagerInterface;

class HorairesService
{
    private $entityManager;
    private $horairesRepository;

    public function __construct(EntityManagerInterface $entityManager, HorairesRepository $horairesRepository)
    {
        $this->entityManager = $entityManager;
        $this->horairesRepository = $horairesRepository;
    }

    public function save(Horaires $horaires): void
    {
        $this->entityManager->persist($horaires);
        $this->entityManager->flush();
    }

    public function update(Horaires $horaires): void
    {
        $this->entityManager->flush();
    }

    public function delete(Horaires $horaires): void
    {
        $this->entityManager->remove($horaires);
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->horairesRepository->findAll();
    }
}
