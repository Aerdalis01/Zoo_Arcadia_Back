<?php

namespace App\Service;

use App\Entity\Consultation;
use App\Repository\ConsultationRepository;
use Doctrine\ORM\EntityManagerInterface;

class ConsultationService
{
    private $entityManager;
    private $consultationRepository;

    public function __construct(EntityManagerInterface $entityManager, ConsultationRepository $consultationRepository)
    {
        $this->entityManager = $entityManager;
        $this->consultationRepository = $consultationRepository;
    }

    public function trackConsultation($animalId)
    {
        $consultation = new Consultation();
        $consultation->setAnimal($animalId);
        $consultation->setDate(new \DateTime());

        $this->entityManager->persist($consultation);
        $this->entityManager->flush();
    }

    public function getConsultationStatistics()
    {
        // Logique pour récupérer et retourner les statistiques des consultations
        return $this->consultationRepository->findAll();
    }
}
