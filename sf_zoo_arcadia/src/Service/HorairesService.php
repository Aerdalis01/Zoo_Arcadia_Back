<?php

namespace App\Service;

use App\Entity\InfoService;
use App\Entity\Admin;
use App\Entity\Horaires;
use Doctrine\ORM\EntityManagerInterface;

class HoraireService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createHoraire(string $jour, array $heureOuverture, array $heureFermeture, ?InfoService $infoService, ?Admin $admin): Horaires
    {
        $horaire = new Horaires();
        $horaire->setJour($jour);
        $horaire->setHeureOuverture($heureOuverture);
        $horaire->setHeureFermeture($heureFermeture);
        $horaire->setCreatedAt(new \DateTimeImmutable());

        if ($infoService) {
            $horaire->setInfoService($infoService);
        }

        if ($admin) {
            $horaire->setAdmin($admin);
        }

        $this->entityManager->persist($horaire);
        $this->entityManager->flush();

        return $horaire;
    }

    public function updateHoraire(Horaires $horaire, array $newData): void
    {
        if (isset($newData['jour'])) {
            $horaire->setJour($newData['jour']);
        }

        if (isset($newData['heureOuverture'])) {
            $horaire->setHeureOuverture($newData['heureOuverture']);
        }

        if (isset($newData['heureFermeture'])) {
            $horaire->setHeureFermeture($newData['heureFermeture']);
        }

        if (isset($newData['infoService'])) {
            $horaire->setInfoService($newData['infoService']);
        }

        if (isset($newData['admin'])) {
            $horaire->setAdmin($newData['admin']);
        }

        $horaire->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush();
    }

    public function deleteHoraire(Horaires $horaire): void
    {
        $this->entityManager->remove($horaire);
        $this->entityManager->flush();
    }
}
