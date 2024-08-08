<?php

namespace App\Service;

use App\Repository\AvisRepository;
use App\Repository\ContactRepository;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\MailerService;

class EmployeService
{
    private $entityManager;
    private $avisRepository;
    private $contactRepository;
    private $serviceRepository;
    private $mailerService;

    public function __construct(
        EntityManagerInterface $entityManager,
        AvisRepository $avisRepository,
        ContactRepository $contactRepository,
        ServicesRepository $serviceRepository,
        MailerService $mailerService
    ) {
        $this->entityManager = $entityManager;
        $this->avisRepository = $avisRepository;
        $this->contactRepository = $contactRepository;
        $this->serviceRepository = $serviceRepository;
        $this->mailerService = $mailerService;
    }

    public function validerAvis($avisId)
    {
        $avis = $this->avisRepository->find($avisId);
        if ($avis) {
            $avis->setValide(true);
            $this->entityManager->flush();
        }
    }
    public function invaliderAvis($avisId)
    {
        $avis = $this->avisRepository->find($avisId);
        if ($avis) {
            $avis->setValide(false);
            $this->entityManager->flush();
        }
    }

    public function repondreContact($contactId, $reponse)
    {
        $contact = $this->contactRepository->find($contactId);
        if ($contact) {
            $this->mailerService->sendContactMessage($contact->getEmail(), "Réponse à votre message", $reponse);
        }
    }

    public function mettreAJourService($serviceId, $data)
    {
        $service = $this->serviceRepository->find($serviceId);
        if ($service) {
            // Mise à jour du service avec les nouvelles données
            $this->entityManager->flush();
        }
    }
}
