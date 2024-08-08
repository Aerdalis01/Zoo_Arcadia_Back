<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    #[Route('/avis', name: 'avis')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avis = new Avis();
        $form = $this->createForm(AvisType::class, $avis);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $avis->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($avis);
            $entityManager->flush();

            $this->addFlash('success', 'Votre avis a été soumis avec succès.');

            return $this->redirectToRoute('avis');
        }

        return $this->render('avis/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
