<?php

namespace App\Controller;

use App\Entity\Animaux;
use App\Form\AnimauxType;
use App\Service\AnimauxService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimauxController extends AbstractController
{
    private AnimauxService $animalService;

    public function __construct(AnimauxService $animalService)
    {
        $this->animalService = $animalService;
    }

    #[Route('/animal/create', name: 'animal_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $form = $this->createForm(AnimauxType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $imageFile = $form->get('imagePath')->getData();

            // Handle file upload
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception
                }
            }

            $this->animalService->createAnimal(
                $data->getPrenom(),
                $data->getCreatedAt(),
                $data->getRace()->getId(),
                $newFilename,
                $data['imageAlt']
            );

            return $this->redirectToRoute('animal_list');
        }

        return $this->render('animal/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/animal/{id}/edit', name: 'animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animaux $animal): Response
    {
        $form = $this->createForm(AnimauxType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $imageFile = $form->get('imagePath')->getData();

            // Handle file upload
            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception
                }
            }

            $this->animalService->updateAnimal($animal, [
                'prenom' => $data->getPrenom(),
                'createdAt' => $data->getCreatedAt(),
                'raceId' => $data->getRace()->getId(),
                'imagePath' => $newFilename ?? null,
                'imageAlt' => $data['imageAlt'],
            ]);

            return $this->redirectToRoute('animal_list');
        }

        return $this->render('animal/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/animal/{id}/delete', name: 'animal_delete', methods: ['POST'])]
    public function delete(Request $request, Animaux $animal): Response
    {
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->request->get('_token'))) {
            $this->animalService->deleteAnimal($animal);
        }

        return $this->redirectToRoute('animal_list');
    }
}
