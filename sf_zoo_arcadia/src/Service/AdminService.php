<?php

namespace App\Service;

use App\Entity\Employe;
use App\Entity\Veterinaire;
use App\Repository\ConsultationRepository;
use App\Repository\CompteRenduVetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminService
{
    private $entityManager;
    
    private $consultationRepository;
    private $compteRenduVetRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ConsultationRepository $consultationRepository,
        CompteRenduVetRepository $compteRenduVetRepository
    ) {
        $this->entityManager = $entityManager;
        $this->consultationRepository = $consultationRepository;
        $this->compteRenduVetRepository = $compteRenduVetRepository;
    }


    public function getDashboardData()
    {
        
        $consultations = $this->consultationRepository->findAll();
        
        $compteRendus = $this->compteRenduVetRepository->findAll();

        
        return [
            'consultations' => $consultations,
            'compteRendus' => $compteRendus,
        ];
    }
}