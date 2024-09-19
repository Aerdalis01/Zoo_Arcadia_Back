<?php

namespace App\Service;

use App\Repository\AvisRepository;
use App\Repository\ContactRepository;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\MailerService;
use Psr\Log\LoggerInterface;

class EmployeService
{
    private $entityManager;
    private $avisRepository;
    private $contactRepository;
    private $serviceRepository;
    private $mailerService;
    private $logger;


    public function __construct(
        EntityManagerInterface $entityManager,
        AvisRepository $avisRepository,
        ContactRepository $contactRepository,
        ServicesRepository $serviceRepository,
        MailerService $mailerService,
        LoggerInterface $logger
        ) {
        $this->entityManager = $entityManager;
        $this->avisRepository = $avisRepository;
        $this->contactRepository = $contactRepository;
        $this->serviceRepository = $serviceRepository;
        $this->mailerService = $mailerService;
        $this->logger = $logger;
    }

    public function validerAvis($avisId)
    {
        $avis = $this->avisRepository->find($avisId);
        if ($avis) {
            $avis->setValide(true);
            $this->entityManager->flush();
            $this->logger->info("Avis $avisId validé par l'employé.");
        } else {
            $this->logger->warning("Tentative de validation d'un avis non trouvé : $avisId.");
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
        if (isset($data['nomService'])) {
            $service->setNomService($data['nomService']);
        }
        if (isset($data['titreService'])) {
            $service->setTitreService($data['titreService']);
        }
        if (isset($data['description'])) {
            $service->setDescription($data['description']);
        }

        $this->entityManager->flush();
    }
  }
}
