<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Form\HabitatsType;
use App\Service\HabitatsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/habitats', name: 'app_api_habitats_')]
class HabitatsController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private HabitatsService $habitatsService;

    public function __construct(EntityManagerInterface $entityManager, HabitatsService $habitatsService)
    {
        $this->entityManager = $entityManager;
        $this->habitatsService = $habitatsService;
    }

    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $habitats = $this->entityManager->getRepository(Habitats::class)->findAll();

        return $this->json($habitats);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $habitat = new Habitats();
        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $habitat = $this->habitatsService->createHabitat(
                $data->getNom(),
                $data->getDescription(),
                $data->getZooArcadia()
            );

            foreach ($data->getImages() as $image) {
                $habitat->addImage($image);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('habitats_index');
        }

        return $this->render('habitats/new.html.twig', [
            'habitat' => $habitat,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'habitats_show', methods: ['GET'])]
    public function show(Habitats $habitat): Response
    {
        return $this->render('habitats/show.html.twig', [
            'habitat' => $habitat,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habitats $habitat): Response
    {
        $form = $this->createForm(HabitatsType::class, $habitat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $habitat = $this->habitatsService->updateHabitat($habitat, [
                'nom' => $data->getNom(),
                'description' => $data->getDescription(),
            ]);

            foreach ($data->getImages() as $image) {
                $habitat->addImage($image);
            }

            $this->entityManager->flush();

            return $this->redirectToRoute('habitats_index');
        }

        return $this->render('habitats/edit.html.twig', [
            'habitat' => $habitat,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Habitats $habitat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$habitat->getId(), $request->request->get('_token'))) {
            $this->habitatsService->deleteHabitat($habitat);
        }

        return $this->redirectToRoute('habitats_index');
    }
}
