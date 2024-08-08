<?php

namespace App\Controller;

use App\Entity\RapportAlimentation;
use App\Form\RapportAlimentationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RapportAlimentationController extends AbstractController
{
    #[Route('/rapport-alimentation', name: 'rapport_alimentation')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rapport = new RapportAlimentation();
        $form = $this->createForm(RapportAlimentationType::class, $rapport);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rapport->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($rapport);
            $entityManager->flush();

            $this->addFlash('success', 'Le rapport d\'alimentation a été enregistré avec succès.');

            return $this->redirectToRoute('rapport_alimentation');
        }

        return $this->render('rapport_alimentation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
