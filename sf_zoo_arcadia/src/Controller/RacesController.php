<?php

namespace App\Controller;

use App\Entity\Races;
use App\Form\RacesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RacesController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/races/new', name: 'races_new')]
    public function new(Request $request): Response
    {
        $race = new Races('');
        $form = $this->createForm(RacesType::class, $race);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($race);
            $this->entityManager->flush();

            return $this->redirectToRoute('races_list');
        }

        return $this->render('races/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/races/{id}/edit', name: 'races_edit')]
    public function edit(Request $request, Races $race): Response
    {
        $form = $this->createForm(RacesType::class, $race);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('races_list');
        }

        return $this->render('races/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
