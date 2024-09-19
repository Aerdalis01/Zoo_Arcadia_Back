<?php

namespace App\Service;

use App\Entity\Horaires;
use Doctrine\ORM\EntityManagerInterface;

class HorairesService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createHoraire(?string $jour, ?\DateTimeImmutable $heureOuvertureZoo, ?\DateTimeImmutable $heureFermetureZoo, array $horairesServices, ?string $titreHoraire): Horaires
    {
        $horaire = new Horaires();
        if ($jour !== null) {
            $horaire->setJour($jour);
        }
        
        if ($heureOuvertureZoo !== null) {
            $horaire->setHeureOuvertureZoo($heureOuvertureZoo);
        }
    
        if ($heureFermetureZoo !== null) {
            $horaire->setHeureFermetureZoo($heureFermetureZoo);
        }
        $horaire->setHorairesServices($horairesServices);
        $horaire->setTitreHoraire($titreHoraire);

        $this->entityManager->persist($horaire);
        $this->entityManager->flush();

        return $horaire;
    }

    public function updateHoraire(Horaires $horaire, string $jour, ?\DateTimeImmutable $heureOuvertureZoo, ?\DateTimeImmutable $heureFermetureZoo, array $horairesServices, ?string $titreHoraire): Horaires
    {
        $horaire->setJour($jour);
        $horaire->setHeureOuvertureZoo($heureOuvertureZoo);
        $horaire->setHeureFermetureZoo($heureFermetureZoo);
        $horaire->setHorairesServices($horairesServices);
        $horaire->setTitreHoraire($titreHoraire);

        $this->entityManager->flush();

        return $horaire;
    }

    public function deleteHoraire(Horaires $horaire): void
    {
        $this->entityManager->remove($horaire);
        $this->entityManager->flush();
    }
}
