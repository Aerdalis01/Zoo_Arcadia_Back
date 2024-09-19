<?php

namespace App\Controller;

use App\Entity\Animaux;
use App\Entity\CompteRenduVet;
use App\Form\CompteRenduVetType;
use App\Service\VeterinaireService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/veterinaire', name: 'app_veterinaire_')]
class VeterinaireController extends AbstractController
{
    private VeterinaireService $veterinaireService;
    private EntityManagerInterface $entityManager;

    public function __construct(VeterinaireService $veterinaireService, EntityManagerInterface $entityManager)
    {
        $this->veterinaireService = $veterinaireService;
        $this->entityManager = $entityManager;
    }


    #[Route('/rapport-alimentation/{animalId}', name: 'rapport_alimentation', methods: ['GET'])]
    public function consulterRapportAlimentation(int $animalId): Response
    {
        $rapports = $this->veterinaireService->consulterRapportAlimentation($animalId);

        if (!$rapports) {
            return $this->json(['error' => 'No reports found for this animal'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($rapports);
    }

    #[Route('/compte-rendu/create/{animalId}', name: 'compte_rendu_create', methods: ['GET', 'POST'])]
    public function createCompteRendu(Request $request, int $animalId): Response
    {
        $animal = $this->entityManager->getRepository(Animaux::class)->find($animalId);
        if (!$animal) {
            return $this->json(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        $compteRendu = new CompteRenduVet();
        $compteRendu->setAnimaux($animal); 
        $form = $this->createForm(CompteRenduVetType::class, $compteRendu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->veterinaireService->remplirCompteRenduVet([
                'commentaireEtat' => $form->get('commentaireEtat')->getData(),
                'animaux' => $animal,
                'veterinaire' => $this->getUser(), 
            ]);

            return $this->redirectToRoute('app_veterinaire_liste_comptes_rendus');
        }

        return $this->render('veterinaire/compte_rendu.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/comptes-rendus', name: 'liste_comptes_rendus', methods: ['GET'])]
    public function listerComptesRendus(): Response
    {
        $veterinaire = $this->getUser(); 
        $comptesRendus = $this->entityManager->getRepository(CompteRenduVet::class)->findBy(['veterinaire' => $veterinaire]);

        if (!$comptesRendus) {
            return $this->json(['error' => 'No report found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($comptesRendus);
    }
}
