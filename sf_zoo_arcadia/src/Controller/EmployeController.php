<?php

namespace App\Controller;

use App\Service\EmployeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeController extends AbstractController
{
    private $employeService;

    public function __construct(EmployeService $employeService)
    {
        $this->employeService = $employeService;
    }

    #[Route('/valider-avis/{id}', name: 'valider_avis')]
    public function validerAvis($id): Response
    {
        $this->employeService->validerAvis($id);

        return new Response('Avis validé avec succès');
    }

    #[Route('/invalider-avis/{id}', name: 'invalider_avis')]
    public function invaliderAvis($id): Response
    {
        $this->employeService->invaliderAvis($id);

        return new Response('Avis invalidé avec succès');
    }

    #[Route('/repondre-contact/{id}', name: 'repondre_contact')]
    public function repondreContact(Request $request, $id): Response
    {
        $reponse = $request->query->get('reponse');
        $this->employeService->repondreContact($id, $reponse);

        return new Response('Réponse envoyée avec succès');
    }

    #[Route('/mettre-a-jour-service/{id}', name: 'mettre_a_jour_service')]
    public function mettreAJourService(Request $request, $id): Response
    {
        $data = $request->request->all();
        $this->employeService->mettreAJourService($id, $data);

        return new Response('Service mis à jour avec succès');
    }
}
