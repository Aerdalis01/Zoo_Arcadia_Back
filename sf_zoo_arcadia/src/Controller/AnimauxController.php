<?php

// src/Controller/AnimauxController.php
namespace App\Controller;

use App\Entity\Animaux;
use App\Form\AnimauxType;
use App\Service\AnimauxService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/animaux')]
class AnimauxController extends AbstractController
{
    private AnimauxService $animauxService;

    public function __construct(AnimauxService $animauxService)
    {
        $this->animauxService = $animauxService;
    }

    #[Route('/', name: 'animal_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animaux = $entityManager->getRepository(Animaux::class)->findAll();

        return $this->json($animaux);
    }

    #[Route('/new', name: 'animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $animal = new Animaux();
        $form = $this->createForm(AnimauxType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->animauxService->createAnimal(
                $data->getPrenom(),
                $data->getRace()->getName(),
                $form->get('imagePath')->getData(),
                $form->get('imageSubDirectory')->getData(),
                $data->getHabitat(),
                $data->getZooArcadia()
            );

            return $this->redirectToRoute('animal_index');
        }

        return $this->render('animal/new.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'animal_show', methods: ['GET'])]
    public function show(Animaux $animal): Response
    {
        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/{id}/edit', name: 'animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animaux $animal): Response
    {
        $form = $this->createForm(AnimauxType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->animauxService->updateAnimal($animal, [
                'prenom' => $data->getPrenom(),
                'createdAt' => $data->getCreatedAt()->format('Y-m-d H:i:s'),
                'raceName' => $data->getRace()->getName(),
                'imagePath' => $form->get('imagePath')->getData(),
                'imageSubDirectory' => $form->get('imageSubDirectory')->getData(),
                'habitat' => $data->getHabitat(),
                'zooArcadia' => $data->getZooArcadia()
            ]);

            return $this->redirectToRoute('animal_index');
        }

        return $this->render('animal/edit.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animaux $animal): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->request->get('_token'))) {
            $this->animauxService->deleteAnimal($animal);
        }

        return $this->redirectToRoute('animal_index');
    }
}
