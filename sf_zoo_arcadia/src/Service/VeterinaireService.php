<?php

namespace App\Service;

use App\Entity\CommentairesHabitat;
use App\Entity\Veterinaire;
use App\Entity\Habitats;
use App\Entity\Animaux;
use App\Entity\CompteRenduVet;
use App\Repository\CompteRenduVetRepository;
use App\Repository\HabitatsRepository;
use App\Repository\RapportAlimentationRepository;
use Doctrine\ORM\EntityManagerInterface;

class VeterinaireService
{
    private $entityManager;
    private $compteRenduVetRepository;
    private $habitatsRepository;
    private $rapportAlimentationRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CompteRenduVetRepository $compteRenduVetRepository,
        HabitatsRepository $habitatRepository,
        RapportAlimentationRepository $rapportAlimentationRepository
    ) {
        $this->entityManager = $entityManager;
        $this->compteRenduVetRepository = $compteRenduVetRepository;
        $this->habitatsRepository = $habitatRepository;
        $this->rapportAlimentationRepository = $rapportAlimentationRepository;
    }

    
    public function remplirCompteRenduVet($data)
    {
        
        /** @var Animaux $animal */
        $animal = $data['animaux'];
        /** @var Veterinaire $veterinaire */
        $veterinaire = $data['veterinaire'];

        $compteRendu = new CompteRenduVet();
        $compteRendu->setCommentaireEtat($data['commentaireEtat']);
        $compteRendu->setCreatedAt(new \DateTimeImmutable());
        $compteRendu->setVeterinaire($veterinaire);
        $compteRendu->setAnimaux($animal); // Associer le compte rendu à l'animal

        $this->entityManager->persist($compteRendu);
        $this->entityManager->flush();
    }


    public function ajouterCommentaire(Veterinaire $veterinaire, Habitats $habitat, string $contenu)
    {
        $commentaire = new CommentairesHabitat();
        $commentaire->setCommentaireHabitat($contenu);
        $commentaire->setCreatedAt(new \DateTimeImmutable());
        $commentaire->setVeterinaire($veterinaire);
        $commentaire->setHabitat($habitat);

        $this->entityManager->persist($commentaire);
        $this->entityManager->flush();

        return $commentaire;
    }

    
    public function consulterRapportAlimentation($animalId)
    {
        return $this->rapportAlimentationRepository->findBy(['animal' => $animalId]);
    }
}
